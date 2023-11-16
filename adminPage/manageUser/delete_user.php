<?php
include '../../connect.php';
include '../check_admin.php';
?>

<?php
$userid = $_GET['id'];

echo "<script>";
echo "if(confirm('사용자를 삭제하시겠습니까?')) {";
$sql = "delete from users where id = '$userid'";
$result = mysqli_query($conn, $sql);
?>
<script>
    alert("<?php echo "$userid" ?> 유저가 삭제되었습니다.");
    location.href = 'managerUsers.php';
</script>
<?php
echo "} else {";
echo "  window.location.href = 'managerUsers.php';";
echo "}";
echo "</script>";





?>