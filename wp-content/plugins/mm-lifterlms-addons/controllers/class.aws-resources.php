<?php
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class AWS_GetResources{

  public function __construct(){
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
@vars: [ $action=NULL, $assetid=0, $assetslug=NULL, $base64=NULL,$filename=NULL ]
@Description: standard upload function or all files below 4.99GB. @Function LargeUploder()
should be used for files over 4.99 GB - as they require the aws part uploader.
command line for php upload.
php aws s3 cp '. $file['path'].$file['filename'].' s3://my-first-backup-bucket/

*/
  public function standardUpload($assetid=0, $assetslug=NULL,$filename=NULL,$file=NULL,$imagedata=NULL){

    error_log($assetid.'<br><br>'.$assetslug.'<br><br>'.$filename);
    error_log("SU::top");
    $result   = NULL;
    $keyName  = $assetid.'_'.$assetslug.'/';
    $path     = S3URL.'/'.BUCKNAME.'/'.$keyName;
    $filetype = $this->checkFileType($filename);
    $filename = $assetid.'_'.$assetslug.'_'.$filename;

    // check the filetype to determine the directory the file should be saved in.
    if( $filetype !== '' ){
      $path=$path.$filetype;
      error_log("SU::checkFileType".$path);
    }

    if( $filetype == 'video' ){
      error_log("SU::IfFileTypeVideo");
      return $this->largeUpload($filename,$asset,$path);
    }else{
      try {
        error_log("SU::startS3Upload");
         if($filetype == 'images' && $imagedata != NULL){
           $filename = $imagedata;
         }
  		    $result = $this->s3->putObject( array('Bucket'=>$this->bucket,
                                  'Key' =>$path,
                                  'SourceFile' => $filename,
                                  'StorageClass' => 'REDUCED_REDUNDANCY',
                                  'ACL' =>'public-read'	)	);
          error_log("SU::PassedS3Upload");
          return $result['ObjectURL'] . PHP_EOL;
  	  } catch (S3Exception $e) {
        error_log("SU::s3UploadException");
  		    $result = $e->getMessage() . PHP_EOL;
      }
      return $result;
  }
  wp_die(); // prevent 0 output
}

// s3 part uploader for files over 5GB.
  public function largeUpload(array $files, array $assets,$directory='images'){

  }

  /**===== HELPER FUNCTIONS=== **/

  public function checkFileType($file){
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
