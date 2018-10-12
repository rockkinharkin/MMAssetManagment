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
       var image_data = event.target.result;

       fileReader.onload = (function(file) {
         return function(event) {
           $('<p class="file">'+file.name+'</p>').appendTo(this_obj);

           if( Id == 'img-leftCol'){
             $('<img id="'+file.name+'" style="max-width: 200px; max-height: 200px;" src="' + event.target.result + '">').appendTo(this_obj);
           }
         }
        })(file);
       fileReader.readAsDataURL(file);

       var assetId = GetURLParameter('course_id');
       var assetSlug = GetURLParameter('course_slug');
       var imagedata = $('img #'+file.name).attr('src');
       var filename = $('img #'+file.name).attr('id');

       var data= { 'action': 'upload_files',
                   'assetid': assetId,
                   'assetslug': assetSlug.toString(),
                   'file': '415_7_crayola-experience-entrance_28_08_2018.gif',
                   'imagedata':'data:image/gif;base64,IVURHSKNDSKknsdoiUHJK',
                   'nonce': ajax_data.nonce
                 };
         // Upload file
        $('#upload-files').on('click', function(e){
          console.log(data);
          $.post( ajax_url,data,function(response){
              alert(response);
            });
        });
       return false;
     }
   });
});
