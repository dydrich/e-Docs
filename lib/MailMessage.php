<?php
/**
 * Created by PhpStorm.
 * User: rb
 * Date: 07/10/17
 * Time: 16.10
 */

namespace edocs;


/**
 * A simple MailMessage class (like a Java Bean)
 * @author cravenroad17@gmail.com
 *
 */
class MailMessage{

    private $from;
    private $to;
    private $attachements = array();
    private $attachContentTypes = array();
    private $boundary;
    private $header;
    private $body;
    private $subject;

    public function __construct($from, $to = null, $subject = null){
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->createBoundary();
    }

    public function setFrom($from){
        $this->from = $from;
    }

    public function getFrom(){
        return $this->from;
    }

    public function setTo($to){
        $this->to = $to;
    }

    public function getTo(){
        return $this->to;
    }

    public function addAttachement($att){
        array_push($this->attachements, $att);
        array_push($this->attachContentTypes, MimeType::getMimeContentType($att));
    }

    public function getAttachements(){
        return $this->attachements;
    }

    public function getBody(){
        return $this->body;
    }

    public function hasAttachements(){
        return count($this->attachements) > 0;
    }

    public function setHeader(){
        $this->header = "Reply-to: ".$this->getFrom()."\r\n";
        if($this->hasAttachements()){
            $this->header = "MIME-Version: 1.0\r\n";
            $this->header .= "Content-Type: multipart/mixed;boundary=\"".$this->getBoundary()."\"";
            $this->header .= "\r\n\r\nThis is a multi-part message in MIME format\r\n\r\n";
        }
    }

    public function getHeader(){
        return $this->header;
    }

    public function createBoundary(){
        $this->boundary = md5(uniqid(time));
    }

    public function getBoundary(){
        return $this->boundary;
    }

    public function createBody($txt){
        if($this->hasAttachements()){
            $this->body = "--".$this->getBoundary()."\r\n";
            $this->body .= "Content-Type: text/plain; charset=iso-8859-1\r\nContent-Transfer-Encoding: 7bit\r\n\r\n";
            $this->body .= $txt."\r\n\r\n";

            for($i = 0; $i < count($this->getAttachements()); $i++){
                $this->body .= "--".$this->getBoundary()."\r\n";
                $this->body .= "Content-Type: ".$this->attachContentTypes[$i]."; name=\"".basename($this->attachements[$i])."\"\r\n";
                $this->body .= "Content-Transfer-Encoding: base64\r\n";
                $this->body .= "Content-Disposition: attachment; filename=\"".basename($this->attachements[$i])."\"\r\n\r\n";
                $fp = fopen($this->attachements[$i], "r");
                $text = fread($fp, filesize($this->attachements[$i]));
                $text = chunk_split(base64_encode($text));
                fclose($fp);
                $this->body .= $text."\r\n\r\n";
            }
            $this->body .= "--".$this->getBoundary()."--";
        }
        else{
            $this->body = $txt;
        }
    }

    public function setSubject($sub){
        $this->subject = $sub;
    }

    public function getSubject(){
        return $this->subject;
    }
}