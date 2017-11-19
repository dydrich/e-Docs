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
    el.style.transition = "opacity " + tm + "ms";
    el.style.WebkitTransition = "opacity " + tm + "ms";
    if (io === 'out') {
        tm += 10;
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
        window.setTimeout(function(){
            fade('overlay', 'in', .1, .3);
            fade('alert', 'in', .3, 1);
        }, 10);
        window.setTimeout(function(){
            fade('alert', 'out', 500, 0);
            fade('overlay', 'out', 100, 0);
        }, 2500);
    }
    else if (type === "error") {
        document.getElementById('errormessage').innerHTML = msg;
        _alert = document.getElementById('error');
        overlay = document.getElementById('overlay');
        overlay.style.opacity = 0;
        overlay.style.display = 'block';
        _alert.style.opacity = 0;
        _alert.style.display = 'block';
        _alert.style.top = mtop+"px";
        _alert.style.left = mleft+"px";
        window.setTimeout(function(){
            fade('overlay', 'in', .1, .3);
            fade('error', 'in', .3, 1);
        }, 10);
        window.setTimeout(function(){
            fade('error', 'out', 500, 0);
            fade('overlay', 'out', 100, 0);
        }, 2500);
    }
    else if (type === "information") {
        var field = msg.data_field;
        var infomessage = document.getElementById('infomessage');
        var _text = '';
        if (field === 'user') {
            // show user account data
            _text = 'Username: '+msg.user.login;
            _text += '\n';
            _text += 'Password: '+msg.user.password;
        }
        infomessage.innerHTML = _text;
        var span = document.querySelector('#information .confirm_title span');
        span.innerText = msg.message;
        infomessage.style.height = '50px';
        var _info = document.getElementById('information');
        overlay = document.getElementById('overlay');
        _info.style.opacity = 0;
        _info.style.display = 'block';
        _info.style.top = mtop+"px";
        _info.style.left = mleft+"px";
        _info.style.minHeight = '170px';
        overlay.style.opacity = 0;
        overlay.style.display = 'block';
        window.setTimeout(function () {
            fade('overlay', 'in', 100, .3);
            fade('information', 'in', 300, 1);
        }, 10);
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
        window.setTimeout(function () {
            fade('overlay', 'in', 100, .3);
            fade('confirm', 'in', 300, 1);
        }, 10);

    }
    else if (type === 'working') {
        var _i = document.querySelector('#alert .alert_title i');
        _span = document.querySelector('#alert .alert_title span');
        _span.innerText = 'Attendi';
        document.getElementById('alertmessage').innerText = msg;
        _alert = document.getElementById('error');
        _alert.style.top = mtop;
        _alert.style.left = mleft;
        window.setTimeout(function () {
            fade('overlay', 'in', 100, .3);
            fade('confirm', 'in', 300, 1);
        }, 10);
    }
};

var show_user_menu = function (event) {
    event.preventDefault();
    var menu = document.getElementById('user_menu');
    if (menu.style.display === 'block') {
        window.setTimeout(function () {
            fade('user_menu', 'out', 500, 0);
        }, 10);
    }
    else {
        menu.style.opacity = 0;
        var arrow = document.getElementById('arrow');
        var header = document.getElementById('header');
        arrow_coord = arrow.getBoundingClientRect();
        header_coord = header.getBoundingClientRect();
        menu.style.top = parseInt(arrow_coord.bottom)+"px";
        menu.style.left = parseInt(header_coord.right - 250)+"px";
        menu.style.display = 'block';
        window.setTimeout(function () {
            fade('user_menu', 'in', 500, 1);
        }, 10);
    }
};

/*
codice per la visualizzazione dei processi in background

 */
var exec_code;
var bckg_timer;
var background_process = function(msg, tm, show_progress) {
    //document.querySelector('#background .alert_title i').removeClass("fa-thumbs-up").addClass("fa-circle-o-notch fa-spin");
    document.querySelector('#background .alert_title span').innerText = "Attendi";
    document.querySelector('#background_msg').innerText = msg;

    var mtop = mleft = 0;
    mtop = screen.height / 3;
    mleft = (screen.width - 300) / 2;
    document.getElementById('background').style.top = mtop+"px";
    document.getElementById('background').style.left = mleft+"px";
    fade('overlay', 'in', 500, 1);
    fade('background', 'in', 500, 1);

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
                document.getElementById('background_msg').innerText = msg;
            }
            else {
                msg += ".";
                document.getElementById('background_msg').innerText = msg;
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
    document.querySelector('#background .alert_title i').innerText = 'thumb_up';
    document.querySelector('#background .alert_title span').innerText = "Successo";
    document.getElementById('background_msg').innerText = txt;
    window.setTimeout(function() {
        fade('overlay', 'out', 50, 1);
        fade('background', 'out', 50, 1);
    }, 2000);
};

var loaded_with_error = function(txt) {
    clearTimeout(bckg_timer);
    document.getElementById('background').style.display = 'none';
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
