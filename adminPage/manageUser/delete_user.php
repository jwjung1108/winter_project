<?php
include '../../connect.php';
include '../check_admin.php';

if(isset($_GET['id'])) {
    $userid = $_GET['id'];
?>

<script>
    const confirmed = confirm('사용자를 삭제하시겠습니까?');
    if (confirmed) {
        window.location.href = 'delete_user.php?id=<?php echo $userid; ?>';
    } else {
        window.location.href = 'managerUsers.php';
    }
</script>

<?php
} else {
    echo "사용자 ID가 제공되지 않았습니다.";
}
?>
