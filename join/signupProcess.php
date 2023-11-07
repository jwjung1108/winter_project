<?php
include '../connect.php';
$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
$token = 1;
// $token = generateToken();

$authority = 1; //권한확인
$verify = 1; //이메일 인증 안될시 메인페이지 복귀

$sql = "
    insert into users
    (id, password, nickname, email, created,  authority, verify,token)
    values('{$_POST['id']}','{$hashedPassword}','{$_POST['nickname']}','{$_POST['email']}', NOW(), '{$authority}', '{$verify}', '{$token}')";

if ($_POST['id'] == ' ') {
    ?>
    <script>
        alert("아이디를 다시 입력해 주세요");
        location.href = "../index.php";
    </script>
    <?php
} else {
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        ?>
        <script>
            alert("저장에 문제가 생겼습니다. 관리자에게 문의해주세요.");
            location.href = "../index.php";
        </script>
        <?php
    } else {
        // sendVerificationEmail($_POST['email'], $token);

        ?>
        <script>
            alert("회원가입이 완료되었습니다");
            location.href = "../index.php";
        </script>
        <?php
    }
}

// function generateToken()
// {
//     // 토큰 생성 로직 작성 (예: 랜덤한 문자열 생성)
//     // 적절한 방법으로 고유한 토큰을 생성하는 로직을 구현해야 합니다.
//     // 예시로 현재 시간을 이용한 임시 방법으로 작성되었습니다.
//     $timestamp = time();
//     $token = md5($timestamp);
//     return $token;
// }

// function sendVerificationEmail($email, $token)
// {
//     // 이메일 전송 로직 작성
//     // 실제로 이메일을 전송하는 코드를 작성해야 합니다.
//     // 예시로 현재는 단순히 텍스트로 출력하는 방식으로 작성되었습니다.
//     include_once('./mailer.lib.php');
//     $verificationLink = "http://127.0.0.1/join/verify.php?token=" . $token;
//     $message = "인증을 완료하려면 아래 링크를 클릭하세요:\n\n" . $verificationLink;
//     $subject = "회원가입 인증 이메일";

//     // 메일 전송
//     // mailer("보내는 사람 이름", "보내는 사람 메일주소", "받는 사람 메일주소", "제목", "내용", "1");
//     $emailSent = mailer("admin", "보내는 사람 메일주소", $email, $subject, $message, 1);

//     return $emailSent;
// }
?>