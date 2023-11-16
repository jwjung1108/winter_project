<?php
include '../../connect.php';
include '../check_admin.php';

if (isset($_GET['id']))
    $userid = $_GET['id'];

$sql = "delete from users where id = '$userid'";
$result = mysqli_query($conn, $sql);

if ($result) {
    ?>
    <script>
        alert("<?php echo "'$userid' 사용자가 삭제 되었습니다." ?>");
        window.location.href='manageUsers.php';
    </script>
    <?php
}
?>