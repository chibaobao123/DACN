<?php
	include("../config/config.php");
	session_start();
	
		if (isset($_POST['action']) && $_POST['action'] == 'dangnhap') {
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			$sql = "SELECT id FROM tai_khoan WHERE username='$username' OR email = '$username' AND password_id='$password'";
			$rs = mysqli_query($db, $sql);
			$count = mysqli_num_rows($rs);
			
			if ($count == 1) {
				$row = "SELECT admin_number, sdt, username FROM tai_khoan WHERE username='$username' OR email='$username'";
				$result = $db->query($row);
				$rss = mysqli_fetch_assoc($result);
				if ($rss['admin_number'] == 1){
					$_SESSION['admin_number'] = 1;
					$_SESSION['sdt_user'] = $rss['sdt'];
					$_SESSION['login_user'] = $rss['username'];
					echo "1";
				} else if ($rss['admin_number'] == 2){
					$_SESSION['admin_number'] = 2;
					$_SESSION['sdt_user'] = $rss['sdt'];
					$_SESSION['login_user'] = $rss['username'];
					echo "2";
			 	} else {
					$_SESSION['admin_number'] = 0;
					$_SESSION['sdt_user'] = $rss['sdt'];
					$_SESSION['login_user'] = $rss['username'];
					echo "0";
				}
			} else {
				echo "Tên đăng nhập hoặc mật khẩu không đúng!";
			}
		}
	
?>
