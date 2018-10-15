jQuery(document).ready( function($)
{
  //================= helper=====================================
  function GetURLParameter(sParam){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for( var i = 0; i < sURLVariables.length; i++ ){
      var sParameterName = sURLVariables[i].split('=');
      if (sParameterName[0] == sParam){
         //console.log(sParameterName[1]);
        return sParameterName[1];
      }
    }
  }
//================================================================
  // declare global variables
  var filename   = '';
  var image_data = '';
  var ajax_url = ajax_data.ajax_url;
  var assetId = GetURLParameter('course_id');
  var assetSlug = GetURLParameter('course_slug');

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
       var id = $(this).attr('id');
       var files = e.dataTransfer.files;

       if(files == undefined || files.length == 0) return;

       var file = files[0];
       var fileReader = new FileReader();

       fileReader.onload = (function(file) {
         return function(event) {
           $('<p class="file">'+file.name+'</p>').appendTo(this_obj);
           if( id == 'img-leftCol'){
             $('<img id="'+file.name+'" style="max-width: 200px; max-height: 200px;" src="' + event.target.result + '">').appendTo(this_obj);
           }
         }
        })(file);
       fileReader.readAsDataURL(file);

       // Upload file
       $('#upload-files').on('click', function(e){
         var $data = { 'action': 'upload_files',
                     'assetid': assetId,
                     'assetslug': assetSlug.toString(),
                     'nonce': ajax_data.nonce
                   };
         $('.dropzone-images img').each(function(this){
           filename = this.attr('id');
           imagefile = $(this).attr('src');
             data.push({'file': filename, 'imagedata': imagefile});
         });

         console.log(data);

        $.post( ajax_url,data,function(response){
            alert(response);
          });
     });
       return false;
     }
   });
});
