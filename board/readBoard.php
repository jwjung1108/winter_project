<?php
include '../connect.php';
session_start();

$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
if($userId == ''){
    ?>
        <script>
            alert("로그인을 해주세요");
            location.href = "../index.php";
        </script>
    <?php
    exit();
}
$v_sql = "select verify from users where id = '$userId'";
$v_check = mysqli_fetch_array(mysqli_query($conn, $v_sql));

if($v_check['verify'] == 0){
    ?>
    <script>
        alert("이메일인증을 진행해주세요");
        location.href = "../index.php";
    </script>
    <?php
    exit();
}
?>

<!doctype html>

<head>
	<meta charset="UTF-8">
	<title>게시판</title>
	<link rel="stylesheet" type="text/css" href="/BBS/css/style.css" />
</head>

<body>
	<?php
	$number = $_GET['number']; /* bno함수에 title값을 받아와 넣음*/
	$board = mysqli_fetch_array(mysqli_query($conn, "select * from board where number ='" . $number . "'"));

	$check_table = (mysqli_query($conn, "select * from time where userID='" . $_SESSION['userId'] . "' and boardNumber = '$number'"));
	$row = mysqli_fetch_array($check_table);

	$result = mysqli_num_rows($check_table) > 0;

	// 현재시간
	$current_time = time();

	// time table access 시간
	$db_access = mysqli_fetch_array(mysqli_query($conn, "select access from time where boardNumber=$number and userID='{$_SESSION['userId']}'"));

	$fomater = "Y-m-d H:i:s";
	$view = $board['views'];

	if ($result) {
		if ($current_time - strtotime($db_access['access']) > 3600) {
			$view = $view + 1;
			if (mysqli_query($conn, "update board set views = '" . $view . "' where number = '" . $number . "'")) {
				$current_time = date($fomater, $current_time);
				mysqli_query($conn, "update time set access = '$current_time' where boardNumber = $number and userID = '{$_SESSION['userId']}'");
			}
		}
	} else {
		$view = $view + 1;
		$current_time = date($fomater, $current_time);
		mysqli_query($conn, "insert into time(userID,boardNumber, access) values('{$_SESSION['userId']}', $number, '$current_time')");
		mysqli_query($conn, "update board set views = '" . $view . "' where number = '" . $number . "'");
	}
	?>
	<!-- 글 불러오기 -->
	<div id="board_read">
		<h2>
			<?php echo $board['title']; ?>
		</h2>
		<div id="user_info">
			<?php echo $board['title']; ?>
			<?php echo $board['created']; ?> 조회:
			<?php echo $view; ?> 추천:
			<?php echo $board['likes']; ?>
			<div id="bo_line"></div>
		</div>
		<div id="bo_content">
			<?php echo nl2br($board['board']); ?>
		</div>
		<!-- 목록, 수정, 삭제 -->
		<div id="bo_ser">
			<ul>
				<li><a href="/">[목록으로]</a></li>
				<li><a href="replaceBoard.php?number=<?php echo $board['number']; ?>">[수정]</a></li>
				<li><a href="deleteBoard.php?number=<?php echo $board['number']; ?>">[삭제]</a></li>
				<li><a href="boardLike.php?number=<?php echo $board['number']; ?>">[추천]</a></li>
				<li><a href="download.php?number=<?php echo $board['number']; ?>">[다운로드]</a></li>

			</ul>
		</div>
	</div>

	<!-- 댓글 -->
	<?php
	$sql = "select * from comment where boardNumber = '$number'";
	$result = mysqli_query($conn, $sql);
	?>
	<div class="container">
		<h1 class="text-center">게시판</h1>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">번호</th>
					<th scope="col">내용</th>
					<th scope="col">작성자</th>
					<th scope="col">등록일</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				while ($row = mysqli_fetch_array($result)) {
					?>
					<tr>
						<th scope="row">
							<?php echo $i++; ?>
						</th>
						<td>
							<a>
								<?php
								if ($row['visible'] == 1) {
									echo $row['text'];
								} else {
									echo "삭제된 댓글입니다.";
								}
								?>
							</a>

							<!-- <a><?php echo $row['text']; ?></a> -->
						</td>
						<td>
							<?php echo $row['userID']; ?>
						</td>
						<td>
							<?php echo $row['created']; ?>
						</td>
						<td>
							<a href="deleteComment.php?Number=<?php echo $row['Number'] ?>"><?php echo "삭제"; ?></a>
						</td>
					</tr>
				<?php }
			?>
			</tbody>
		</table>
		<div class="text-center">
			<a href="writeComment.php?number=<?php echo $board['number']; ?>">[댓글작성]</a>
			<a href="/" class="btn btn-secondary">목록으로 돌아가기</a>
		</div>
	</div>





	</div>
</body>

</html>