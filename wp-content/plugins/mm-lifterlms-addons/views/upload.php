<div class="main-contanier" id="mm-asset-container">
  <div><input type="text" id="filepath" /> <button id="directory-upload">Upload Directory</button> </div>
<!-- video -->
  <div class="dropzone" id="dropzone-video">
    <div class="col-left" id="vid-leftCol">
      <p>Copy and paste the file path of each file you wish to upload.</p>
      <input id="vidfile1" class="vidfile" type="text" placeholder="1. paste file path here" />
      <input id="vidfile2" class="vidfile" type="text" placeholder="2. paste file path here" />
      <input id="vidfile3" class="vidfile" type="text" placeholder="3. paste file path here" />
      <input id="vidfile4" class="vidfile" type="text" placeholder="4. paste file path here" />
      <input id="vidfile5" class="vidfile" type="text" placeholder="5. paste file path here" />
    </div>
    <div class="col-right">
        <img src="<?php echo  WP_SITEURL; ?>/wp-content/plugins/mm-lifterlms-addons/images/icons/video-icon.svg" />
    </div>
  </div>

<!-- audio -->
  <div class="dropzone" id="dropzone-audio">
    <div class="col-left" id="audio-leftCol">
      <p>Paste audio file paths here for uploading</p>
      <!--  <input id="file" type="file" name="file" size="30" accept="file_extension|audio/*" />-->
      <input id="audfile1" class="audfile" type="text" placeholder="1. paste file path here" />
      <input id="audfile2" class="audfile" type="text" placeholder="2. paste file path here" />
      <input id="audfile3" class="audfile" type="text" placeholder="3. paste file path here" />
      <input id="audfile4" class="audfile" type="text" placeholder="4. paste file path here" />
      <input id="audfile5" class="audfile" type="text" placeholder="5. paste file path here" />
    </div>
    <div class="col-right">
      <img src="<?php echo  WP_SITEURL; ?>/wp-content/plugins/mm-lifterlms-addons/images/icons/audio-icon.svg" />
   </div>
  </div>

  <!--Images -->
  <div class="dropzone" id="dropzone-images">
    <div class="col-left" id="img-leftCol">
      <p>Paste image files paths here for uploading</p>
      <!--  <input id="file" type="file" name="file" size="30" accept="file_extension|image/jpg,image/png,image/jpeg,image/gif" />-->
      <!--  <input id="file" type="file" name="file" size="30" accept="file_extension|audio/*" />-->
      <input id="imgfile1" class="imgfile" type="text" placeholder="1. paste file path here" />
      <input id="imgfile2" class="imgfile" type="text" placeholder="2. paste file path here" />
      <input id="imgfile3" class="imgfile" type="text" placeholder="3. paste file path here" />
      <input id="imgfile4" class="imgfile" type="text" placeholder="4. paste file path here" />
      <input id="imgfile5" class="imgfile" type="text" placeholder="5. paste file path here" />

    </div>
    <div class="col-right">
      <img src="<?php echo  WP_SITEURL; ?>/wp-content/plugins/mm-lifterlms-addons/images/icons/img-icon.svg" />
   </div>
  </div>


<!-- docs -->
  <div class="dropzone" id="dropzone-docs">
    <div class="col-left" id="docs-leftCol">
      <!--  <input id="file" type="file" name="file" size="30" accept="file_extension|media_type" />-->
      <p>Paste document file paths here for uploading</p>
      <input id="docfile1" class="docfile" type="text" placeholder="1. paste file path here" />
      <input id="docfile2" class="docfile" type="text" placeholder="2. paste file path here" />
      <input id="docfile3" class="docfile" type="text" placeholder="3. paste file path here" />
      <input id="docfile4" class="docfile" type="text" placeholder="4. paste file path here" />
      <input id="docfile5" class="docfile" type="text" placeholder="5. paste file path here" />
    </div>
    <div class="col-right">
      <img src="<?php echo  WP_SITEURL; ?>/wp-content/plugins/mm-lifterlms-addons/images/icons/file-icon.svg" />
    </div>
  </div>
  <div class="action-buttons"><button id="upload-files" class="button">Upload files</button></div>
</div>
