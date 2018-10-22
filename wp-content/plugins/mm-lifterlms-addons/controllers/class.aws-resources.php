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

  public function fullUpload($assetid=0, $assetslug=NULL,$filepath=NULL){
    $keyPrefix = $assetid.'_'.$assetslug;
    try {
      error_log("inside FUllUPload".$assetid);
      $this->s3->uploadDirectory( $filepath, $this->bucket, $keyPrefix, array(
        'params'      => array('ACL' => 'public-read'),
        'concurrency' => 20,
        'debug'       => true,
        'force'       => true ));
      } catch(s3Exception $e){
        error_log("fullUpload s3Error:::".$e);
      }
  }


/*
@Function Name: standardUpload()
@vars: [ $action=NULL, $assetid=0, $assetslug=NULL, $base64=NULL,$filename=NULL ]
@Description: standard upload function or all files below 4.99GB. @Function LargeUploder()
should be used for files over 4.99 GB - as they require the aws part uploader.
command line for php upload.
php aws s3 cp '. $file['path'].$file['filename'].' s3://my-first-backup-bucket/
$filename=NULL,$filedata=NULL
*/
  public function standardUpload($assetid=0, $assetslug=NULL,$filepath){

    $result   = NULL;
    $keyName  = $assetid.'_'.$assetslug;
    $filename = preg_replace('/^.+\\\\/', '', $filepath);

    error_log($assetid.'<br><br>'.$assetslug);
    die();

    $filetype = $this->checkFileType($filename);
    $newfilename = $assetid.'_'.$assetslug.'_'.$filename;

    // check the filetype to determine the directory the file should be saved in.
    if( $filetype !== '' ){  $keyname=$keyname.'/'.$filetype; error_log("SU::checkFileType>>".$keyname); }


    if( $this->s3->doesobjectExist(BUCKNAME,$keyname) == false ){

        $this->s3->putObject( array('Bucket'=>$this->bucket,
                              'Key' =>$keyname,
                              'StorageClass' => 'STANDARD',
                              'ACL' =>'public-read'	)	);
        $this->s3->waitUntil('BucketExists', array('Bucket' => $keyname));
    }


    // if( $filetype == 'video' ){
    //   error_log("SU::IfFileTypeVideo");
    //   return $this->largeUpload($filename,$asset,$path,$filedata);
    // }else{
    try {
        error_log("SU::startS3Upload:::".$filepath);

  		    $result = $this->s3->putObject( array('Bucket'=>$this->bucket,
                                  'Key' =>$keyname,
                                  'SourceFile' => $filepath,
                                  'StorageClass' => 'STANDARD',
                                  'ACL' =>'public-read'	)	);

          error_log("SU::PassedS3Upload");
          return $result['ObjectURL'] . PHP_EOL;

  	  } catch (S3Exception $e) {
        error_log("SU::s3UploadException");
        error_log($e->getMessage() . PHP_EOL);
  		    $result = $e->getMessage() . PHP_EOL;
      }
      return $result;
  wp_die(); // prevent 0 output
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

  public function getPresignedUrl(){
    //Creating a presigned URL
    $cmd = $this->s3->getCommand('putObject', [
        'Bucket' => $this->bucket,
        'Key' => $this->s3key
    ]);

    $request = $this->s3->createPresignedRequest($cmd, '+30 minutes');

    // Get the actual presigned-url
    $presignedUrl = (string)$request->getUri();
    return $presignedUrl;
  }

}

?>
