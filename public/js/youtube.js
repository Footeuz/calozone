// 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var firstclipurl = document.getElementById('firstclip').value;

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {
    player = new YT.Player('clipplayer1', {
        height: '360',
        width: '640',
        videoId: firstclipurl,
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
    event.target.playVideo();
}

var done = false;
function onPlayerStateChange(event) {
    /*if (event.data == YT.PlayerState.PLAYING && !done) {
        setTimeout(stopVideo, 6000);
        done = true;
    }*/
}
function stopVideo() {
    player.stopVideo();
}

function showVideo(clipid, clipurl, cliptype, clipreal, clipdate, clipartist) {
    document.getElementById('clipplayer2').innerHTML = '';
    if (!document.getElementById('clipplayer2').classList.contains('d-none'))
        document.getElementById('clipplayer2').classList.add('d-none');
    if (document.getElementById('clipplayer1').classList.contains('d-none'))
        document.getElementById('clipplayer1').classList.remove('d-none');

    player.stopVideo();
    player.loadVideoById(clipurl);
    player.playVideo();

    document.getElementById('cliptype').innerHTML = clipartist+' ('+cliptype+')';
    document.getElementById('clipdate').innerHTML = '<strong>Sortie :</strong> '+clipdate;
    document.getElementById('clipreal').innerHTML = '<strong>Réalisateur :</strong> '+clipreal;
}

function setEmbed(clipid, clipurl, cliptype, clipreal, clipdate, clipartist) {
    if (!document.getElementById('clipplayer1').classList.contains('d-none'))
        document.getElementById('clipplayer1').classList.add('d-none');
    if (document.getElementById('clipplayer2').classList.contains('d-none'))
        document.getElementById('clipplayer2').classList.remove('d-none');

    player.stopVideo();
    document.getElementById('clipplayer2').innerHTML = '<div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;"> <iframe style="width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden" frameborder="0" type="text/html" src="'+clipurl+'?autoplay=1" width="100%" height="100%" allowfullscreen allow="autoplay"> </iframe> </div>';

    document.getElementById('cliptype').innerHTML = clipartist+' ('+cliptype+')';
    document.getElementById('clipdate').innerHTML = '<strong>Sortie :</strong> '+clipdate;
    document.getElementById('clipreal').innerHTML = '<strong>Réalisateur :</strong> '+clipreal;
}

