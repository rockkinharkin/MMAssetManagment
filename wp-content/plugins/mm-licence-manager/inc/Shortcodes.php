<?php
class scLoadAssets{

  public function __construct(){
    $this->awsResources = new AWS_GetResources;
    $this->plugin_url = plugins_url() . '/mm-licence-manager/';
  }

  public function init(){
    $this->hooks();
  }

  public function scAssets(){
    $resources = $this->awsResources->getResources();
    return print_r( $resources );
    /**$items=[];
    foreach ( $resources['Contents'] as $item ){
      array_push($items,$item);
    }
  return print_r( $items );

  //  return $this->assetListHtml();**/
  }

  public function scSingleAsset( $content="null" ){
    $assetid=0;

    if( isset( $_GET['assetid']) && $_GET['assetid'] > 0 ){ $assetid=$_GET['assetid']; }
    $content  = $this->singleAssetHtml($assetid);
    return $content;
  }

/*
@params $totals Object theAsset ]
@params $image string - url of the preview image for the asset.
  **/
public function buildAssetModule( object $theAsset, $img ){
  //$totals = $this->countFiles();

  $content = '';
  $content .= '<div class="module">
    <div id="stats-icons">
        <img alt="Total Videos" src="'.$this->plugin_url.'icons/video-icon.svg">
        <img alt="Total Images" src="'.$this->plugin_url.'icons/img-icon.svg">
        <img alt="Total Audio Files" src="'.$this->plugin_url.'icons/audio-icon.svg">
        <img alt="Total Documents" src="'.$this->plugin_url.'icons/file-icon.svg">
    </div><br>
    <div id="stats-nums">
        <a alt="Total Videos" id="video-total" href="">'.$totals->videos.'</a>
        <a id="img-total" href="">'.$totals->images.'</a>
        <a id="audio-total" href="">'.$totals->audio.'</a>
        <a id="doc-total" href="">'.$totals->documents.'</a>
    </div>
    <img src="http://mycreativelearning.com/wp-content/uploads/2016/06/1AKIG.png"  alt="" />
    <p>'.$theAsset->name.'</p>
  </div>';
  return $content;
}
  public function assetListHtml(){

    return '<div class="autowide">
          <!-- First Row -->
        	<div class="module">
            <div id="stats-icons">
                <img alt="Total Videos" src="'.$this->plugin_url.'icons/video-icon.svg">
                <img alt="Total Images" src="'.$this->plugin_url.'icons/img-icon.svg">
                <img alt="Total Audio Files" src="'.$this->plugin_url.'icons/audio-icon.svg">
                <img alt="Total Documents" src="'.$this->plugin_url.'icons/file-icon.svg">
            </div><br>
            <div id="stats-nums">
                <a alt="Total Videos" id="video-total" href="">97</a>
                <a id="img-total" href="">11</a>
                <a id="audio-total" href="">27</a>
                <a id="doc-total" href="">12</a>
            </div>
            <img src="http://mycreativelearning.com/wp-content/uploads/2016/06/1AKIG.png"  alt="" />
            <p><a href="'.WP_SITEURL.'/asset?assetid=457">CREATIVE LEARNING</a></p>
        	</div>

          <div class="module">
            <div id="stats-icons">
                <img src="'.$this->plugin_url.'icons/video-icon.svg">
                <img src="'.$this->plugin_url.'icons/img-icon.svg">
                <img src="'.$this->plugin_url.'icons/audio-icon.svg">
                <img src="'.$this->plugin_url.'icons/file-icon.svg">
            </div><br>
            <div id="stats-nums">
                <a id="video-total" href="">97</a>
                <a id="img-total" href="">11</a>
                <a id="audio-total" href="">27</a>
                <a id="doc-total" href="">12</a>
            </div>
            <img src="http://mycreativelearning.com/wp-content/uploads/2016/06/1AKIG.png"  alt="" />
            <p><a href="'.WP_SITEURL.'/asset?assetid=457">CLASS PROJECTS</a></p>
          </div>

          <div class="module">
            <div id="stats-icons">
                <img src="'.$this->plugin_url.'icons/video-icon.svg">
                <img src="'.$this->plugin_url.'icons/img-icon.svg">
                <img src="'.$this->plugin_url.'icons/audio-icon.svg">
                <img src="'.$this->plugin_url.'icons/file-icon.svg">
            </div><br>
            <div id="stats-nums">
                <a id="video-total" href="">97</a>
                <a id="img-total" href="">11</a>
                <a id="audio-total" href="">27</a>
                <a id="doc-total" href="">12</a>
            </div>
            <img src="http://mycreativelearning.com/wp-content/uploads/2016/06/1AKIG.png"  alt="" />
            <p><a href="'.WP_SITEURL.'/asset?assetid=457">ART & DESIGN</a></p>
          </div>

          <div class="module">
            <div id="stats-icons">
                <img src="'.$this->plugin_url.'icons/video-icon.svg">
                <img src="'.$this->plugin_url.'icons/img-icon.svg">
                <img src="'.$this->plugin_url.'icons/audio-icon.svg">
                <img src="'.$this->plugin_url.'icons/file-icon.svg">
            </div><br>
            <div id="stats-nums">
                <a id="video-total" href="">97</a>
                <a id="img-total" href="">11</a>
                <a id="audio-total" href="">27</a>
                <a id="doc-total" href="">12</a>
            </div>
            <img src="http://mycreativelearning.com/wp-content/uploads/2016/06/1AKIG.png"  alt="" />
            <p><a href="'.WP_SITEURL.'/asset?assetid=457">A TEACHERS GUIDE</a></p>
          </div>
        </div><!-- autowide -->
        <!-- end first row -->

        <!-- Second Row -->
        <div class="autowide">
          <div class="module">
            <div id="stats-icons">
                <img src="'.$this->plugin_url.'icons/video-icon.svg">
                <img src="'.$this->plugin_url.'icons/img-icon.svg">
                <img src="'.$this->plugin_url.'icons/audio-icon.svg">
                <img src="'.$this->plugin_url.'icons/file-icon.svg">
            </div><br>
            <div id="stats-nums">
                <a id="video-total" href="">97</a>
                <a id="img-total" href="">11</a>
                <a id="audio-total" href="">27</a>
                <a id="doc-total" href="">12</a>
            </div>
            <img src="http://mycreativelearning.com/wp-content/uploads/2016/06/1AKIG.png"  alt="" />
            <p><a href="'.WP_SITEURL.'/asset?assetid=457">CREATIVE LEARNING</a></p>
          </div>

          <div class="module">
            <div id="stats-icons">
                <img src="'.$this->plugin_url.'icons/video-icon.svg">
                <img src="'.$this->plugin_url.'icons/img-icon.svg">
                <img src="'.$this->plugin_url.'icons/audio-icon.svg">
                <img src="'.$this->plugin_url.'icons/file-icon.svg">
            </div><br>
            <div id="stats-nums">
                <a id="video-total" href="">97</a>
                <a id="img-total" href="">11</a>
                <a id="audio-total" href="">27</a>
                <a id="doc-total" href="">12</a>
            </div>
            <img src="http://mycreativelearning.com/wp-content/uploads/2016/06/1AKIG.png"  alt="" />
            <p><a href="'.WP_SITEURL.'/asset?assetid=457">CREATIVE LEARNING</a></p>
          </div>

          <div class="module">
            <div id="stats-icons">
                <img src="'.$this->plugin_url.'icons/video-icon.svg">
                <img src="'.$this->plugin_url.'icons/img-icon.svg">
                <img src="'.$this->plugin_url.'icons/audio-icon.svg">
                <img src="'.$this->plugin_url.'icons/file-icon.svg">
            </div><br>
            <div id="stats-nums">
                <a id="total-videos" id="video-total" href="">97</a>
                <a id="img-total" href="">11</a>
                <a id="audio-total" href="">27</a>
                <a id="doc-total" href="">12</a>
            </div>
            <img src="http://mycreativelearning.com/wp-content/uploads/2016/06/1AKIG.png"  alt="" />
            <p><a href="'.WP_SITEURL.'/asset?assetid=457">CREATIVE LEARNING</a></p>
          </div>

          <div class="module">
            <div id="stats-icons">
                <img src="'.$this->plugin_url.'icons/video-icon.svg">
                <img src="'.$this->plugin_url.'icons/img-icon.svg">
                <img src="'.$this->plugin_url.'icons/audio-icon.svg">
                <img src="'.$this->plugin_url.'icons/file-icon.svg">
            </div><br>
            <div id="stats-nums">
                <a id="video-total" href="">97</a>
                <a id="img-total" href="">11</a>
                <a id="audio-total" href="">27</a>
                <a id="doc-total" href="">12</a>
            </div>
            <p> <img src="http://mycreativelearning.com/wp-content/uploads/2016/06/1AKIG.png"  alt="" />
            <a href="'.WP_SITEURL.'/asset?assetid=457">CREATIVE LEARNING></a></p>
          </div>
        </div> <!-- autowide -->
        <!-- end second row -->';
  }

  public function singleAssetHtml($atts=[]){
    return '<div class="autowide">
            <div id="licence-container">
              <h2>Licences</h2>
              <table>
                <tr>
                  <th>CUSTOMER</th>
                  <th>EMAIL</th>
                  <th>ISSUE DATE</th>
                  <th>EXPIRARY DATE</th>
                </tr>
                <tr>
                  <td>CRAYOLA</td>
                  <td>Cjones@crayola.org</td>
                  <td>27/07/2018</td>
                  <td>27/07/2019</td>
                </tr>
                </table>
            </div>
            <div id="assets-container">
              <!-- video list section -->
              <div id="video-header" class="sectiontitle">VIDEOS</div>
              <div id="vid-list">
                <ul>
                  <li class="filelists">
                  <a class="filename" href="">457_Creative_Learning_GP_320x240_20mb.3gp</a>
                  <a id="previewVid" class="button" href="" onClick="LoadVideo()">PREVIEW</a>
                  <a id="copylink" class="button" href="" onCLick="copyLink" >COPY VIDEO SOURCE LINK</a>
                  <a id="embedCode" class="button" fileid="" href="" onClick="loadEmbedCode()">EMBED CODE</a>
                  </li>
                </ul>
              </div>
               <!-- audio list section -->
               <div id="audio-header" class="sectiontitle">AUDIO</div>
               <div id="audio-list">
                 <ul>
                   <li class="filelists" ></li>
                 </ul>
               </div>

               <!-- Images list section -->
               <div id="images-header" class="sectiontitle">IMAGES</div>
               <div id="img-list">
                 <ul>
                   <li class="filelists"></li>
                 </ul>
               </div>

               <!-- documents list section-->
               <div id="docs-header" class="sectiontitle">DOCUMENTS</div>
               <div id="doc-list">
                 <ul>
                   <li  class="filelists"></li>
                 </ul>
               </div>
            </div>
            </div>';

  }

  /*
  Stylesheets
  */
  public function mmlmLoadScripts(){
  	wp_register_style( 'mmlm-frontend', $this->plugin_url.'/css/mm-licence-manager-frontend.css' );
  	wp_enqueue_style( 'mmlm-frontend' );
  }


  /**
   * Registers WordPress actions
   */
  private function hooks() {
    $scLoadAssets = new scLoadAssets;
    add_action( 'wp_enqueue_scripts', array( $scLoadAssets, 'mmlmLoadScripts') );
    add_shortcode('assetlist', array( $scLoadAssets,'scAssets') );
    add_shortcode('singleasset', array( $scLoadAssets,'scSingleAsset') );
  }
}

?>
