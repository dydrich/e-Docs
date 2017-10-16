var logged = false;

function include_dom(script_filename) {
    var html_doc = document.getElementsByTagName('head').item(0);
    var js = document.createElement('script');
    js.setAttribute('language', 'javascript');
    js.setAttribute('type', 'text/javascript');
    js.setAttribute('src', script_filename);
    html_doc.appendChild(js);
    return false;
}

function coming_soon(){
    alert('Coming soon');
}

function trim (str) {
	str = str.replace(/^\s+/, '');
	for (var i = str.length - 1; i >= 0; i--) {
		if (/\S/.test(str.charAt(i))) {
			str = str.substring(0, i + 1);
			break;
		}
	}
	return str;
}


function register(){
    coming_soon();
}

function do_logout(){
    document.location.href = "/logout.php";
}

function in_array(ar, val){
    //alert("==="+val+"===");
    for(var i = 0; i < ar.length; i++)
        if(ar[i] == val)
            return true;

    return false;
}

window.open_centered = function(url, name, width, height, options){
	var leftS = (screen.width - width) / 2;
	var topS = (screen.height - height) / 2;
	var pop = this.open(url, name, 'width='+width+', height='+height+', left='+leftS+', top='+topS);
	return pop;
};

Array.prototype.remove_by_value = function(val) {
    for(var i=0; i<this.length; i++) {
        if (this[i] === val) {
            this.splice(i, 1);
            break;
        }
    }
};

window.sqlalert = function(){
	j_alert("error", "Si è verificato un errore. Si prega di contattare il responsabile del software per la risoluzione", 3);
};

function fade(id, io, tm, opacity) {
    var el = document.getElementById(id);
    io === "in" ? el.style.opacity = opacity : el.style.opacity = 0;
    el.style.transition = "opacity " + tm + "s";
    el.style.WebkitTransition = "opacity " + tm + "s";
    if (io === 'out') {
        window.setTimeout(function () {
            el.style.display = 'none';
        }, tm);
    }
}

var load_jalert = function(){
    document.getElementById('nobutton').addEventListener('click', function (event) {
        event.preventDefault();
        fade('overlay', 'out', 100);
        fade('confirm', 'out', 300);
        return false;
    })
};

var j_alert = function(type, msg){
    var mtop = mleft = 0;
    mtop = screen.height / 3;
    mleft = (screen.width - 300) / 2;
    if (type === "alert") {
        document.getElementById('alertmessage').innerText = msg;
        var _alert = document.getElementById('alert');
        overlay = document.getElementById('overlay');
        overlay.style.opacity = 0;
        overlay.style.display = 'block';
        _alert.style.opacity = 0;
        _alert.style.display = 'block';
        _alert.style.top = mtop+"px";
        _alert.style.left = mleft+"px";
        fade('overlay', 'in', .1, .3);
        fade('alert', 'in', .3, 1);
        window.setTimeout(function(){
            fade('alert', 'out', .5, 0);
            fade('overlay', 'out', .1, 0);
        }, 2500);
    }
    else if (type === "error") {
        document.getElementById('errormessage').innerHTML = msg;
        _alert = document.getElementById('error');
        _alert.style.top = mtop;
        _alert.style.left = mleft;
        fade('overlay', 'in', 100);
        fade('error', 'in', 300);
        window.setTimeout(function(){
            fade('error', 'out', 500);
            fade('overlay', 'out', 100);
        }, 2500);
    }
    else if (type === "confirm") {
        var confirmmessage = document.getElementById('confirmmessage');
        confirmmessage.innerHTML = msg;
        confirmmessage.style.height = '50px';
        var _confirm = document.getElementById('confirm');
        overlay = document.getElementById('overlay');
        _confirm.style.opacity = 0;
        _confirm.style.display = 'block';
        _confirm.style.top = mtop+"px";
        _confirm.style.left = mleft+"px";
        _confirm.style.minHeight = '170px';
        overlay.style.opacity = 0;
        overlay.style.display = 'block';
        fade('overlay', 'in', .1, .3);
        fade('confirm', 'in', .3, 1);
    }
    else if (type === 'working') {
        var _i = document.querySelector('#alert .alert_title i');
        _i.classList.remove('fa-thumbs-up');
        _i.classList.add('fa-circle-o-notch fa-spin');
        _span = document.querySelector('#alert .alert_title span');
        _span.innerText = 'Attendi';
        document.getElementById('alertmessage').innerText = msg;
        _alert = document.getElementById('error');
        _alert.style.top = mtop;
        _alert.style.left = mleft;
        fade('overlay', 'in', 100);
        fade('alert', 'in', 300);
    }
};


/*
codice per la visualizzazione durante processi in background
versione per jquery
 */
var exec_code;
var bckg_timer;
var background_process = function(msg, tm, show_progress) {
    $('#background .alert_title i').removeClass("fa-thumbs-up").addClass("fa-circle-o-notch fa-spin");
    $('#background .alert_title span').text("Attendi");
    $('#background_msg').text(msg);
    /*
    $('#background_msg').dialog({
        autoOpen: true,
        dialogClass: 'no_display ui-state-highlight',
        show: {
            effect: "fadeIn",
            duration: 800
        },
        hide: {
            effect: "fadeOut",
            duration: 1000
        },
        modal: true,
        width: 200,
        title: '',
        open: function(event, ui){

        }
    });
    */
    var mtop = mleft = 0;
    mtop = screen.height / 3;
    mleft = (screen.width - 300) / 2;
    $('#background').css({
        top: mtop,
        left: mleft
    });
    $('#overlay').fadeIn(100);
    $('#background').fadeIn(300);

    timeout = tm;
    bckg_timer = setTimeout(function() {
        background_progress(msg, show_progress);
    }, 1000);
};

var background_progress = function(msg, show_progress) {
    timeout--;
    if (timeout > 0) {
        if (show_progress) {
            tm++;
            //alert(tm);
            if(tm > 5){
                tm = 0;
                msg = msg.substr(0, msg.length - 5);
                $('#background_msg').text(msg);
            }
            else {
                msg += ".";
                $('#background_msg').text(msg);
            }
        }
        bckg_timer = setTimeout(
            function() {
                background_progress(msg, show_progress);
            },
            1000
        );
    }
    else{
        loaded("Operazione completata");
    }
};

var loaded = function(txt) {
    clearTimeout(bckg_timer);
    $('#background .alert_title i').removeClass("fa-circle-o-notch fa-spin").addClass("fa-thumbs-up");
    $('#background .alert_title span').text("Successo");
    $('#background_msg').text(txt);
    setTimeout(function() {
        $('#background').fadeOut();
        $('#overlay').fadeOut();
    }, 2000);
};

var loaded_with_error = function(txt) {
    clearTimeout(bckg_timer);
    $('#background').hide();
    j_alert("error", txt);
};

var loading = function(string, time){
    background_process(string, time);
};
var tm = 0;

var show_drawer = function(e) {
    if ($('#drawer').is(':visible')) {
        $('#drawer').hide('slide', 500);
        $('#overlay').hide();
        return false;
    }
    var offset = $('#main').offset();
    tempY = offset.top;
    tempX = offset.left;
    $('#drawer').css({top: parseInt(tempY)+"px"});
    $('#drawer').css({left: parseInt(tempX)+"px"});
    $('#overlay').show();
    $('#drawer').show('slide', 500);
    return false;
};

var setOverlayEvent = function() {
    $('#overlay').click(function(event) {
        if ($('#overlay').is(':visible')) {
            show_drawer(event);
        }
    });
    $('#open_drawer').click(function(event){
        show_drawer(event);
    });
};

var show_error = function(error) {
    j_alert("error", error);
};