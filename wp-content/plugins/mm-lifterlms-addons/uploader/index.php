<?php defined( 'ABSPATH' ) or die ('Unauthorised Access');
$assetId=$_GET['course_id'];
$courseslug = $_GET['course_slug'];?>

<div id="information" class="info">
  <h2>Need to Know</h2>
  <p>This will upload the assets directly to the Amazon s3 Bucket <span class="highlight">'courses.makematic.com'</span></p>
  <p>The naming convention for the file structure on the s3 bucket is as follows:
    <ul>
      <li><span class="highlight">Parent Directory:</span> {courseid}_{course-name}/</li>
      <li><span class="highlight">Sub-directories:</span> videos/, audio/, images/, docs/</li>
      <li><span class="highlight">Filenames:</span> {uniqueId}-{filename.extension}. The "uniqueId is created automatically when the upload occurs.</li>
    </ul>
    <div id="needToKnow">
      <h3>Automation</h3>
      <p>The uploader will automatically detect the file type and place the file in the appropriate directory. If
      the directory does not exist one will be generated automatically.</p>
    </div>
</div>

  <div class="form">
    <label>Choose your files to upload</label>
    <input type="file" id="files" multiple="multiple" />
  </div>

<script language="javascript">

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
var assetId = GetURLParameter('course_id');
var assetSlug = GetURLParameter('course_slug').toString();

Evaporate.create({
  /* START EDITS */
  aws_key: '',
  bucket: '',
  awsRegion: '',
  /* END EDITS */
  signerUrl: '/wp-content/plugins/mm-lifterlms-addons/uploader/s3_sign.php',
  awsSignatureVersion: '4',
  computeContentMd5: true,
  cryptoMd5Method: function (data) { return AWS.util.crypto.md5(data, 'base64'); },
  cryptoHexEncodedHash256: function (data) { return AWS.util.crypto.sha256(data, 'hex'); }
})
.then(
  // Successfully created evaporate instance `_e_`
  function success(_e_) {
    var fileInput = document.getElementById('files'),
        filePromises = [];

    // Start a new evaporate upload anytime new files are added in the file input
    fileInput.onchange = function(evt) {
      var files = evt.target.files;
      for (var i = 0; i < files.length; i++) {

          console.log("filetype::"+files[i].type);
         var directory = whatDirectory(files[i].type);
        // determine directory upload_directory
        var promise = _e_.add({
          name: assetId+'_'+assetSlug+'/'+directory+'/'+Math.floor(1000000000*Math.random())+'-'+files[i].name, // just changed this last night.
          file: files[i],
          progress: function (progress) {
            console.log('making progress: ' + progress);
          }
        })
        .then(function (awsKey) {
          console.log(awsKey, 'complete!');
        });
        filePromises.push(promise);
      }

      // Wait until all promises are complete
      Promise.all(filePromises)
        .then(function () {
          console.log('All files were uploaded successfully.');
        }, function (reason) {
          console.log('All files were not uploaded successfully:', reason);
        });

      // Clear out the file picker input
      evt.target.value = '';
    };
  },

  // Failed to create new instance of evaporate
  function failure(reason) {
     console.log('Evaporate failed to initialize: ', reason)
  }
);

function whatDirectory(filetype=""){
  docs = ['vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf','application/vnd.oasis.opendocument.text','application/msword','text/plain'];

  if( filetype != ""){
    if( filetype.includes("video/") == true  ){
      return "video";
    }
    if( filetype.includes("audio/") == true){
      return "audio";
    }
    if( filetype.includes("image/") == true ){
      return "images";
    }
    if( jQuery.inArray(filetype, docs) != -1 ){
      return "docs";
    }
  }
  return "other_resources";
}
</script>
