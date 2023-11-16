<?php
session_start();

include '../../connect.php';


// 연결 성공 시, 여기에 작업을 수행할 수 있습니다.

// 게시물 ID 가져오기
$postId = $_GET['number'];
$username = $_SESSION['userId'];

// Prepared Statements를 사용하여 SQL Injection 방지
// 게시글에 대한 사용자별 추천 여부 확인
$check_user = (mysqli_query($conn, "select * from post_likes where username='" . $_SESSION['userId'] . "' and post_id = '$postId'"));
$row = mysqli_fetch_array($check_user);

$isLiked = mysqli_num_rows($check_user) > 0;

if (!$isLiked) {
    // 게시글에 대한 추천 기록 삽입
    $sql = "insert into post_likes(post_id, username,created) values('$postId','$username',NOW())";
    mysqli_query($conn, $sql);

    // 게시글 추천 수 업데이트
    $sql = "update reference set likes = likes + 1 where number = '$postId'";
    mysqli_query($conn, $sql);
    // 추천 완료 메시지 출력
    ?>
    <script>
        alert("추천되었습니다.");
        location.href = "r_readBoard.php?number=<?php echo $postId?>";
    </script>
<?php
} else {
    // 이미 추천한 경우 메시지 출력
    ?>
    <script>
        alert("이미 추천되었습니다.");
        location.href = "r_readBoard.php?number=<?php echo $postId?>";
    </script>
<?php
}

// 데이터베이스 연결 종료
?>