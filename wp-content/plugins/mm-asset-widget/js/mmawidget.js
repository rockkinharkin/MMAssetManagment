  elems = ['#embed-code','#audio-list','#images-list','#docs-list'];

  $('.container').each().hide();

  $(elems).each(this).on('click',function(e){
    $( e+' .container').slideDown("slow");
  });
