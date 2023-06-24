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
	<div class="row">
		<div class="col">
			<button class="tonKho btn btn-secondary btn-lg" id="tonKho" onclick="getDataKhoHang()">Tổn kho kho</button>
			<button class="tonKho btn btn-secondary btn-lg" id="kiemKe" onclick="getDataKhoHangKiemKe()">Kiểm kê kho</button>
			<button class="phieuKiemKe btn btn-secondary btn-lg" id="phieuKiemKe" onclick="xuatPhieuKiemKe()">Phiếu kiểm kê</button>
			<button class="btn btn-secondary btn-lg" id="ThemSanPhanVaoKho" data-toggle="modal" data-target="#exampleModal">Thêm sản phẩm</button>
			<button class="btn btn-secondary btn-lg" onclick="CapNhatSanPham()">Cập nhật sản phẩm</button>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Thêm sản phẩn</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<button class="themDong btn btn-primary" onclick="themDong()">
					Thêm dòng
				</button>
				<div style="height: 350px; overflow: auto;">
					<table class="table table-bordered m-2 w-100" id="ThemSanPhanVaoKho_table">
						<thead>
							<tr>
								<th>Tên sản phẩm</th>
								<th>Giá</th>
								<th>Số lượng</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input class="form-control" type="text" name="tenSanPham" placeholder='abc...'></td>
								<td><input class="form-control" type="number" name="gia" min='1000' step="1000" placeholder='> 1000'></td>
								<td><input class="form-control" type="number" name="soLuong" mmin='1' placeholder='> 1'></td>
								<td><button class="btn" onclick="deleteRow(this)"><i class='fas fa-times text-danger'></i></button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-primary" onclick="themNhieuSanPham()">Thêm sản phẩm</button>
			</div>
			</div>
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