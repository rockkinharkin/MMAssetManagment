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

/*
@FunctionName: getResources()
@Description: pulls down the files from s3 bucket. Takes in the folder path within the bucket
@vars: String $folder

*/
  public function getResources($folder=NULL){
    $filelist = $this->s3->getIterator( 'ListObjectsV2', array('Bucket'=>$this->bucket,"Prefix"=>$folder) );
    $files = [];
    foreach ($filelist as $object) {
      $files[] = $object;
    }
    return $files;
  }

/*
@Function Name: standardUpload()
@vars: [ array $file, array $asset ]
@Description: standard upload function or all files below 4.99GB. @Function LargeUploder()
should be used for files over 4.99 GB - as they require the aws part uploader.
command line for php upload.
php aws s3 cp '. $file['path'].$file['filename'].' s3://my-first-backup-bucket/

*/
  public function standardUpload($post,$assetid){
    $result   = NULL;
    $keyName  = $assetid.'_'.$asset['slug'].'/';
    $path     = S3URL.'/'.$bucketName.'/'. $keyName;

    // check the filetype to determine the directory the file should be saved in.
    if( $d=checkFileType($file) !== '' ){
      $path=$path.$d;
    }

    if( checkFileType($file) == 'video' ){
      return $this->largeUpload($file,$asset,$path);
    }else{
      try {
  		    $result = $this->s3->putObject( array('Bucket'=>$this->bucket,
                                  'Key' =>$path,
                                  'SourceFile' => $file,
                                  'StorageClass' => 'REDUCED_REDUNDANCY',
                                  'ACL' =>'public-read'	)	);
          echo $result['ObjectURL'] . PHP_EOL;
  	  } catch (S3Exception $e) {
  		    echo $e->getMessage() . PHP_EOL;
      }
  	return $result;
  }
}

// s3 part uploader for files over 5GB.
  public function largeUpload(array $file, array $asset,$directory='images'){

  }

  /**===== HELPER FUNCTIONS=== **/

  private function checkFileType($file){
    $dir='/';

    // if its a Video
    $vtypes = ['.mp4','.wav','.avi','.ogg','3G2','.3GP','.3GP2','.3GPP','.3GPP2','.3MM','.3P2','.AAF','.AEC','.AEGRAPHIC','.EXO','.F4V','.GVI','.HDMOV','.HDV','.M2T','.M4E','.M75'];

    foreach( $vtypes as $v ){
      if( strpos($file,$v) !== false ){ $dir='video'; }
    }

    // if it's audio
    $atypes = ['.3gp','.aa','.aac','.aax','.act','.aiff','.m4a',
                '.amr','.ape','.au','.awb','.dct','.dss','.dvf',
                '.dvf','.flac','.gsm','.iklax','.ivs','.m2a','.m4a','m4b',
                '.m4p','.mmf','.mp3','.mpc','.msv','.nsf','.ogg','.oga',
                '.mogg','.opus','.ra','.rm','.raw','.sln','.tta','.vox',
                '.wav','.wav','.wma','.wv','.webm','.8svx'];

    foreach( $atypes as $a ){
      if( strpos($file,$a) !== false ){ return $dir ='audio'; }
    }

    //images
    $imgtype = ['.jpeg','.jpg','.gif','.png','.tiff'] ;

    foreach ( $imgtype as $img ){
      if( strpos($file,$img) !== false ){ return $dir ='images';}
    }

    //documents
    $dtype = ['.doc','.pdf','.odt','.xls','.txt','.rtf','.ppt'];

    foreach( $dtype as $d ){
      if( strpos($file,$d) !== false ){ return $dir ='docs';}
    }
    return $dir;
  }

}

?>
