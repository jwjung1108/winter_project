<?php
include '../../connect.php';
include '../check_admin.php';

$userid = isset($_GET['user']) ? $_GET['user'] : '';
$rank = isset($_GET['rank']) ? $_GET['rank'] : '';

$sql = 'select * from users';
$result = mysqli_fetch_array(mysqli_query($conn, $sql));

if($result['id'] === "$userid"){
    ?>
    <script>
        alert('사용자가 존재하지 않습니다.');
        location.href='managerUsers.php';
    </script>
    <?php
}
else{
    echo "Hello World!";
    echo "$userid";
    echo "$rank";
}


?>