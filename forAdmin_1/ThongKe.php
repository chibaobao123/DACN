<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>QUẢN LÝ SÂN BÓNG</title>
<?php
	include("session.php");
	include("header.php");
?>
<style>
	body{
		background-color: #d1dcde;
	}
</style>
<section class="my-3 ">
	<!-- <div class="row">
		<div class="col">
			<button class="tonKho btn btn-secondary btn-lg" id="tonKho" onclick="getDataKhoHang()">Tổn kho kho</button>
			<button class="tonKho btn btn-secondary btn-lg" id="kiemKe" onclick="getDataKhoHangKiemKe()">Kiểm kê kho</button>
			<button class="phieuKiemKe btn btn-secondary btn-lg" id="phieuKiemKe" onclick="xuatPhieuKiemKe()">Phiếu kiểm kê</button>
		</div>
	</div> -->
</section>

<section id="ThongKe" class="container">
	<h2>Tổng doang thu từng tháng</h2>
    <canvas id="ChartDoanhThu"></canvas>
	<br/>
	<br/>
	<br/>
	<h2 class='d-inline mr-3'>Tổng doan thu từng sân</h2> 
	<select id="select_san_chart" class='form-control w-50 d-inline' onchange='chartDoanhThuSanTheoThang(this.value)'></select>
	<div id='chart_san_bong'></div>
	<br/>
	<br/>
	<br/>
	<div class="soSanhChartSan">
		<h2>Chọn sân để xem biểu đồ thông tin</h2>
		<div id="multi_select_san_chart"></div>
		<div id="compare_san_chart" style='height:500px'></div>
	</div>
	<!-- <div class="soSanhSanPham">
		<h2>biểu đồ sản phẩm</h2>
	</div> -->
</section>

</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    chartDoanhThu()
	chartDoanhThuSan()
</script>