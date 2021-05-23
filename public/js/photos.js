var map=new Array();
map =[

    [	// ==== SLIDE 1 ====
        {image: 'public/images/xsquare/1.jpg', gray_image: 'public/images/xsquare/gray/1.jpg', a_href: 'album-photo-devantures-1', a_rel: '', a_title: 'Page photos Devantures Calogero', title: 'PHOTOS DEVANTURES CALOGERO', text: 'Toutes les photos des devantures <br/>de salles de concerts <br />où a joué Calogero'},
        {image: 'public/images/xsquare/2.jpg', gray_image: 'public/images/xsquare/gray/2.jpg', a_href: 'album-photo-devantures-1', a_rel: '', a_title: 'Page photos Devantures Calogero', title: '', text: '' },
        {image: 'public/images/xsquare/3.jpg', gray_image: 'public/images/xsquare/gray/3.jpg', a_href: 'album-photo-devantures-1', a_rel: '', a_title: 'Page photos Devantures Calogero', title: '', text: ''},
        {image: 'public/images/xsquare/4.jpg', gray_image: 'public/images/xsquare/gray/4.jpg', a_href: 'album-photo-devantures-1', a_rel: '', a_title: 'Page photos Devantures Calogero', title: '', text: ''},
        {image: 'public/images/xsquare/5.jpg', gray_image: 'public/images/xsquare/gray/5.jpg', a_href: 'album-photo-devantures-1', a_rel: '', a_title: 'Page photos Devantures Calogero', title: '', text: ''},
        {image: 'public/images/xsquare/6.jpg', gray_image: 'public/images/xsquare/gray/6.jpg', a_href: 'album-photo-devantures-1', a_rel: '', a_title: 'Page photos Devantures Calogero', title: '', text: ''},
        {image: '', gray_image: '', a_href: '', a_rel: '', a_title: '', title: '', text: '<span>LES</span><span class="black">PHOTOS</span><span>DE CALOGERO</span>'}
    ],

    [	// ==== SLIDE 2 ====
        {image: 'public/images/xsquare/content2/1.jpg', gray_image: 'public/images/xsquare/content2/gray/1.jpg', a_href: 'album-photo-prix-4', a_rel: '', a_title: 'Photos remises de prix Calogero', title: 'PHOTOS REMISES PRIX', text: 'Toutes les photos des <br/>remises de prix <br />de Calogero'},
        {image: 'public/images/xsquare/content2/2.jpg', gray_image: 'public/images/xsquare/content2/gray/2.jpg', a_href: 'album-photo-prix-4', a_rel: '', a_title: 'Photos remises de prix Calogero', title: '', text: ''},
        {image: 'public/images/xsquare/content2/4.jpg', gray_image: 'public/images/xsquare/content2/gray/4.jpg', a_href: 'album-photo-prix-4', a_rel: '', a_title: 'Photos remises de prix Calogero', title: '', text: ''},
        {image: 'public/images/xsquare/content2/7.jpg', gray_image: 'public/images/xsquare/content2/gray/7.jpg', a_href: 'album-photo-prix-4', a_rel: '', a_title: 'Photos remises de prix Calogero', title: '', text: ''},
        {image: 'public/images/xsquare/content2/5.jpg', gray_image: 'public/images/xsquare/content2/gray/5.jpg', a_href: 'album-photo-prix-4', a_rel: '', a_title: 'Photos remises de prix Calogero', title: '', text: ''},
        {image: 'public/images/xsquare/content2/6.jpg', gray_image: 'public/images/xsquare/content2/gray/6.jpg', a_href: 'album-photo-prix-4', a_rel: '', a_title: 'Photos remises de prix Calogero', title: '', text: ''},
        {image: 'public/images/xsquare/content2/3.jpg', gray_image: 'public/images/xsquare/content2/gray/3.jpg', a_href: 'album-photo-prix-4', a_rel: '', a_title: 'Photos remises de prix Calogero', title: '', text: ''}
    ],

    [	// ==== SLIDE 3 ====
        {image: 'public/images/xsquare/content1/1.jpg', gray_image: 'public/images/xsquare/content1/gray/1.jpg', a_href: 'album-photo-inclassables-3', a_rel: '', a_title: 'Photos inclassables', title: 'PHOTOS INCLASSABLES CALOGERO', text: 'Toutes les photos inclassable <br />de Calogero'},
        {image: 'public/images/xsquare/content1/2.jpg', gray_image: 'public/images/xsquare/content1/gray/2.jpg', a_href: 'album-photo-inclassables-3', a_rel: '', a_title: 'Photos inclassables', title: '', text: ''},
        {image: 'public/images/xsquare/content1/4.jpg', gray_image: 'public/images/xsquare/content1/gray/4.jpg', a_href: 'album-photo-inclassables-3', a_rel: '', a_title: 'Photos inclassables', title: '', text: ''},
        {image: 'public/images/xsquare/content1/7.jpg', gray_image: 'public/images/xsquare/content1/gray/7.jpg', a_href: 'album-photo-inclassables-3', a_rel: '', a_title: 'Photos inclassables', title: '', text: ''},
        {image: 'public/images/xsquare/content1/5.jpg', gray_image: 'public/images/xsquare/content1/gray/5.jpg', a_href: 'album-photo-inclassables-3', a_rel: '', a_title: 'Photos inclassables', title: '', text: ''},
        {image: 'public/images/xsquare/content1/6.jpg', gray_image: 'public/images/xsquare/content1/gray/6.jpg', a_href: 'album-photo-inclassables-3', a_rel: '', a_title: 'Photos inclassables', title: '', text: ''},
        {image: 'public/images/xsquare/content1/3.jpg', gray_image: 'public/images/xsquare/content1/gray/3.jpg', a_href: 'album-photo-inclassables-3', a_rel: '', a_title: 'Photos inclassables', title: '', text: ''}
    ]

];

var size = '';
$(document).ready(function(){
    $('.xSquare').xSquare({
        'map':		map,
        'easing':	'swing',
        'speed':	'slow',
        'title': '<span class="black">LES PHOTOS</span><span>DE CALOGERO !</span>'
    });
    $('.xSquare').xSquare('auto_play', 6000)
});


/*$(window).resize(function(e) {
    xResizeDelay(function(){
        var newSize = getResponsiveSize();
        if(newSize != size) {
            size = newSize;
            $('.xSquare').xSquare('set_new_map', map[size]);
        }
    },300);

});*/

function getResponsiveSize() {
    var size = $('body').width();

    if (size < 440) {
        return '300';
    }
    else if (size < 768) {
        return '440';
    }
    else if (size < 960) {
        return '768';
    }
    else {
        return '960';
    }
}

var xResizeDelay = (function () {
    var timers = {};
    return function (callback, ms, uniqueId) {
        if (!uniqueId) {
            uniqueId = "noId";
        }
        if (timers[uniqueId]) {
            clearTimeout (timers[uniqueId]);
        }
        timers[uniqueId] = setTimeout(callback, ms);
    };
})();