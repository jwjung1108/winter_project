<?php
$connect = mysqli_connect("localhost","jiwon","shield1496@","coding");
 
if($connect->connect_errno){
    echo '[연결실패..] : '.$connect->connect_error.'';
}else{
    echo '[연결성공!]'.'<br>';
}
 
?>