///=====second last attempt ///====

// add to fileData['filelist']

//   console.log(files);
//var fileData = new FormData();


// fileData.append('action','upload_directory');
// fileData.append('assetid',assetId);
// fileData.append('assetslug',assetSlug);
// fileData.append('nonce',ajax_data.nonce);


//
//   var data = {};
//   $.extend(data,{ 'action':'upload_directory',
//                 'contentType':false,
//                 'processData':false,
//                 'assetid':assetId,
//                 'assetslug':assetSlug,
//                 'data': fileData,
//                 'nonce': ajax_data.nonce
//               });
  // data.append('contentType',false);
  // data.append('processData',false);
  // data.append('assetid',assetId);
  // data.append('assetslug',assetSlug);
  // data.append('nonce',ajax_data.nonce);
  //   data.append('files',fileData);


  //$.extend(fileData,{ 'action': 'upload_directory','assetid': assetId, 'assetslug': assetSlug, 'nonce': ajax_data.nonce });


  //fieldata = $('input#vidfiles').prop('files')[0]);
  // console.log('fileData::'+fileData);
  // $.extend( data['files'],fileData);
  // console.log('Final Data Set::'+data);
//  $.post( ajax_url, data, function(response){alert(response);} );
///======================last attempt======//
///===========================First attempt at uploader =======////
// build file list object for upload
// //  $('.dropzone li.file').each(function(){
// //    filename = $(this).attr('id');
// //    fileObj = { 'assetid': assetId,
// //                'assetslug': assetSlug,
// //                'filename':filename,
// //                'nonce': ajax_data.nonce}
// //    $.extend( data, fileObj );
// //  });
// // console.log(data);
//
//  $('#dropzone-images img.imgdata').each(function(el){
//    filename = $(this).attr('id');
//    imagefile = $(this).attr('src');
//      // console.log({'imagedata':imagefile});
//    fileObj = {   'assetid': assetId,
//                  'assetslug': assetSlug,
//                  'filename': filename,
//                  'imagedata': imagefile,
//                  'nonce': ajax_data.nonce,
//                };
//
//    $.extend( data, fileObj );
//  });
// console.log(data);


jQuery(document).ready( function($){

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
// declare global variable
  //=========================================================================

  $.fn.extend({
      filedrop: function (options) {
          var defaults = {
              callback : null
          }
          options =  $.extend(defaults, options)
          return this.each(function() {
              var files = []
              var $this = $(this)

              // Stop default browser actions
              $this.bind('dragover dragleave', function(event) {
                  event.stopPropagation();
                  event.preventDefault();
                  return false;
              })

              // Catch drop event
              $this.bind('drop', function(event) {
                  // Stop default browser actions
                  event.stopPropagation()
                  event.preventDefault()

                  // Get all files that are dropped
                  files = event.originalEvent.target.files || event.originalEvent.dataTransfer.files

                  // Convert uploaded file to data URL and pass trought callback
                  if(options.callback) {
                    for (i = 0; i < files.length; i++) {
                      var reader = new FileReader();
                      reader.onload = function(event) {
                          options.callback(event.target.result,files[0].name)
                      }
                      reader.readAsDataURL(files[0])
                    }
                  }
                  return false
              });
          });
      }
  });

  $('.dropzone div.col-left').filedrop( {
      callback : function(filedata,filename){
        console.log(filedata+'_____'+filename);
         ajax_url = ajax_data.ajax_url;
         assetId = GetURLParameter('course_id');
         assetSlug = GetURLParameter('course_slug').toString();
         data = { 'assetid': assetId,
                  'assetslug': assetSlug,
                  'filename' : filename,
                  'filedata': filedata,
                  'nonce': ajax_data.nonce }; // must be in same order as being passed to server function
        //console.log(data);
         $.post(ajax_url,data, function(response){
           alert(reponse);
         });
      }
  });
});
