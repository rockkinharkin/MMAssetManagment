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
  var assetSlug = GetURLParameter('course_slug').toString();

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
       var data = { 'action': 'upload_files',  'assetid': assetId, 'assetslug': assetSlug }

       if(files == undefined || files.length == 0) return;
       var file = files[0];

       var fileReader = new FileReader();
        for (i = 0; i < files.length; i++) {
         fileReader.onload = (function(event){
           return function(event) {
             var newUL = $('<ul>').appendTo(this_obj);
             data['filelist'] = { 'filename':file.name, 'filedata': event.target.result };
             $.extend( data, data['filelist'] ); // add object to data variable for bulk upload

             if( id == 'img-leftCol'){
               $('<li><img class="imgdata" id="'+file.name+'" style="max-width: 200px; max-height: 200px;" src="' + event.target.result + '">'+file.name+'</li>').appendTo(newUL);
             }else{
                $('<li class="file" id="'+file.name+'" data="'+file+'">'+file.name+'</li>').appendTo(newUL);
             }
            }
          })(file);
         fileReader.readAsDataURL(file);
       }

       // Upload file
       $('#upload-files').on('click', function(e){
         var data = { 'action': 'upload_files' } ;
         // build file list object for upload
         $('.dropzone li.file').each(function(){
           filename = $(this).attr('id');
           fileObj = { 'assetid': assetId,
                       'assetslug': assetSlug,
                       'filename':filename,
                       'nonce': ajax_data.nonce}
           $.extend( data, fileObj );
         });
        console.log(data);

         $('#dropzone-images img.imgdata').each(function(el){
           filename = $(this).attr('id');
           imagefile = $(this).attr('src');
             // console.log({'imagedata':imagefile});
           fileObj = {   'assetid': assetId,
                         'assetslug': assetSlug,
                         'filename': filename,
                         'imagedata': imagefile,
                         'nonce': ajax_data.nonce,
                       };

           $.extend( data, fileObj );
         });
         console.log("DATA::"+data);
         $.post( ajax_url,data,function(response){
           console.log(response);
         });
     });
       return false;
     }
   });
});
