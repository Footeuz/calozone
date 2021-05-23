/**
 * Selectionne un élément par son id
 * @param el
 * @returns {Element}
 */
function oid(el) {
    return document.getElementById(el);
}

function ocd(el) {
    return document.getElementsByClassName(el);
}

function init() {
    if (typeof oid('testid') != null && oid('testid') != null) { starttest(); }
}


/**
 * Change height of main div to fit to page
 */
function fittopage() {
    if (oid("main") != null) {
        // set main div height to fit to page
        var heightw = "innerHeight" in window ? window.innerHeight : document.documentElement.offsetHeight;
        var newh = heightw - 236;
        oid("main").style.height = newh + 'px';

        // set marge up to letters C/D
        var letters = ocd("letter");
        var numbers = ocd("number");
        var allnumbers = (numbers[0].offsetHeight * 5);
        if (window.innerWidth > 1080)
            var marge = (newh - allnumbers - letters[0].offsetHeight - 15);
        else
            var marge = (newh - allnumbers - letters[0].offsetHeight +10);

        if (marge > 0) oid("abcd").style.marginTop = marge + 'px';

        // set game height to fit to page
        if (window.innerWidth > 1080)
            var gameh = oid("mainright").offsetHeight - (oid("headgame").offsetHeight + oid("bonus").offsetHeight)  -26;
        else
            var gameh = oid("mainright").offsetHeight - (oid("headgame").offsetHeight + oid("break").offsetHeight) - 118;
        oid("description").style.height = gameh + 'px';

        // set title width max
        var maxw = oid('headercenter').offsetWidth - 100;
        oid("bg-title-test").style.width = maxw + 'px';
    }
}

/* show pop up rules and initialize functions for click actions */
function starttest() {
    oid('bgreglement').style.display='block';
    oid('popupreglement').style.display='block';

    oid('starttime').value = ~~(Date.now()/1000);
    oid('startquestion').value = ~~(Date.now()/1000);

    oid("btndot").onclick = function() { if (oid("btndot").classList.contains("active")) oid('calcsum').innerHTML = oid('calcsum').innerHTML + ','; };
    for (i=0; i<=9; i++) {
        oid("btn" + i).onclick = function () {
            if (oid('typeid').value == 1
                    || (oid('calcsum').innerHTML.length <= 4 && oid('typeid').value == 10) // code postal : 5 chiffres max
                    || (oid('calcsum').innerHTML.length <= 2 && oid('typeid').value == 8)) // age : 3 chiffres max
                if (this.classList.contains("active")) oid('calcsum').innerHTML = oid('calcsum').innerHTML + this.innerHTML;
        };
    }
    oid("btnReset").onclick = function() { oid('calcsum').innerHTML = ''; };

    oid("btnA").onclick = function() {
        if (oid("btnA").classList.contains("active")) {
            if (oid('typeid').value == 6 || oid('typeid').value == 9 || oid('typeid').value == 7) { // mode AouB ou AouBouCouD ou genre
                oid('choiceabcd').innerHTML = 'A';
            } else { // mode ABCD
                if (oid('choiceabcd').innerHTML.length <= 3 && oid('choiceabcd').innerHTML.indexOf('A') == -1)
                    oid('choiceabcd').innerHTML = oid('choiceabcd').innerHTML + 'A';
            }
        }
    };
    oid("btnB").onclick = function() {
        if (oid("btnB").classList.contains("active")) {
            if (oid('typeid').value == 6 || oid('typeid').value == 9 || oid('typeid').value == 7) { // mode AouB ou AouBouCouD
                oid('choiceabcd').innerHTML = 'B';
            } else { // mode ABCD
                if (oid('choiceabcd').innerHTML.length <= 3 && oid('choiceabcd').innerHTML.indexOf('B') == -1)
                    oid('choiceabcd').innerHTML = oid('choiceabcd').innerHTML + 'B';
            }
        }
    };
    oid("btnC").onclick = function() {
        if (oid("btnC").classList.contains("active")) {
            if (oid('typeid').value == 7) { // mode AouB ou AouBouCouD
                oid('choiceabcd').innerHTML = 'C';
            } else { // mode ABCD
                if (oid('choiceabcd').innerHTML.length <= 3 && oid('choiceabcd').innerHTML.indexOf('C') == -1)
                    oid('choiceabcd').innerHTML = oid('choiceabcd').innerHTML + 'C';
            }
        }
    };
    oid("btnD").onclick = function() {
        if (oid("btnC").classList.contains("active")) {
            if (oid('typeid').value == 7) { // mode AouB ou AouBouCouD
                oid('choiceabcd').innerHTML = 'D';
            } else { // mode ABCD
                if (oid('choiceabcd').innerHTML.length <= 3 && oid('choiceabcd').innerHTML.indexOf('D') == -1)
                    oid('choiceabcd').innerHTML = oid('choiceabcd').innerHTML + 'D';
            }
        }
    };

    oid("btnX").onclick = function() { oid('choiceabcd').innerHTML = ''; };

    for (j=1; j<=4; j++)
        oid("action"+j).onclick = function() { if (this.classList.contains("active")) selectbtn(this.id.replace('action','')); };

    oid("jecraque").onclick = function() {
        if (this.classList.contains("active")) {
            if (!this.classList.contains("selectbtn")) {
                oid('jecraque').classList.add('selectbtn');
                oid('jecraqueclicked').value = 1;
            } else {
                oid('jecraque').classList.remove('selectbtn');
                oid('jecraqueclicked').value = 0;
            }
        }
    };

    oid("btnsubmit").onclick = function() { validquestion(); };
    oid("breakbtn").onclick = function() { pausepipi(); };

    window.addEventListener('resize', function(event){
        fittopage();
    });
}

/* check datas in popupreglement, close pop up and launch the test */
function acceptrules() {
    var email = oid('email').value.trim();
    var lastname = oid('lastname').value.trim();
    var firstname = oid('firstname').value.trim();
    //var dep = oid('dep').value.trim();
    if (oid('acceptrules').checked != true) {
        oid('alertpopup').innerHTML = 'Vous devez accepter le règlement';
        oid('alertpopup').style.display = 'block';
    } else {
        if (email == '' || lastname == '' || firstname == '') { //  || dep == ''
            oid('alertpopup').innerHTML = 'Vous devez saisir tous les champs obligatoires pour commencer le test';
            oid('alertpopup').style.display = 'block';
        } else if (validateEmail(email) == false) {
            oid('alertpopup').innerHTML = 'Vous devez saisir un email valide pour commencer le test';
            oid('alertpopup').style.display = 'block';
        } else {
            startquestion(oid('testid').value, oid('questionid').value, oid('code'.value));
        }
    }
}
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

var intervale;
/* get data for one question and initialize the question (active/inactive buttons) */
function startquestion(testid, questionid, code) {
    // close popup
    oid('bgreglement').style.display='none';
    oid('popupreglement').style.display='none';

    oid('jecraqueclicked').value = 0;
    if (oid('jecraque').classList.contains('inactive')) oid('jecraque').classList.remove('inactive');
    if (oid('jecraque').classList.contains('selectbtn')) oid('jecraque').classList.remove('selectbtn');
    if (!oid('jecraque').classList.contains('active')) oid('jecraque').classList.add('active');

    // get data for question id
    req_url = base_utils_url+'dataquestion.php?q='+questionid+'&t='+testid+'&c='+code;

    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState >= 4 && xhr.status == 200){
            var resp = xhr.responseText;
            if(resp){
                // change page with question datas
                var respjson = JSON.parse(resp);

                inactive_btns('active'); // reinit page

                oid('questionid').value = questionid;
                oid('typeid').value = respjson.question.type_id;
                oid('currentquestion').innerHTML = (parseInt(oid('currentquestion').innerHTML) + 1);
                oid('startquestion').value = ~~(Date.now()/1000);

                // image ou player
                if (respjson.question.youtube_id != '' && respjson.question.youtube_id != '0') {
                    oid('maincenter').innerHTML = '<div id="playeryt"></div>';

                    player = new YT.Player('playeryt', {
                        height: oid('maincenter').offsetHeight,
                        width: oid('maincenter').offsetWidth,
                        videoId: respjson.question.youtube_id,
                        playerVars: {
                            controls : 0,
                            showinfo : 0,
                            disablekb: 1,
                            fs: 0,
                            rel: 0
                        },
                        events: {
                        }
                    });
                } else if (respjson.question.mp3 != '') {
                    oid('maincenter').innerHTML = '</div><img src="'+base_url+'/public/images/son.jpg" alt="son" width="100%" /><audio id="audioplayer" autoplay><source src="'+base_utils_url+respjson.question.mp3+'" type="audio/mpeg">Your browser does not support the audio element.</audio>';
                } else if (respjson.question.img != '') { // image
                    oid('maincenter').innerHTML = '<div id="watermark" style="background:url(\''+base_utils_url+respjson.question.img+'\') top center no-repeat;"><p id="bg-text">BETA TESTING</p></div>';
                } else {
                    oid('maincenter').innerHTML = '<p style="text-align:center;padding-top:50px;">Media vide</p>';
                }

                // buttons actions
                if (respjson.question.youtube_id != '' || respjson.question.mp3 != '') {
                    oid('pause').classList.remove('inactive');
                    oid('pause').classList.add('active');


                } else {
                    oid('pause').classList.add('inactive');
                }

                if (respjson.question.type_id == 1 || respjson.question.type_id == 10 || respjson.question.type_id == 8) { // CALC
                    oid('btndot').classList.remove('inactive'); oid('btndot').classList.add('active');
                    for (i=0; i<=9; i++) {
                        oid('btn'+i).classList.remove('inactive'); oid('btn'+i).classList.add('active');
                    }
                    oid('btnReset').classList.remove('inactive'); oid('btnReset').classList.add('active');
                }

                if (respjson.question.type_id == 2) { // bof / sympa
                    oid('action2').classList.remove('inactive');
                    oid('action2').classList.add('active');
                    if (!oid('action2').classList.contains('bof')) oid('action2').classList.add('bof');
                    oid('action2').classList.remove('no');

                    oid('action3').classList.remove('inactive');
                    oid('action3').classList.add('active');
                    if (!oid('action3').classList.contains('sympa')) oid('action3').classList.add('sympa');
                    oid('action3').classList.remove('yes');
                }

                if (respjson.question.type_id == 3) { // hate / love
                    oid('action1').classList.remove('inactive');
                    oid('action1').classList.add('active');
                    if (!oid('action1').classList.contains('hate')) oid('action1').classList.add('hate');

                    oid('action4').classList.remove('inactive');
                    oid('action4').classList.add('active');
                    if (!oid('action4').classList.contains('love')) oid('action4').classList.add('love');
                }

                if (respjson.question.type_id == 4) { // yes / no
                    oid('action2').classList.remove('inactive');
                    oid('action2').classList.add('active');
                    if (!oid('action2').classList.contains('no')) oid('action2').classList.add('no');
                    oid('action2').classList.remove('bof');

                    oid('action3').classList.remove('inactive');
                    oid('action3').classList.add('active');
                    if (!oid('action3').classList.contains('yes')) oid('action3').classList.add('yes');
                    oid('action3').classList.remove('sympa');
                }

                if (respjson.question.type_id == 5 || respjson.question.type_id == 7) { // ABCD
                    oid('btnA').classList.remove('inactive');
                    oid('btnA').classList.add('active');

                    oid('btnB').classList.remove('inactive');
                    oid('btnB').classList.add('active');

                    oid('btnC').classList.remove('inactive');
                    oid('btnC').classList.add('active');

                    oid('btnD').classList.remove('inactive');
                    oid('btnD').classList.add('active');

                    oid('btnX').classList.remove('inactive');
                    oid('btnX').classList.add('active');
                }

                if (respjson.question.type_id == 6 || respjson.question.type_id == 9) { // A ou B - Genre
                    oid('btnA').classList.remove('inactive');
                    oid('btnA').classList.add('active');

                    oid('btnB').classList.remove('inactive');
                    oid('btnB').classList.add('active');

                    oid('btnX').classList.remove('inactive');
                    oid('btnX').classList.add('active');
                }

                oid('title-test').innerHTML=respjson.question.text;
                oid('description').innerHTML=respjson.question.description;
                oid('remaining-time').innerHTML=respjson.question.duration+'\'';

                // sablier
                if (respjson.question.duration>0) {
                    oid('sablier').classList.remove('inactive');
                    oid('sablier').classList.add('active');

                    if (oid('remaining-time').innerHTML != '0\'')
                        intervale = setInterval(decrementtime, 1000);
                } else {
                    oid('sablier').classList.add('inactive');
                }
            }
        }
    };
    xhr.open("GET", req_url, true);
    xhr.send();
}

/* decrement chrono from one second */
function decrementtime() {
    if (oid('remaining-time').innerHTML != '0\'') {
        var newtime = (oid('remaining-time').innerHTML.replace('\'', '').trim() - 1);
        oid('remaining-time').innerHTML = newtime + '\'';

        if (newtime == 0) { // redirect to next question
            clearInterval(intervale);

            // get next question
            req_url = base_utils_url + 'redirnextquestion.php?q=' + oid('questionid').value;
            xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState >= 4 && xhr.status == 200) {
                    var resp = xhr.responseText;

                    if (resp == false) {
                        alert('probleme de recuperation d\'infos');
                    } else {
                        if (resp != 'end') {
                            console.log('redir new question ' + resp);
                            startquestion(oid('testid').value, resp, oid('code').value);
                        } else { // redir to end message
                            window.location = base_url + 'testfinished/' + oid('testid').value;
                        }
                    }
                }
            };
            xhr.open("GET", req_url, true);
            xhr.send();
        }
    } else {
        clearInterval(intervale);
    }
}

/* stop or start chrono */
function pausepipi() {
    if (oid('pausepipi').value == 0) { // stop timer
        clearInterval(intervale);
        oid('pausepipi').value = 1;

        oid('pauseoverlay').style.display='block';
        intervalepause = setInterval(decrementpause, 1000);

    } else if (oid('pausepipi').value == 1) { // restart timer
        pauseend();
    }
}

/* end of pause, restart test's timer */
function pauseend() {
    clearInterval(intervale);
    clearInterval(intervalepause);
    intervale = setInterval(decrementtime, 1000);

    oid('pauseoverlay').style.display='none';
}

/* decrement chrono from one second in pause timer */
function decrementpause() {
    if (oid('pausetimer').innerHTML != '0') {
        var newtime = (oid('pausetimer').innerHTML.trim() - 1);
        oid('pausetimer').innerHTML = newtime;

        if (newtime == 0) { // end the pause
            pauseend();
        }
    } else {
        clearInterval(intervalepause);
    }
}

var player;
/* Tests the paused attribute of audio player and set state pause or play */
function pauseplay() {
    var oVideo = oid("playeryt");
    if (typeof oVideo != null && oVideo != null) {
        if (player.getPlayerState() == YT.PlayerState.PLAYING) player.pauseVideo(); else player.playVideo();
    }

    var oAudio = oid("audioplayer");
    if (typeof oAudio != null && oAudio != null) {
        if (oAudio.paused) {
            oAudio.play();
        } else {
            oAudio.pause();
        }
    }
}

/* set class selectbtn on clicked button and remove on others buttons */
function selectbtn(btnid) {
    for (j=1; j<=4; j++)
        oid('action'+j).classList.remove('selectbtn');
    oid('action'+btnid).classList.add('selectbtn');
    oid('btnclicked').value = btnid;
}

/* inactive all buttons */
function inactive_btns(cls) {
    oid('sablier').classList.remove(cls);
    oid('pause').classList.remove(cls);
    oid('btndot').classList.remove(cls);
    for (i=0; i<=9; i++)
        oid('btn'+i).classList.remove(cls);
    oid('btnReset').classList.remove(cls);
    for (j=1; j<=4; j++)
        oid('action'+j).classList.remove(cls);
    oid('btnA').classList.remove(cls);
    oid('btnB').classList.remove(cls);
    oid('btnC').classList.remove(cls);
    oid('btnD').classList.remove(cls);
    oid('btnX').classList.remove(cls);

    for (j=1; j<=4; j++)
        oid('action'+j).classList.remove('selectbtn');

    oid('btnclicked').value = '';
    oid('choiceabcd').innerHTML = '';
    oid('calcsum').innerHTML = '';
}

/* set the answer and go to next question */
function validquestion() {
    clearInterval(intervale);

    // get answer
    var answer = '';
    if (oid('btnclicked').value != '') {
        answer = oid('btnclicked').value;
    } else if (oid('choiceabcd').innerHTML != '') {
        answer = oid('choiceabcd').innerHTML.trim();
    } else if (oid('calcsum').innerHTML != '') {
        answer = oid('calcsum').innerHTML.trim();
    }
    if (answer == '') {
        oid('alert').innerHTML = 'Merci de choisir une réponse'; oid('alert').style.display = 'block';
        setTimeout('oid("alert").style.display = "none";', 3000);
    } else if (oid("typeid").value == 8 && parseInt(answer) > 120) {
        oid('alert').innerHTML = 'Merci de saisir un âge correct'; oid('alert').style.display = 'block';
        setTimeout('oid("alert").style.display = "none";', 3000);
    } else if (oid("typeid").value == 10 && (parseInt(answer) > 10000 || answer.length < 4)) {
        oid('alert').innerHTML = 'Merci de saisir un code postal correct'; oid('alert').style.display = 'block';
        setTimeout('oid("alert").style.display = "none";', 3000);
    } else {
        var remainingtime = oid('remaining-time').innerHTML.replace('\'', '').trim();

        // send answer
        req_url = base_utils_url + 'answerquestion.php';
        var data = new FormData();
        data.append('q', oid('questionid').value);
        data.append('c', oid('code').value);
        data.append('ans', answer);
        data.append('pipi', oid('pausepipi').value);
        data.append('craque', oid('jecraqueclicked').value);

        data.append('start', oid('starttime').value);
        //data.append('time', remainingtime);
        var now = ~~(Date.now()/1000);
        data.append('time', now - oid('startquestion').value);

        data.append('email', oid('email').value);
        data.append('firstname', oid('firstname').value);
        data.append('lastname', oid('lastname').value);

        /*
        var genreinputs = oid('genre').getElementsByTagName('input');
        for (var idx = 0; idx<=2; idx++)
            if (genreinputs[idx].checked == true) data.append('genre',genreinputs[idx].value);
        data.append('age', oid('age').value);
        data.append('dep', oid('dep').options[oid('dep').selectedIndex].value);
        */

        xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState >= 4 && xhr.status == 200) {
                var resp = xhr.responseText;

                if (resp == false) {
                    alert('probleme de validation');
                } else {
                    var respjson = JSON.parse(resp);

                    if (respjson.status != 'end') {
                        if (respjson.status == 'allreadyanswer') {
                            alert('Vous aviez déjà répondu à cette question');
                        } else {
                            console.log('start new question ' + respjson.nextquestion);
                            startquestion(oid('testid').value, respjson.nextquestion, oid('code').value);

                            // show new score
                            oid('currentpoints').innerHTML = respjson.score;
                        }
                    } else { // redir to end message
                        window.location = base_url + 'testfinished/' + oid('testid').value;
                    }



                }
            }
        };
        xhr.open("POST", req_url, true);
        xhr.send(data);
    }
}