$(document).ready(function () {
   $(".pagination li a").each(function () {
      if($(this).attr("rel") == "prev"){
          $(".pagination li a").replace("<<", "Previous");
      } else if($(this).attr("rel") == "prev"){
          $(".pagination li a").replace(">>", "Next");
      }
   });
});