<?php
include '../../connect.php';
include '../check_admin.php';

$userid = isset($_GET['user']) ? $_GET['user'] : '';
$rank = isset($_GET['rank']) ? $_GET['rank'] : '';

$sql = "select * from users where id = '$userid'";
$result = mysqli_fetch_array(mysqli_query($conn, $sql));
$pre_rank = $result['user_rank'];

if ($result) {
    echo "$userid 변경\n";
    echo "$pre_rank -> ";
    $sql = "update users set user_rank ='$rank'";
    mysqli_query($conn, $sql);
    echo "$rank";
} else {
    ?>
    <script>
        alert('사용자가 존재하지 않습니다.');
        location.href = 'managerUsers.php';
    </script>
    <?php

}


?>