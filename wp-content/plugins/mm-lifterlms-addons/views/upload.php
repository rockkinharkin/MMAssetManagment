<div class="main-contanier" id="mm-asset-container">
<!-- video -->
  <div class="dropzone" id="dropzone-video">
    <div class="col-left" id="vid-leftCol">
      <p>Drop video files here for uploading</p>
      <ul id="vid-list"></ul>
      <!--input id="file" type="file" name="file" size="30" accept="file_extension|video/*" />-->
    </div>
    <div class="col-right">
        <img src="<?php echo  WP_SITEURL; ?>/wp-content/plugins/mm-lifterlms-addons/images/icons/video-icon.svg" />
    </div>
  </div>

<!-- audio -->
  <div class="dropzone" id="dropzone-audio">
    <div class="col-left" id="audio-leftCol">
      <p>Drop audio files here for uploading</p>
    <!--  <input id="file" type="file" name="file" size="30" accept="file_extension|audio/*" />-->
    </div>
    <div class="col-right">
      <img src="<?php echo  WP_SITEURL; ?>/wp-content/plugins/mm-lifterlms-addons/images/icons/audio-icon.svg" />
   </div>
  </div>


  <!--Images -->
  <div class="dropzone" id="dropzone-images">
    <div class="col-left" id="img-leftCol">
      <p>Drop image files here for uploading</p>
    <!--  <input id="file" type="file" name="file" size="30" accept="file_extension|image/jpg,image/png,image/jpeg,image/gif" />-->
    </div>
    <div class="col-right">
      <img src="<?php echo  WP_SITEURL; ?>/wp-content/plugins/mm-lifterlms-addons/images/icons/img-icon.svg" />
   </div>
  </div>


<!-- docs -->
  <div class="dropzone" id="dropzone-docs">
    <div class="col-left" id="docs-leftCol">
      <!--  <input id="file" type="file" name="file" size="30" accept="file_extension|media_type" />-->
      <p>Drop document files here for uploading</p>
    </div>
    <div class="col-right">
      <img src="<?php echo  WP_SITEURL; ?>/wp-content/plugins/mm-lifterlms-addons/images/icons/file-icon.svg" />
    </div>
  </div>
  <div class="action-buttons"><button id="upload-files" class="button">Upload files</button></div>
</div>
