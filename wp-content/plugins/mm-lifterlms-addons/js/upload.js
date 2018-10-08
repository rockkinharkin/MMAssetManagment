jQuery(document).ready(function($){
  var filename = '';
  var image_data = '';
  $.event.props.push('dataTransfer');

  $('.dropzone').on({
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
       e.stopPropagation();
       e.preventDefault();
       var file = e.dataTransfer.files[0];
       var fileReader = new FileReader();

       var this_obj = $(this);

       fileReader.onload = (function(file) {
           return function(event) {
               // Preview
               filename = file.name;
               image_data = event.target.result;
               $(this_obj).next().html('<a href="#" class="upload-file">Upload file</a>');
               $(this_obj).html('<img style="max-width: 200px; max-height: 200px;" src="' + event.target.result + '">');
           };
       })(file);
       fileReader.readAsDataURL(file);
       return false;
     }
  });

  // Upload file
  $(".upload-file").live("click", function(e){
     e.preventDefault();

     var this_obj = $(this);
     var image_data = $(this_obj).parent().prev().find('img').attr('src');
     var assetId = GetURLParameter('course_id');
     console.log(assetId);

     $.post(
         upload_file,
         {   action: 'upload_file',
             imagedata: image_data,
             filename: filename,
             assetid: assetId
         }, function(response){
             $(this_obj).parent().prev().html(response);
             $(this_obj).remove();
         }
     );

   console.log('ok');
 });

});
