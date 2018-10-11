jQuery(document).ready( function($)
{
  var filename   = '';
  var image_data = '';
//  var $files = [];
  var ajax_url = ajax_data.ajax_url;

  // helper
  function GetURLParameter(sParam){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for( var i = 0; i < sURLVariables.length; i++ ){
      var sParameterName = sURLVariables[i].split('=');
      if (sParameterName[0] == sParam){
         console.log(sParameterName[1]);
        return sParameterName[1];
      }
    }
  }

// The Uploader
  $.event.props.push('dataTransfer');
  $('.dropzone div').on(
    {
      dragover: function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).addClass('highlight');
        return false; //crucial for 'drop' event to fire
      },
      dragleave: function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass('highlight');
        return false;
      },
      drop: function(e) {
       e.stopPropagation();
       e.preventDefault();

       var this_obj = $(this);
       Id = $(this).attr('id');
       var file = e.dataTransfer.files[0];
       var fileReader = new FileReader();

       fileReader.onload = (function(file) {
         return function(event) {
           // Preview
           filename = file.name;
           // if file is an image
           var image_data = event.target.result;

           $('<p class="file">'+file.name+'</p>').appendTo(this_obj);
           if( Id == 'img-leftCol'){
             $('<img style="max-width: 200px; max-height: 200px;" src="' + event.target.result + '">').appendTo(this_obj);
           }
           console.log('ok');
         };
        })(file);
       fileReader.readAsDataURL(file);

       var assetId = GetURLParameter('course_id');
       var assetSlug = GetURLParameter('course_slug');
       var data= { 'action': 'upload_files',
                    'file': file.name,
                    'base64': image_data,
                    'assetid': assetId,
                    'assetslug': assetSlug };

        // Upload file
       $('#upload-files').on('click', function(e){
         $.post( ajax_url,data, function(response){
             alert(response);
           });
       });
       return false;
     }
   });
});
