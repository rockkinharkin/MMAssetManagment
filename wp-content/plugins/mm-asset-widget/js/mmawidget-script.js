jQuery(document).ready(function($){
   host = window.location.host;

  $('.mmarw-container').hide();

  $('.item-class').on('click', function(){
    $(this).each(function(ob){
      $(ob+' h4').addClass('down-arrow');
    });
  });

  $('#video-list').on('click', function(){
   $('#video-list .mmarw-container').toggle("slow");
  });

  $('#audio-list').on('click', function(){
   $('#audio-list .mmarw-container').toggle("slow");
  });

  $('#image-list').on('click', function(){
   $('#image-list .mmarw-container').toggle("slow");
  });

  $('#docs-list').on('click', function(){
   $('#docs-list .mmarw-container').toggle("slow");
  });
});
