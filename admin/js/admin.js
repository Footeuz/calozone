/* global oid, base_url */

function itemDeleteThumb(id){
    oid('item_thumb_'+id).style.display = "none";
    oid('thumbs_to_delete').value = '1';
}

function itemDeleteImg(id){
    oid('item_img_'+id).style.display = "none";
    oid('imgs_to_delete').value = '1';
}
function itemDeleteSocialImg(id){
    oid('item_socialimg_'+id).style.display = "none";
    oid('imgs_social_to_delete').value = '1';
}

function itemDeleteMp3(id){
    oid('item_mp3_'+id).style.display = "none";
    oid('mp3_to_delete').value = '1';
}

var pickerCallback = null;
function setPicFromGallery(url){
    pickerCallback(url);
    tinymce.activeEditor.windowManager.close();
}

function inittiny() {
    tinymce.init({
        selector: "textarea",
        setup: function (editor) { editor.on('change', function () { editor.save(); }); },
        mode : "textareas",
        language : "fr_FR",
        theme : "modern",
        plugins: [
            "advlist autolink link image lists charmap hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality template paste textcolor colorpicker imagetools"
        ],
        toolbar: "code | insertfile undo redo | styleselect | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent table | link image fullpage",
        menu: {},
        style_formats: [
            {title: 'Header 3', format: 'h3'},{title: 'Header 4', format: 'h4'},{title: 'Header 5', format: 'h5'},{title: 'Header 6', format: 'h6'},
            {title: 'Paragraph', format: 'p'},{title: 'Blockquote', format: 'blockquote'},{title: 'Div', format: 'div'},{title: 'Pre', format: 'pre'}
        ],
        file_picker_types: 'image',
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        file_picker_callback: function(callback, value, meta) {
            pickerCallback = callback;
            tinymce.activeEditor.windowManager.open({
                title: 'Gallerie',
                url: 'images_gallery.php',
                width: 700,
                height: 600
            });
        },
        images_upload_url: 'upload.php'
    });
}


/* filter table */
function filtertable(tableid, selectid, cls) {
    if (oid(tableid) != null && oid(selectid) != null) {
        var tabtr = oid(tableid).getElementsByTagName('tr');
        for (var i = 2; i < tabtr.length; i++) {
            if(tabtr[i] && !tabtr[i].classList.contains('head')) {
                if (oid(selectid).value == 'all')
                    tabtr[i].style.display = 'table-row';
                else
                    tabtr[i].style.display = (tabtr[i].classList.contains(cls+oid(selectid).value)) ? 'table-row' : 'none';
            }
        }
    }
}

/* update the dashboard with test datas */
function dashboard () {

}

window.addEventListener('load', function() {
    dashboard();
}, false)

// do the ul li of questions sortable avec save it when order change
function dosorter() {
}

