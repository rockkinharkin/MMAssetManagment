<?php
require_once ABSPATH.'wp-content/plugins/mm-lifter-lms-addons/aws-resources.php';

wp_head();

print_r($_FILES);

$fileData = $_POST['data'];
$assetId = $_POST['course_id'];

$awsres = new AWS_GetResources();
$awsres->standardUpload($fileData,$assetId);

wp_footer();
?>
