<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>QUẢN LÝ SÂN BÓNG</title>
<?php
	include("session.php");
	include("header.php");
?>

<section class="my-3 ">
	<div class="row">
		<div class="col">
			<button class="tonKho btn btn-secondary btn-lg" id="tonKho" onclick="getDataKhoHang()">Tổn kho kho</button>
			<button class="tonKho btn btn-secondary btn-lg" id="kiemKe" onclick="getDataKhoHangKiemKe()">Kiểm kê kho</button>
			<button class="phieuKiemKe btn btn-secondary btn-lg" id="phieuKiemKe" onclick="xuatPhieuKiemKe()">Phiếu kiểm kê</button>
		</div>
	</div>
</section>

<section id="kho">
</section>
<section id="xemPhieuKiemKe">
</section>
<section id="total" class='mr-3'>
</section>
<script>
	getDataKhoHang();
</script>