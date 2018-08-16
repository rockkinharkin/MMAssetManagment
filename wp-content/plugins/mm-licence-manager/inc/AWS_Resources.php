<?php
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class AWS_GetResources{
  public function __construct(){
    $this->s3 = new S3Client( [ 'version' => 'latest',
                                'region' => 'eu-west-1',
                                'credentials' => [ 'key' => "AKIAIRYJVAG24ZMBKGAQ",'secret' => "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" ]
                              ] );
}

  public function getResources(){
    $key = "AKIAIRYJVAG24ZMBKGAQ";
    $filelist = $this->s3->ListObjectsV2([ 'Bucket' => 'courses.makematic.com',
                                        'Key' => $key,
                                        'Marker' =>'Key',
                                        'EncodingType' => 'url',
                                        'MaxKeys' => 30
                                      ]);

    return $this->buildAssetModule( $filelist );
  }

  public function buildAssetModule( $fileList=[] ){
    
    //return print_r( $resources );
    if( !empty( $fileList) ){
      /*foreach ( as $item ){
        array_push($items, $item);
      }*/
      return print_r( $fileList['Contents'] ) ;
    }
    return true;
  }

  public function upload(array $file){

    //php aws s3 cp $file['path'].$file['filename']“C:\users\my first backup.bak” s3://my-first-backup-bucket/
  }


  /**===== HELPER FUNCTIONS=== **/
  private function countFiles( $filelist ){

  }

}
?>
