<?php
/**
 * Created by PhpStorm.
 * User: rb
 * Date: 07/10/17
 * Time: 16.11
 */

namespace edocs;


abstract class CustomException extends Exception{
    protected $message = 'Unknown exception';     // Exception message
    private $string;                              // Unknown
    protected $code = 0;                          // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private $trace;                               // Unknown


    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }

    public function __toString(){
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n" . "{$this->getTraceAsString()}";
    }
}