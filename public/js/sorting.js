/*$(document).ready(function(){
  var pclone = $(".discs").clone();

  $("#sort a").on("click", function(e){
    e.preventDefault();
    var sorttype = $(this).attr("class");

    // determine if another link is selected
    if(!$(this).hasClass("selected")) {
      $("#sort a").removeClass("selected");
      $(this).addClass("selected");
    }

    // check filter sort type
    if(sorttype == "all") {
      var filterselect = pclone.find("li");
    } else {
      //var filterselect = pclone.find("li[class="+sorttype+"]");
      var filterselect = pclone.find("li."+sorttype+"");
    }

    console.log(filterselect);
    $(".discs").quicksand(filterselect,
    {
      adjustHeight: 'auto',
      duration: 550
    }, function() {
      // callback function
    });

  }); // end click event listener
});*/

$("#content").quicksand($(".discs > li"),
    {
        // all the parameters have sensible defaults
        // and in most cases can be optional
        duration: 1000,
        easing: "swing",
        attribute: "data-id",
    }
);