jQuery(document).ready(function($){
   host = window.location.host;

  $('.mmarw-container').hide();

  $('#video-list').on('click', function(){
   $('#video-list .mmarw-container').toggle("slow", function(){
     if( $(this).is(":visible")){
      $('#video-list h4 span').replaceWith('<span class="list-open">-</span>');
    }else{
      $('#video-list h4 span').replaceWith('<span class="list-open">+</span>');
    }
   });
  });

  $('#audio-list').on('click', function(){
   $('#audio-list .mmarw-container').toggle("slow", function(){
     if( $(this).is(":visible")){
      $('#audio-list h4 span').replaceWith('<span class="list-open">-</span>');
    }else{
      $('#audio-list h4 span').replaceWith('<span class="list-open">+</span>');
    }
   });
  });

  $('#image-list').on('click', function(){
   $('#image-list .mmarw-container').toggle("slow",function(){
     if( $(this).is(":visible")){
      $('#image-list h4 span').replaceWith('<span class="list-open">-</span>');
    }else{
      $('#image-list h4 span').replaceWith('<span class="list-open">+</span>');
    }
   });
  });

  $('#docs-list').on('click', function(){
   $('#docs-list .mmarw-container').toggle("slow",function(){
     if( $(this).is(":visible")){
      $('#docs-list h4 span').replaceWith('<span class="list-open">-</span>');
     }else{
      $('#docs-list h4 span').replaceWith('<span class="list-open">+</span>');
     };
   });
  });
});
