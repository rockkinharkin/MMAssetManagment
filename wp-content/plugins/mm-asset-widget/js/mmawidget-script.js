jQuery(document).ready(function($){
  $('.mmarw-container').hide();

  $('#embed-code').on('click', function(){
   $('#embed-code .mmarw-container').toggle("slow");
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
