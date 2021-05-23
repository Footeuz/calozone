/* global base_url */
var tradTable = [];

function redirect(url){
	window.location.href=url;
}

function post(req_url, params, fct){
    if(req_url.lastIndexOf('http://') !== 0 &&
       req_url.lastIndexOf('https://') !== 0 ) req_url = base_url+req_url;

    post_xhr_object = new XMLHttpRequest();
    post_xhr_object.onreadystatechange = function(){
        if(post_xhr_object.readyState >= 4 && post_xhr_object.status == 200){
            if (post_xhr_object.responseText.substr(0, 6) == 'Erreur' || post_xhr_object.responseText.substr(0, 5) == 'mysql') {
                oid('alert').childNodes[0].innerHTML = post_xhr_object.responseText;
                oid('alert').style.display = 'block';
            }
            else {
                fct(post_xhr_object.responseText);
                oid('alert').childNodes[0].innerHTML = post_xhr_object.responseText;
                oid('alert').style.display = 'block';
                setTimeout(function() {
                    oid('alert').style.display = 'none';
                }, 5000);
            }
        }
    };

    post_xhr_object.open("POST", req_url, true);
    if(typeof params === "string") post_xhr_object.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    post_xhr_object.send(params);
}


function postNDisplay(req_url, iddiv, strpost, iddivfailed, fct){
    req_url = base_url+req_url;

    oid(iddiv);

    xhr_object = new XMLHttpRequest();
    xhr_object.onreadystatechange = function(){
        if(xhr_object.readyState >= 4){
            if(xhr_object.status == 200){
                var resp = xhr_object.responseText;
                if('<!DOCTYPE html' == resp.substr(0, 14)) redirect(base_url);
                else if('<! failed !>' == resp.substr(0, 12)){
                    resp = resp.substr(12, resp.length-1);
                    oid(iddivfailed).innerHTML=resp;
                    if(fct) fct(false);
                }
                else{
                    if(iddiv!==''){
                        oid(iddiv).innerHTML=resp;

                        var elts = oid(iddiv).getElementsByTagName('script');
                        var i=0;
                        for(i;i<elts.length;i++) eval(elts[i].innerHTML);
                    }

                    if(fct) fct(true);
                }
            }
        }
    };

    xhr_object.open("POST", req_url, true);
    xhr_object.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr_object.send(strpost);
}

function selectValue(idselect){
	return document.getElementById(idselect).options[document.getElementById(idselect).selectedIndex].value;
}

function oid(id){
	return document.getElementById(id);
}

function isInt(x) {
	var y=parseInt(x);
	if (isNaN(y)) return false;
	return x==y && x.toString()==y.toString();
} 


function inArray(array, p_val) {
    var l = array.length;
    for(var i = 0; i < l; i++) {
        if(array[i] == p_val) {
            rowid = i;
            return true;
        }
    }
    return false;
}


function getScrollPosition(){
    return Array((document.documentElement && document.documentElement.scrollLeft) || window.pageXOffset || self.pageXOffset || document.body.scrollLeft,(document.documentElement && document.documentElement.scrollTop) || window.pageYOffset || self.pageYOffset || document.body.scrollTop);
}

function trim(str){
	return str.replace(/^\s+/g,'').replace(/\s+$/g,'');
} 


function submitForm(pId, cb, action){
    var formData = new FormData();

    var form = oid(pId);
    var inputs = form.getElementsByTagName('input');
    var selects = form.getElementsByTagName('select');
    var textareas = form.getElementsByTagName('textarea');
    
    for(var i = 0; i<inputs.length; i++){
        if((inputs[i].type !== 'checkbox' && inputs[i].type !== 'radio') || inputs[i].checked){
            formData.append(inputs[i].name, inputs[i].value);
        }
        if(inputs[i].type === 'file'){
            for(var x = 0; x<inputs[i].files.length; x++) {
                formData.append(inputs[i].name+x, inputs[i].files[x]);
            }
        }
    }

    for(var i = 0; i<selects.length; i++){
        formData.append(selects[i].name, selects[i].value);
    }
    
    for(var i = 0; i<textareas.length; i++){
        formData.append(textareas[i].name, textareas[i].value);
    }
    
    if(!action) action = form.action;
    post(action, formData, cb);
    return false;
}

function generate(campaignid){

    var form = oid('code_generate_form');
    var nb = oid('nb');

    var xhr = new XMLHttpRequest();
    xhr.open('GET', form.action+'?campaignid='+campaignid+'&nb='+nb.value, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(null);

    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4 && xhr.status == 200) {
            oid('alert').childNodes[0].innerHTML = xhr.responseText;
            oid('alert').style.display = 'block';
            setTimeout(function() {
                oid('alert').style.display = 'none';
            }, 5000);
        }
    };

    return false;
}

function import_mail(campaignid){

    var form = oid('mail_import_form');
    var xhr = new XMLHttpRequest();

    // list of emails in the file uploaded
    var fileemails = oid('fileemails');
    if (typeof (fileemails) != null && fileemails != null) {
        var f = fileemails.files[0];

        if (f) {
            var r = new FileReader();
            r.onload = function(e) {
                var contents = e.target.result;

                contents.trim();
                contents = contents.replace(/\r\n/g, ";");
                contents = contents.replace(/\r/g, ";");
                contents = contents.replace(/\n/g, ";");

                xhr.open('GET', form.action+'?campaignid='+campaignid+'&emails='+contents, true);
                     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                     xhr.send(null);

                     xhr.onreadystatechange = function()
                     {
                     if (xhr.readyState == 4 && xhr.status == 200) {
                     oid('alert').childNodes[0].innerHTML = xhr.responseText;
                     oid('alert').style.display = 'block';
                     setTimeout(function() {
                     oid('alert').style.display = 'none';
                     }, 5000);
                     }
                };

            }
            r.readAsText(f);
        }
    }

    // list of emails in textarea
    var emails = oid('list_mail');
    if (emails.value.trim() != '') {
        xhr.open('GET', form.action+'?campaignid='+campaignid+'&emails='+emails.value, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(null);

        xhr.onreadystatechange = function()
        {
            if (xhr.readyState == 4 && xhr.status == 200) {
                oid('alert').childNodes[0].innerHTML = xhr.responseText;
                oid('alert').style.display = 'block';
                setTimeout(function() {
                    oid('alert').style.display = 'none';
                }, 5000);
            }
        };
    }



    return false;
}

/**
 * Translate a string
 * @param {string} tr = language
 * @returns {string}
 */
function trad(tr){
    
    if(tradTable[tr]) return tradTable[tr];
    else{
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'https://stephanie.local/betatesting/utils/missingtrad.php?trad='+tr, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(null);

    }
    return tr;
}
