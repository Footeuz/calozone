var menus = new Array();
var menu_selected = 'test';

function registerMenu(newMenu){
    menus.push(newMenu);
}


function setTab(tab, forceLoad){
    for(var m in menus){
        var p = menus[m]; 
        if(oid('tab_'+p)){
            if(p === tab){
                oid('tab_'+p).className = "selected";
                if (oid(p) != null) oid(p).style.display = "block";
            } else {
                oid('tab_'+p).className = "";
                if (oid(p) != null) oid(p).style.display = "none";
            }        
        }
    }
    
    menu_selected = tab;
    if(forceLoad || oid("content_"+tab).innerHTML == "") load(menu_selected, tab);
}

function setMenuItem(menu, item){
    var menuItems = oid("left_menu_"+menu).getElementsByTagName("a");
    for(var i=0; i<menuItems.length; i++){
        if(menuItems[i].id === "menu_"+item){
            menuItems[i].className = "selected";        
        }
        else{
            menuItems[i].className = "";
        }
    }
    
}

function set(item){
    setMenuItem(menu_selected, item);
    load(item);
}

function load(menu, page, params){
    var url = "pages/"+menu+"/"+(page?page:menu)+".php";

    if (page == 'testEdit')
        postNDisplay(url, "content_"+menu_selected, params, '', dosorter);
    else
        postNDisplay(url, "content_"+menu_selected, params);
}

function edit(menu, id, evt, parentid){
    if (parentid>0)
        load(menu, menu+'Edit', 'id='+id+'&parentid='+parentid);
    else
        load(menu, menu+'Edit', 'id='+id);
    if(evt){
        evt.preventDefault();
        evt.stopPropagation();
    }
}

function save(menu, quit){
    return submitForm(menu+"_edit_form", function(resp){
        if (quit == 1) {
            console.log(menu);
            if (menu == 'discsong') {
                var input = oid('disc_id');
                console.log(input);
                edit('disc', input.value);
            } else if (menu == 'toursetlistsong') {
                var input = oid('tour_setlist_id');
                console.log(input);
                edit('toursetlist', input.value);
            } else {
                load(menu);
            }
        } else {
            if (typeof(resp.split('#')[1]) != null) edit(menu, resp.split('#')[1]); // stay on same page => edit the object created
        }
    });
}

function askDel(menu, id, nom){
    if(confirm('Êtes-vous certain de vouloir supprimer cet élément \''+nom+'\'?')){
        del(menu, id);
    }
}

function del(menu, id){
    post("pages/"+menu+"/"+menu+'Del.php', "id="+id, function(resp){
        load(menu);
    });
}