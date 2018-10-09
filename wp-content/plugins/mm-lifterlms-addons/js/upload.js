jQuery(document).ready( function($)
{
  var filename   = '';
  var image_data = '';
  //var currURL = window.location;

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

  $.event.props.push('dataTransfer');
  $('.dropzone').on(
    {
      dragover: function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).addClass('highlight');
        console.log("t3");
        return false; //crucial for 'drop' event to fire
      },
      dragleave: function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass('highlight');
        return false;
      },
      drop: function(e) {
       Id = $(this).attr('id');
       console.log(Id);
       e.stopPropagation();
       e.preventDefault();
       var file = e.dataTransfer.files[0];
       var fileReader = new FileReader();

       var this_obj = $(this);

       fileReader.onload = (function(file) {
           return function(event) {
               // Preview
               filename = file.name;
               // if file is an image
               image_data = event.target.result;

               $(this_obj).next().html('<button id="'+Id+'" class="upload-file button">Upload file</button>');

               if( ( Id == 'dropzone-video' ) || ( Id == 'dropzone-audio' ) || ( Id == 'dropzone-docs' ) ){
                 $(this_obj).html('<p class="file">'+event.target.result+'</p>');
               }
               if( Id == 'dropzone-images'){
                 $(this_obj).html('<img style="max-width: 200px; max-height: 200px;" src="' + event.target.result + '">');
               }


               var assetId = GetURLParameter('course_id');
               var data= {  action: 'upload_file',
                             filename: filename,
                             base64: image_data,
                             assetid: assetId };

               console.log( assetId, data );
               //
                //$.post( ajax_object.ajax_url,data, function(response){
               //   $(this_obj).parent().prev().html(response);
               //   $(this_obj).remove();
               // });
             console.log('ok');
           };
       })(file);
       fileReader.readAsDataURL(file);

       // Upload file
      // $('.upload-file').on('click',  function(e){

      //  });
       //return false;
     }
   });
});
