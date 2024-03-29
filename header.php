<script src="lib/jquery-3.4.1.js"></script>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="lib/time_table/TimeTable.css" />
<script src="lib/time_table/createjs.min.js"></script>
<script src="lib/time_table/TimeTable.js"></script>
<link rel="stylesheet" type="text/css" href="lib/date_picker/daterangepicker.css" />
<script src="lib/date_picker/moment.min.js"></script>
<script src="lib/date_picker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/toast/jquery.toast.min.css" />
<script src="lib/toast/jquery.toast.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/chosen/chosen.css" />
<script src="lib/chosen/chosen.jquery.js"></script>
<script src="lib/common.js"></script>
<link rel="shortcut icon" type="image/png" href="favicon.png"/>
<script src="https://kit.fontawesome.com/93ec6d166b.js" crossorigin="anonymous"></script>
<script src='./table2excel/table2excel.js'></script>
<script src='./table2excel/table2excel.min.js'></script>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
</style>
<section class="">
	<nav class="navbar navbar-expand-lg navbar-light bg-dark ">
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto ">
				<li class="nav-item active">
					<a class="nav-link text-light" href='index.php' id='navHome'>Trang chủ<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link  text-light" href='khachhang.php' id='navKH'>Khách hàng</a>
				</li>
				<li class="nav-item">
					<a class="nav-link  text-light" id='navDT' href='doanhthu.php'>Doanh thu</a> 
				</li>
				<li class="nav-item">
					<a class="nav-link  text-light"  href='san.php' id='navSB'>Sân Bóng</a>
				</li>
				<li class="nav-item">
					<a class="nav-link  text-light"  href='kho.php' id='navKho'>Kho hàng</a>
				</li>
				<li class="nav-item">
					<a class="nav-link  text-light"  href='ThongKe.php' id='navThongKe'>Thông Kê</a>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link  text-light"  href='./lib/test.php' id='navThongKe'>Test</a>
				</li> -->
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<a class='nav-link text-light'  href='taikhoan.php'><i class="fas fa-user" style="margin-right:10px"></i><span id="taikhoan_user"><?php echo $_SESSION['login_user']; ?></span></a>
				<button class="btn btn-danger p-0"><a class="nav-link text-dark p-1"  href='logout.php'>Đăng xuất</a></button>
			</form>
		</div>
	</nav>
</section>
<br />
<br />
<!-- <script>
$(document).ready(function() {
	if (window.location.pathname == "/quanlysanbong/index.php") {
		$("#navHome").css("color", "#d81b60");
	}
	if (window.location.pathname == "/quanlysanbong/khachhang.php") {
		$("#navKH").css("color", "#d81b60");
	}
	if (window.location.pathname == "/quanlysanbong/doanhthu.php") {
		$("#navDT").css("color", "#d81b60");
	}
	if (window.location.pathname == "/quanlysanbong/san.php") {
		$("#navSB").css("color", "#d81b60");
	}
});
</script> -->

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>