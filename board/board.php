<?php
	$db = mysqli_connect("localhost", "root", "123456", "team_project") or die(mysqli_error());
?>
<!DOCTYPE html>
<html>
	<meta charset = "utf-8">
	<head>
		<title>留言板</title>
	</head>
	<body>
		<form name = "board" action = "board.php" method = "post">
			<p>暱稱</p>
            <p><input type="text" name="name"></p>
            <p>主題</p>
            <p><input type="text" name="subject"></p>
            <p>留言</p>
            <p><textarea style = "width:550px;height:100px;" name="content"></textarea></p>
            <p><input type="submit" name="submit" value="SEND">
		<div class="flex-center position-ref full-height">
			<div class="top-right home"></div>
		</div>
		<div class="note full-height">
			<?php
				session_start();
				$sql = "select * from guestbook order by time desc limit 5";
				$sql_ = "select * from guestbook";
				$result = mysqli_query($db, $sql);
				$result_ = mysqli_query($db, $sql_);
				while($row = mysqli_fetch_assoc($result))
				{
					echo "<br>暱稱：" . $row['name'];
					echo "<br>主題：" . $row['subject'];
					echo "<br>留言：" . nl2br($row['content']) . "<br>";
					echo "時間：" . $row['time'] . "<br>";
					echo "<hr>";
				}
				echo "<br>";
				echo '<div class="bottom left position-abs content">';
				echo "一共有" . mysqli_num_rows($result_) . "則留言";
				echo "<br>目前顯示最新5則留言";
			?>
		</div>
	</body>

<?php
	if(isset($_POST['submit']))
	{
		$name = $_POST['name'];
		$subject = $_POST['subject'];
		$content = $_POST['content'];
		$sql = "INSERT guestbook(name, subject, content, time) VALUES ('$name', '$subject', '$content', now())";
		if(!mysqli_query($db, $sql))
		{
			die(mysqli_error());
		}
		else
		{
			echo"<script>window.location.href='board.php';</script>";
		}
	}
?>