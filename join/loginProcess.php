<?php
$conn = mysqli_connect("localhost", "jiwon", "shield1496@", "coding");
//아이디 비교와 비밀번호 비교가 필요한 시점이다.
// 1차로 DB에서 비밀번호를 가져온다 
// 평문의 비밀번호와 암호화된 비밀번호를 비교해서 검증한다.
$id = trim($_POST['id']);

if ($id == null) {
    ?>
    <script>
        alert('아이디를 다시 입력해 주세요');
        location.href = "../index.php";
    </script>
    <?php
    exit();
} else {
    $password = $_POST['password'];

    $sql = "select * from users where id ='{$id}'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_array($result);
    $hashedPassword = $row['password'];
    $row['id'];

    foreach ($row as $key => $r) {
    }
    // echo $row['id'];
// DB 정보를 가져왔으니 
// 비밀번호 검증 로직을 실행하면 된다.
    $passwordResult = password_verify($password, $hashedPassword);
    if ($passwordResult === true) {
        session_start();
        $_SESSION['userId'] = $row['id'];
        $_SESSION['userName'] = $row['nickname'];
        if($row['authority'] == 2){
            $_SESSION['authority'] = 'admin';
        }
        ?>
        <script>
            alert("로그인에 성공하였습니다.")
            location.href = "../index.php";
        </script>
        <?php
    } else {
        // 로그인 실패 
        ?>
        <script>
            alert("로그인에 실패하였습니다");
            location.href = "./login.php";
        </script>
        <?php
    }
}
?>