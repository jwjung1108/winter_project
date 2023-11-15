<?php
include '../../connect.php';

$number = $_GET['number'];

$sql = "select * from board where number = $number";
$result = mysqli_fetch_array(mysqli_query($conn,$sql));
$filepath = $result['filepath'];
$filesize = filesize($filepath);
$path_parts = pathinfo($filepath);
// $filename = $path_parts['basename'];
$filename = $result['filename'];
$extension = $path_parts['extension'];

header("Pragma: public");
header("Expires: 0");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Transfer-Encoding: binary");
header("Content-Length: $filesize");

ob_clean();
flush();
readfile($filepath);
?>