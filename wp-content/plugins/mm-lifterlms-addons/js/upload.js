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
  var ajax_url = ajax_data.ajax_url;
  var assetId = GetURLParameter('course_id');
  var assetSlug = GetURLParameter('course_slug').toString();
  //var filelist = [];
  //var data = { 'action': 'upload_files',  'assetid': assetId, 'assetslug': assetSlug, 'filelist':filelist, 'nonce': ajax_data.nonce };

// upload full directory to s3.
  var filelist = [];
  // $('#videoform').on('change', function(e){
  //   var files = e.target.files;
  //   $(files).each( function(i, file){
  //     fr = new FileReader(file); // need file reader to get base64 of file
  //     fr.readAsDataURL(file);
  //     $.extend(file,{"base64":fr.result}); // add base64 data string to file object
  //     filelist.push(file); // add file into the ifiles array for sending in request
  //   });

//  });
  $('#videoform').submit( function(e){
    e.preventDefault();

    var fi = $('#vidfiles')[0].files;
    formdata = new FormData();

    $(fi).each( function(i, file){
      fr = new FileReader(file); // need file reader to get base64 of file
      fr.readAsDataURL(file);
      $.extend(file,{"base64":fr.result}); // add base64 data string to file object
      formdata.append('files['+i+']', fi);
      //filelist.push(file);
    });

    formdata.append('action', 'upload_files');
    formdata.append('assetid',assetId,);
    formdata.append('assetslug',assetSlug);
    formdata.append('nonce', ajax_data.nonce);
  //   formdata.append('contentType', 'application/json');
  //   formdata.append('dataType', 'application/json');
  // //  formdata.append('processData',false);

    $.ajax({ url: ajax_url,
                  type: 'POST',
                  contentType: false,
                  processData: false,
                  data: formdata,
                  dataType:'json',
                  success: function (response) {
                      $('.success').html("Form Submit Successfully");
                  },
                  error: function (response) {
                   console.log('error');
                 }
               });
    //
    // $.post( ajax_url,formdata,function(data,response){
    //     $("#videoform").html(data +'<br><br>'+response);
    // });
    // foorm
    //  var files = $('#vidfiles')[0].files;
    //  var inputName = $('#vidfiles').attr('name');
    //  var fileData = { 'action':'upload_directory',
    //                 'contentType':false,
    //                 'processData':false,
    //                 'assetid':assetId,
    //                 'assetslug':assetSlug,
    //                 'files': [],
    //                 'nonce': ajax_data.nonce };
    //  //make files available
    //
    //    $(files).each( function(i, file){
    //      // get file data
    //      fr = new FileReader(file); // need file reader to get base64 of video / audio
    //      fr.readAsDataURL(file);
    //      $.extend(file,{ "base64":fr.result }); // add the files data string to the file object.
    //    });
    //  $.extend(fileData, { 'files': files}); // add file list to the ajax post data set

});
  //   filelist.push({ 'images':imgs, 'docs':docs,'audio':aud,'videos':vids });
  //   // add object to data variable for bulk upload
  //   $.extend( data['filelist'],filelist);
  //   console.log($(data));
  //   $.post( ajax_url,data,function(response){
  //       alert(response);
  //    });
  // });

});
