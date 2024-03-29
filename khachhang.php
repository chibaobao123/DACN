	<title>Khách Hàng</title>
	<script src="https://kit.fontawesome.com/93ec6d166b.js" crossorigin="anonymous"></script>
	<?php
		include("session.php");
		include("header.php");
	?>
	<style>
	body {
		background-color: #d1dcde;	
		
	}
	#formSearch{
		float: right;
	}
	.addCusBar input[type=text] {
		height:25px;
		border: 1px solid #ccc;  
	}
	.chiTiet tr th , .chiTiet tr td{
		font-weight: bold;
		font-size : 13px;
		padding: 5px;
	}
	#tblKhachHang{margin-top:0;}
	#tblKhachHang table{width:50%;}
	#tblKhachHang table td{vertical-align:top;}
	</style>
	<div class="addCusBar" style="margin:0px 0 25px 0;">
		<!-- Tên: <input type='text' id='ten-moi' placeholder="Họ và tên"/> 
		Số điện thoại: <input id='sdt-moi' type='text' placeholder="Số điện thoại "/> 
		: <input id='sdt-moi' type='text' placeholder="Số điện thoại "/> 
		Số điện thoại: <input id='sdt-moi' type='text' placeholder="Số điện thoại "/> 
		<button id='btn-add' class="btn btn-light border border-dark text-center p-0 mb-1" style='height: 25px; width: 70px'>Thêm</button>  -->
		<div class="searchBar" style="float:right">
			<input style=' width:250px; height: 30px;' type="text" placeholder="Tìm kiếm...." name="val_search" value=""/>
			<button id='btn-search' class="btn btn-light border border-dark mb-1"  name='submit' value= 'Tìm kiếm' style='height: 30px; width: 70px'><i class="fas fa-search"></i></button>
		</div>
		
	</div>

	<div id='hold container'>
		<div class='row'>
			<div class='col-6'>
				<h2 class='content_khachhang border-bottom border-dark text-center mx-3'>Danh sách khách hàng <button class='btn btn-show-khachhang' ><i class='fas fa-caret-square-down'></i></button></h2>
				<div style='font-size:12px;'>
					<div class="ml-3 col">
						<p>
							<b>Trạng thái: (x : số lần hủy sân)</b><i class="fas fa-circle text-success pl-4"></i> x < 3 <i class="fas fa-circle text-warning pl-4 "></i> 3 <= x <= 4 <i class="fas fa-circle text-danger pl-4 "></i> x > 4
						</p>
					</div>		
				</div>
			</div>
			<div class="col-6" style='font-size:12px;'>
				<h2 class='text-center content_admin'>Danh sách nhân viên <button class='btn btn-show-admin' ><i class='fas fa-caret-square-down'></i></button></h2>
				<div class="ml-3 col">
					<p>
						<b>Chức vụ:</b><i class="fas fa-circle text-success pl-4"></i> Quản trị <i class="fas fa-circle text-info pl-4 "></i> Nhân viên <i class="fas fa-circle text-dark pl-4 "></i> Khách Hàng
					</p>
				</div>
			</div>
		</div>
		<div id='tblKhachHang' class='tabcontent'></div>
		<div id='tblAdmin' class='tabcontent'></div>
		<div id='tblSearch'></div>
	</div>	

	<?php
			include("footer.php");
		?>
	<script>
		$(document).ready(function() {
			
			taoDsKhachHang();
			taoDsAdmin();

			var i, tabcontent
				tabcontent = document.getElementsByClassName("tabcontent");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}
				document.getElementById("tblKhachHang").style.display = "block";

			function taoDsKhachHang() {
				$.ajax({
					url: "/quanlysanbong/api/dskhachhang.php",
					type: "GET",
					cache: false,
					data: {
						action: "view_khachhang",
					},
					success: function(json) {
						let data = $.parseJSON(json);
						let html = "";
						html += "<table class='mytable' style='width: 100%;text-align: center;background-color:white;'>";
						html += "<thead><tr><th>STT</th><th>Tên khách hàng</th><th>Username</th><th>Số điện thoại</th><th>Email</th><th>Chức vụ</th><th>Trạng thái</th><th>Công cụ</th></tr></thead>";
						for (let i = 0; i < data.length; i++) {
							html += "<tr>";
							html += "<td>"+(i+1)+"</td><td>" + data[i].ten + "</td><td class='username'>" + data[i].username + "</td><td>" + data[i].sdt + "</td><td>" + data[i].email + "</td>";
							
							if(data[i].admin_number == 2 ){
								html += "<td> Quản lý </td>"  ;
							} else if (data[i].admin_number == 1) {
								html += "<td> Nhân viên </td>";
							} else {
								html += "<td> Khách hàng </td>";
							}
							
							var soLanHuySan = data[i].soLanHuySan;
							if(soLanHuySan < 3){
								html += "<td soHuy='"+ soLanHuySan +"'><i class='fas fa-smile text-success'></i></td>";
							} else if (soLanHuySan == 3) {
								html += "<td soHuy='"+ soLanHuySan +"'><i class='fas fa-angry text-warning'></i></td>";
							}else if (soLanHuySan == 4) {	
								html += "<td soHuy='"+ soLanHuySan +"'><i class='fas fa-angry text-warning'></i></td>";
							} else if (soLanHuySan == 5){
								html += "<td soHuy='"+ soLanHuySan +"'><i class='fas fa-angry text-danger'></i></td>";
							}

							html += "<td>";

							if(data[i].admin_number == 2 ){
								html += "<center><button title='Thay đổi quyền đăng nhập' class='btn-change btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "'admin_number='" + data[i].admin_number + "'><i class='fas fa-people-arrows text-success'></i></button>";
							} else if (data[i].admin_number == 1) {
								html += "<center><button title='Thay đổi quyền đăng nhập' class='btn-change btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "'admin_number='" + data[i].admin_number + "'><i class='fas fa-people-arrows text-info'></i></button>";

							} else {
								html += "<center><button title='Thay đổi quyền đăng nhập' class='btn-change btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "'admin_number='" + data[i].admin_number + "'><i class='fas fa-people-arrows'></i></button>";

							}
							
							html += "<button title='Thay đỏi trạng thái' class='btn-changing btn' username='" + data[i].username +"' ><i class='fas fa-exchange-alt'></i></button>";
							html += "<button title='Chỉnh sửa' class='btn-edit btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'><i class='fas fa-edit'></i></button>";
							html += "<button title='Xóa' class='btn-del btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "' ><i class='fas fa-trash-alt'></i></button></center></td>";
							html += "</tr>";
						}
						html += "</table>";
						$("#tblKhachHang").html(html);

						$('.btn-changing').click(function(){
							var u = $(this).attr("username");
							var num = 0;
							$.ajax({
								url:'./api/thayDoiTrangThai.php',
								type: "POST",
								cache: false,
								data: {
									action: "change",
									u : u,
									num : num,
								},
								success: function(msg) {
									if(msg == 'Thành công'){
										thongbaotot(msg);
										taoDsAdmin();
										taoDsKhachHang();
									} else {
										thongbaoloi(msg);
									}
								},
								error: function(result) {
									console.log('ERROR');
									console.log(result);
								}
							})
						})
						$(".btn-del").click(function(){
							var ma_kh = $(this).attr("ma_kh");
							var username = $(this).attr("username");
							console.log(username);
							var xac_nhan = confirm("Bạn có chắc muốn xóa không?");
								if (xac_nhan) {
									xoaKh(ma_kh, username);
								}
						});

						$('.btn-change').click(function(){
							var admin_number = $(this).attr("admin_number");
							var ma_kh = $(this).attr("ma_kh");
							var username = $(this).attr("username");
							var num ;
							var resetNum = 0;
							
							if (admin_number == 1) {
								num = 0;
							} else {
								num = 1; 
							}

							console.log(admin_number, num, username);

							changeAdminNumber(num, ma_kh, username, resetNum);
						})
						

						$(".btn-edit").click(function() {
							$(this).attr("disabled", "disabled");
							var order = $(this).attr("order");
							var ma_kh = $(this).attr("ma_kh");
							var row = $(".mytable tr")[order];
					
							var ten = $(row).find("td")[1];
							var ten_value = $(ten).text();
							$(ten).html("<input style='background:yellow;width:100%' id='ten-" + order + "' type='text' value='" + ten_value + "' /><br /><span class='thongbao'>" + THONG_BAO + "</span>");
							$("#ten-" + order).focus();

							// var username = $(row).find("td")[2];
							// var username_value = $(username).text();
							// $(username).html("<input style='background:yellow;width:100%' id='username-" + order + "' type='text' value='" + username_value + "' />");

							var sdt = $(row).find("td")[3];
							var sdt_value = $(sdt).text();
							$(sdt).html("<input style='background:yellow;width:100%' id='sdt-" + order + "' type='text' value='" + sdt_value + "' />");

							var email = $(row).find("td")[4];
							var email_value = $(email).text();
							$(email).html("<input style='background:yellow;width:100%' id='email-" + order + "' type='text' value='" + email_value + "' />");


							$("#ten-" + order + ", #sdt-" + order + ", #email-" + order).keyup(function(e) {
								if (e.keyCode == 27) {	// ESC
									$(ten).find(".thongbao").remove();
									$(ten).html(ten_value);
									// $(username).html(username_value);
									$(sdt).html(sdt_value);
									$(email).html(email_value);
									$($(".btn-edit")[order - 1]).removeAttr("disabled");
								}
								if (e.keyCode == 13) {	// ENTER
									var ten_moi = $("#ten-" + order).val();
									// var username_moi = $("#username-" + order).val();
									var sdt_moi = $("#sdt-" + order).val();
									var email_moi = $("#email-" + order).val();
									if ((ten_moi != ten_value || sdt_moi != sdt_value || email_moi != email_value) && kiemtraten(ten_moi) && kiemtrasdt(sdt_moi) && kiemtraten(email_moi)) {
										suaKhachHang(ma_kh, ten_moi, sdt_moi, email_moi);
										$(ten).html(ten_moi);
										// $(username).html(username_moi);
										$(sdt).html(sdt_moi);
										$(email).html(email_moi);
										$(ten).find(".thongbao").remove();
										$($(".btn-edit")[order - 1]).removeAttr("disabled");
									}
								}
							});
							
						});
						
					},
					error: function() {
						thongbaoloi("Khong the lay danh sach khach hang!!!");
					}
				});
			}

			function taoDsAdmin() {
				$.ajax({
					url: "./api/dskhachhang.php",
					type: "GET",
					cache: false,
					data: {
						action: "view_admin",
					},
					success: function(json) {
						let data = $.parseJSON(json);
						let html = "";
						html += "<table class='mytable_admin mytable' style='width: 100%;text-align: center;background-color:white;'>";
						html += "<thead><tr><th>STT</th><th>Tên khách hàng</th><th>Username</th><th>Số điện thoại</th><th>Email</th><th>Chức vụ</th><th>Công cụ</th></tr></thead>";
						for (let i = 0; i < data.length; i++) {
							html += "<tr>";
							html += "<td>"+(i+1)+"</td><td>" + data[i].ten + "</td><td class='username'>" + data[i].username + "</td><td>" + data[i].sdt + "</td><td>" + data[i].email + "</td>";
							
							if(data[i].admin_number == 2 ){
								html += "<td class='text-success'> Quản lý </td>"  ;
							} else if (data[i].admin_number == 1) {
								html += "<td class='text-info'> Nhân viên </td>";
							} else {
								html += "<td> Khách hàng </td>";
							}
							
							

							html += "<td>";

							if(data[i].admin_number == 2 ){
								html += "<center><button title='Thay đổi quyền đăng nhập' class='btn-change_admin btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "'admin_number='" + data[i].admin_number + "'><i class='fas fa-people-arrows text-success'></i></button>";
							} else if (data[i].admin_number == 1) {
								html += "<center><button title='Thay đổi quyền đăng nhập' class='btn-change_admin btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "'admin_number='" + data[i].admin_number + "'><i class='fas fa-people-arrows text-info'></i></button>";

							} else {
								html += "<center><button title='Thay đổi quyền đăng nhập' class='btn-change_admin btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "'admin_number='" + data[i].admin_number + "'><i class='fas fa-people-arrows'></i></button>";

							}
							
							html += "<button title='Chỉnh sửa' class='btn-edit_admin btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'><i class='fas fa-edit'></i></button>";
							html += "<button title='Xóa' class='btn-del_admin btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "' ><i class='fas fa-trash-alt'></i></button></center></td>";
							html += "</tr>";
						}
						html += "</table>";
						$("#tblAdmin").html(html);

						$('.btn-changing').click(function(){
							var u = $(this).attr("username");
							var num = 0;
							$.ajax({
								url:'./api/thayDoiTrangThai.php',
								type: "POST",
								cache: false,
								data: {
									action: "change",
									u : u,
									num : num,
								},
								success: function(msg) {
									if(msg == 'Thành công'){
										thongbaotot(msg);
										taoDsAdmin();
										taoDsKhachHang();
									} else {
										thongbaoloi(msg);
									}
								},
								error: function(result) {
									console.log('ERROR');
									console.log(result);
								}
							})
						})
						$(".btn-del_admin").click(function(){
							var ma_kh = $(this).attr("ma_kh");
							var username = $(this).attr("username");
							console.log(username);
							var xac_nhan = confirm("Bạn có chắc muốn xóa không?");
								if (xac_nhan) {
									xoaKh(ma_kh, username);
								}
						});

						$('.btn-change_admin').click(function(){
							var admin_number = $(this).attr("admin_number");
							var ma_kh = $(this).attr("ma_kh");
							var username = $(this).attr("username");
							var num ;
							var resetNum = 0;
							
							if (admin_number == 1) {
								num = 0;
							} else {
								num = 1; 
							}

							console.log(admin_number, num, username);

							changeAdminNumber(num, ma_kh, username, resetNum);
						})
						

						$(".btn-edit_admin").click(function() {
							$(this).attr("disabled", "disabled");
							var order = $(this).attr("order");
							var ma_kh = $(this).attr("ma_kh");
							var row = $(".mytable_admin tr")[order];
					
							var ten = $(row).find("td")[1];
							var ten_value = $(ten).text();
							$(ten).html("<input style='background:yellow;width:100%' id='ten-" + order + "' type='text' value='" + ten_value + "' /><br /><span class='thongbao'>" + THONG_BAO + "</span>");
							$("#ten-" + order).focus();

							// var username = $(row).find("td")[2];
							// var username_value = $(username).text();
							// $(username).html("<input style='background:yellow;width:100%' id='username-" + order + "' type='text' value='" + username_value + "' />");

							var sdt = $(row).find("td")[3];
							var sdt_value = $(sdt).text();
							$(sdt).html("<input style='background:yellow;width:100%' id='sdt-" + order + "' type='text' value='" + sdt_value + "' />");

							var email = $(row).find("td")[4];
							var email_value = $(email).text();
							$(email).html("<input style='background:yellow;width:100%' id='email-" + order + "' type='text' value='" + email_value + "' />");


							$("#ten-" + order + ", #sdt-" + order + ", #email-" + order).keyup(function(e) {
								if (e.keyCode == 27) {	// ESC
									$(ten).find(".thongbao").remove();
									$(ten).html(ten_value);
									// $(username).html(username_value);
									$(sdt).html(sdt_value);
									$(email).html(email_value);
									$($(".btn-edit_admin")[order - 1]).removeAttr("disabled");
								}
								if (e.keyCode == 13) {	// ENTER
									var ten_moi = $("#ten-" + order).val();
									// var username_moi = $("#username-" + order).val();
									var sdt_moi = $("#sdt-" + order).val();
									var email_moi = $("#email-" + order).val();
									if ((ten_moi != ten_value || sdt_moi != sdt_value || email_moi != email_value) && kiemtraten(ten_moi) && kiemtrasdt(sdt_moi) && kiemtraten(email_moi)) {
										suaKhachHang(ma_kh, ten_moi, sdt_moi, email_moi);
										$(ten).html(ten_moi);
										// $(username).html(username_moi);
										$(sdt).html(sdt_moi);
										$(email).html(email_moi);
										$(ten).find(".thongbao").remove();
										$($(".btn-edit_admin")[order - 1]).removeAttr("disabled");
									}
								}
							});
							
						});
						
					},
					error: function() {
						thongbaoloi("Khong the lay danh sach khach hang!!!");
					}
				});
			}
			
			$("#btn-search").on('click', function(){
				var val_search = $('input[name="val_search"]').val();

				$.ajax({
					type:'get',
					url:'./api/search.php?search='+val_search,
					data: {search:val_search},
					dataType: "json",
					success: function(data) {
						// var obj = JSON.parse(response);
						let html = "";
						html += "<table class='mytable mytable_timkiem' style='width: 100%;text-align: center;background-color:white;'>";
						html += "<thead><tr><th>STT</th><th>Tên khách hàng</th><th>Username</th><th>Số điện thoại</th><th>Email</th><th>Chức vụ</th><th>Trạng thái</th><th>Công cụ</th></tr></thead>";
						for (let i = 0; i < data.length; i++) {
							html += "<tr>";
							html += "<td>"+(i+1)+"</td><td>" + data[i].ten + "</td><td class='username'>" + data[i].username + "</td><td>" + data[i].sdt + "</td><td>" + data[i].email + "</td>";
							
							if(data[i].admin_number == 2 ){
								html += "<td> Quản lý </td>"  ;
							} else if (data[i].admin_number == 1) {
								html += "<td> Nhân viên </td>";
							} else {
								html += "<td> Khách hàng </td>";
							}
							
							var soLanHuySan = data[i].soLanHuySan;
							if(soLanHuySan < 3){
								html += "<td soHuy='"+ soLanHuySan +"'><i class='fas fa-smile text-success'></i></td>";
							} else if (soLanHuySan == 3) {
								html += "<td soHuy='"+ soLanHuySan +"'><i class='fas fa-angry text-warning'></i></td>";
							}else if (soLanHuySan == 4) {	
								html += "<td soHuy='"+ soLanHuySan +"'><i class='fas fa-angry text-warning'></i></td>";
							} else if (soLanHuySan == 5){
								html += "<td soHuy='"+ soLanHuySan +"'><i class='fas fa-angry text-danger'></i></td>";
							}

							html += "<td>";

							if(data[i].admin_number == 2 ){
								html += "<center><button title='Thay đổi quyền đăng nhập' class='btn-change_timkiem btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "'admin_number='" + data[i].admin_number + "'><i class='fas fa-people-arrows text-success'></i></button>";
							} else if (data[i].admin_number == 1) {
								html += "<center><button title='Thay đổi quyền đăng nhập' class='btn-change_timkiem btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "'admin_number='" + data[i].admin_number + "'><i class='fas fa-people-arrows text-info'></i></button>";

							} else {
								html += "<center><button title='Thay đổi quyền đăng nhập' class='btn-change_timkiem btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "'admin_number='" + data[i].admin_number + "'><i class='fas fa-people-arrows'></i></button>";

							}
							
							html += "<button title='Thay đỏi trạng thái' class='btn-changing_timkiem btn' username='" + data[i].username +"' ><i class='fas fa-exchange-alt'></i></button>";
							html += "<button title='Chỉnh sửa' class='btn-edit_timkiem btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'><i class='fas fa-edit'></i></button>";
							html += "<button title='Xóa' class='btn-del_timkiem btn' ma_kh='" + data[i].id +"' order='" + (i + 1) + "'username='" + data[i].username + "' ><i class='fas fa-trash-alt'></i></button></center></td>";
							html += "</tr>";
						}
						html += "</table>";
						$("#tblSearch").html(html);

						$('.btn-changing_timkiem').click(function(){
								var u = $(this).attr("username");
								var num = 0;
								$.ajax({
									url:'./api/thayDoiTrangThai.php',
									type: "POST",
									cache: false,
									data: {
										action: "change",
										u : u,
										num : num,
									},
									success: function(msg) {
										if(msg == 'Thành công'){
											thongbaotot(msg);
											taoDsAdmin();
											taoDsKhachHang();
										} else {
											thongbaoloi(msg);
										}
									},
									error: function(result) {
										console.log('ERROR');
										console.log(result);
									}
								})
							})
							$(".btn-del_timkiem").click(function(){
								var ma_kh = $(this).attr("ma_kh");
								var username = $(this).attr("username");
								console.log(username);
								var xac_nhan = confirm("Bạn có chắc muốn xóa không?");
									if (xac_nhan) {
										xoaKh(ma_kh, username);
									}
							});

							$('.btn-change_timkiem').click(function(){
								var admin_number = $(this).attr("admin_number");
								var ma_kh = $(this).attr("ma_kh");
								var username = $(this).attr("username");
								var num ;
								var resetNum = 0;
								
								if (admin_number == 1) {
									num = 0;
								} else {
									num = 1; 
								}

								console.log(admin_number, num, username);

								changeAdminNumber(num, ma_kh, username, resetNum);
							})
						

							$(".btn-edit_timkiem").click(function() {
								console.log("click");
								$(this).attr("disabled", "disabled");
								var order = $(this).attr("order");
								var ma_kh = $(this).attr("ma_kh");
								var row = $(".mytable_timkiem tr")[order];
						
								var ten = $(row).find("td")[1];
								var ten_value = $(ten).text();
								$(ten).html("<input style='background:yellow;width:100%' id='ten-" + order + "' type='text' value='" + ten_value + "' /><br /><span class='thongbao'>" + THONG_BAO + "</span>");
								$("#ten-" + order).focus();

								// var username = $(row).find("td")[2];
								// var username_value = $(username).text();
								// $(username).html("<input style='background:yellow;width:100%' id='username-" + order + "' type='text' value='" + username_value + "' />");

								var sdt = $(row).find("td")[3];
								var sdt_value = $(sdt).text();
								$(sdt).html("<input style='background:yellow;width:100%' id='sdt-" + order + "' type='text' value='" + sdt_value + "' />");

								var email = $(row).find("td")[4];
								var email_value = $(email).text();
								$(email).html("<input style='background:yellow;width:100%' id='email-" + order + "' type='text' value='" + email_value + "' />");


								$("#ten-" + order + ", #sdt-" + order + ", #email-" + order).keyup(function(e) {
									if (e.keyCode == 27) {	// ESC
										$(ten).find(".thongbao").remove();
										$(ten).html(ten_value);
										// $(username).html(username_value);
										$(sdt).html(sdt_value);
										$(email).html(email_value);
										$($(".btn-edit_timkiem")[order - 1]).removeAttr("disabled");
									}
									if (e.keyCode == 13) {	// ENTER
										var ten_moi = $("#ten-" + order).val();
										// var username_moi = $("#username-" + order).val();
										var sdt_moi = $("#sdt-" + order).val();
										var email_moi = $("#email-" + order).val();
										if ((ten_moi != ten_value || sdt_moi != sdt_value || email_moi != email_value) && kiemtraten(ten_moi) && kiemtrasdt(sdt_moi) && kiemtraten(email_moi)) {
											suaKhachHang(ma_kh, ten_moi, sdt_moi, email_moi);
											$(ten).html(ten_moi);
											// $(username).html(username_moi);
											$(sdt).html(sdt_moi);
											$(email).html(email_moi);
											$(ten).find(".thongbao").remove();
											$($(".btn-edit_timkiem")[order - 1]).removeAttr("disabled");
										}
									}
								});
								
							});
						
						$('.btn-show-khachhang').click(function(){
							$('.content_admin').removeClass('border-bottom border-dark mx-3');
							$('.content_khachhang').addClass('border-bottom border-dark mx-3');
							$("#tblSearch").addClass('d-none');
							$("#tblKhachHang").removeClass('d-none');
							Dropdown(event, 'tblKhachHang')
						})

						$('.btn-show-admin').click(function(){
							$('.content_khachhang').removeClass('border-bottom border-dark mx-3');
							$('.content_admin').addClass('border-bottom border-dark mx-3');
							$("#tblSearch").addClass('d-none');
							$("#tblAdmin").removeClass('d-none');
							Dropdown(event, 'tblAdmin')
						})

						
						$("#tblAdmin").addClass('d-none');
						$("#tblKhachHang").addClass('d-none');

					},
					error: function(result) {
						console.log(result);
						

					}
				});
			});

			function Dropdown(evt,data){
				var i, tabcontent, tablinks;
				tabcontent = document.getElementsByClassName("tabcontent");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}
				tablinks = document.getElementsByClassName("tablinks");
				for (i = 0; i < tablinks.length; i++) {
					tablinks[i].className = tablinks[i].className.replace("", "");
				}
				document.getElementById(data).style.display = "block";
				evt.currentTarget.className += " active";
			}

			$('.btn-show-khachhang').click(function(){
				$('.content_admin').removeClass('border-bottom border-dark mx-3');
				$('.content_khachhang').addClass('border-bottom border-dark mx-3');
				Dropdown(event, 'tblKhachHang')
			})

			$('.btn-show-admin').click(function(){
				$('.content_khachhang').removeClass('border-bottom border-dark mx-3');
				$('.content_admin').addClass('border-bottom border-dark mx-3');
				Dropdown(event, 'tblAdmin')
			})
			
			function xoaKh(ma_kh,username){
				$.ajax({
				url: "/quanlysanbong/api/dskhachhang.php",
				type: "POST",
				cache: false,
				data: {
					action: "del",
					ma_kh: ma_kh,
					username : username,
				},
				success: function(msg) {
					thongbaotot(msg);
					taoDsAdmin();
					taoDsKhachHang();
					console.log(msg);
				}
			});
			}

			function suaKhachHang(ma_kh, ten_moi, sdt_moi, email_moi) {
				$.ajax({
					url: "/quanlysanbong/api/dskhachhang.php",
					type: "POST",
					cache: false,
					data: {
						action: "edit",
						ma_kh: ma_kh,
						ten_moi : ten_moi,
						sdt_moi : sdt_moi,
						email_moi : email_moi,
						// username_moi : username_moi,
					},
					success: function(msg) {
						console.log(msg);
						if (msg.includes("đã tồn tại")) {
							thongbaoloi(msg);
							taoDsAdmin();
							taoDsKhachHang();
							console.log(msg);
						} else {
							thongbaotot(msg);
							taoDsAdmin();
							taoDsKhachHang();
							console.log(msg);
						}
					},
					error: function() {
						alert("Khong the cap nhat khach hang " + ma_kh + "!!!");
					}
					
				});
			}

			function changeAdminNumber(num, ma_kh, username,resetNum) {
				$.ajax({
					url: "./api/changeAdminNumber.php",
					type: "POST",
					cache: false,
					data: {
						action: "changeAdminNumber",
						num: num,
						ma_kh : ma_kh,
						username : username,
						resetNum : resetNum,
					},
					success: function(msg) {
						console.log(msg);
						if (msg == "Cập nhật thành công!!!") {
							thongbaotot(msg);
							taoDsKhachHang();
							taoDsAdmin();
						} else {
							thongbaoloi(msg);
							taoDsKhachHang();
							taoDsAdmin();
						}
					},
					error: function() {
						alert("Khong the cap nhat khach hang " + ma_kh + "!!!");
					}
					
				});
			}
			
			
			$("#btn-add").click(function() {
				var ten_moi = $("#ten-moi").val();
				var sdt_moi = $("#sdt-moi").val();
				if (kiemtraten(ten_moi) && kiemtrasdt(sdt_moi)) {
					themKhachHang(ten_moi, sdt_moi);
					$("#ten-moi").val("");
					$("#sdt-moi").val("");
				}
			});
		});
	</script>