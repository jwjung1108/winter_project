<?php
include '../../connect.php';
include '../check_admin.php';
?>

<?php
$userid = $_GET['id'];
?>
<script>
    const data = confirm('사용자를 삭제하시겠습니까?')
    if (data) {
        <?php
        $sql = "delete from users where id = '$userid'";
        $result = mysqli_query($conn, $sql);
        ?>
        alert("<?php echo "$userid" ?> 유저가 삭제되었습니다.");
        location.href = 'managerUsers.php';
    }
    else {
        windows.location.href = 'managerUsers.php';
    }
</script>