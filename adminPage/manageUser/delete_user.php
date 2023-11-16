<?php
include '../../connect.php';
include '../check_admin.php';
?>

<?php
$userid = $_GET['id'];
?>
<script>
    if (confirm('사용자를 삭제하시겠습니까?')) {
</script>
    <?php
    $sql = "delete from users where id = '$userid'";
    $result = mysqli_query($conn, $sql);
    ?>
<script>
        alert("<?php echo "$userid" ?> 유저가 삭제되었습니다.");
        location.href = 'managerUsers.php';
</script>
}
else{
    windows.location.href = 'managerUsers.php';
}