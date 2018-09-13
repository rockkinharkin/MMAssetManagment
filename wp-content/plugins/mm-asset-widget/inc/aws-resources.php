<?php
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class AWS_GetResources{
  public function __construct(){
    global $wp;
    $this->s3Key = "AKIAIX577NGXJQAJOWXQ";
    $this->s3Secret = "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";
    $this->bucket = 'courses.makematic.com';
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

  public function upload(array $file){

    //php aws s3 cp $file['path'].$file['filename']“C:\users\my first backup.bak” s3://my-first-backup-bucket/
  }


  /**===== HELPER FUNCTIONS=== **/
  private function countFiles( $filelist ){

  }

}

?>
