<?php
include '../../connect.php';
include '../chekc_admin.php';
?>

<?php
$userid = $_GET['id'];
$sql = "delete from users where id = '$userid'";
$result = mysqli_query($conn, $sql);

?>
<script>
    alert("<?php echo "$userid"?> 유저가 삭제되었습니다.");
    location.href = 'managerUsers.php';
</script>