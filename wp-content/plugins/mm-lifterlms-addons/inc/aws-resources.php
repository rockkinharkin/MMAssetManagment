<?php
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class AWS_GetResources{
  public function __construct(){
    global $wp;
    $this->s3Key = ACCESSID;
    $this->s3Secret = LONGPASS;
    $this->bucket = BUCKNAME;
    $this->s3 = new S3Client( [ 'version' => 'latest',
                                'region' => 'eu-west-1',
                                'credentials' => [ 'key' => $this->s3Key ,'secret' =>$this->s3Secret ]
                              ] );
}

  public function getResources($folder=NULL){
    $filelist = $this->s3->getIterator( 'ListObjectsV2', array('Bucket'=>$this->bucket,"Prefix"=>$folder) );
    $files = [];
    foreach ($filelist as $object) {
      $files[] = $object;
    }
    return $files;
  }

  public function upload($file,array $asset){
    $keyName = $asset['course_id'].'_'.$asset['slug'].'/';
    $dir='';

    // check the filetype to determine the directory the file should be saved in.
    if( $d=checkFileType($file) !== '' ){
      $dir=$d;
    }

  	$pathInS3 = S3URL.'/'.$bucketName.'/'. $keyName.$dir;


  	// Add it to S3

  	try {

  		// Uploaded:

  		$s3->putObject( array('Bucket'=>$this->bucket,'Key' =>$this->s3key,'SourceFile' => $file,'StorageClass' => 'REDUCED_REDUNDANCY'	)	);

  	} catch (S3Exception $e) {

  		die('Error:' . $e->getMessage());

  	} catch (Exception $e) {

  		die('Error:' . $e->getMessage());

  	}

  	echo 'Done';

  	// Now that you have it working, I recommend adding some checks on the files.

  	// Example: Max size, allowed file types, etc.

      //php aws s3 cp $file['path'].$file['filename']“C:\users\my first backup.bak” s3://my-first-backup-bucket/
    }


  /**===== HELPER FUNCTIONS=== **/
  private function countFiles( $filelist ){

  }

  private function checkFileType($file){
    $dir='/';

    // if its a Video
    $vtypes = ['.mp4','.wav','.avi','.ogg'];

    foreach($vtypes as $v){
    if( strpos($file,$v) !== false ){ $dir='video'; }

    // audio
    $atypes = ['.3gp','.aa','.aac','.aax''.act','.aiff','.m4a',
                '.amr','.ape','.au','.awb','.dct','.dss','.dvf',
                '.dvf','.flac','.gsm','.iklax','.ivs','.m4a','m4b',
                '.m4p','.mmf','.mp3','.mpc','.msv','.nsf','.ogg','.oga',
                '.mogg','.opus','.ra','.rm','.raw','.sln','.tta','.vox',
                '.wav','.wav',.'wma','.wv','.webm','.8svx'
              ]

    foreach($atypes as $a){
      if( strpos($file,$a) !== false ){ return $dir ='audio'; }
    }

    //images
    $imgtype = ['jpeg','jpg','gif','png'];

    foreach($imgtype as $img){
      if( strpos($file,$d) !== false ) ){ return $dir ='images';}
    }

    //documents
    $dtype = ['doc','pdf','odt','xls','txt','rtf','ppt'];

    foreach($dtype as $d){
      if( strpos($file,$d) !== false ) ){ return $dir ='docs';}
    }

    return $dir;
  }

}

?>
