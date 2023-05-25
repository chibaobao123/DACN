var g_bat_dau = "";
var g_ket_thuc = "";
const THONG_BAO = "Nhấn Enter để cập nhật, Esc để hủy!!!";
const LOADING_ORDERS = "Đang tải danh sách...";
const LOADING_TIMETBL = "Đang tải bảng...";
const HEADING_LOI_KH = "Tên/Số điện thoại chưa hợp lệ!!! ";
const HEADING_LOI_INPUT = "Lỗi nhập liệu";
const MSG_TEN_SDT = "- Tên phải có ít nhất 7 ký tự chữ cái không dấu.<br />- Số điện thoại phải đủ 10 số.<br/>- Số điện thoại phải bắt đầu bằng số '0'!!!";
const MSG_CHI_NHAP_SO = "Chỉ được nhập số!!!";
const MSG_CHI_NHAP_CHU = "Chỉ được nhập chữ cái không dấu!!!";
const MSG_SDT_0 = "Số điện thoại phải bắt đầu với số '0'.";

function getDsKhachHang() {
	$.ajax({
		url: "/quanlysanbong/api/dskhachhang.php",
		type: "GET",
		cache: false,
		data: {
			action: "view"
		},
		success: function (json) {
			var data = $.parseJSON(json);
			$("#datsan_kh").html("");
			for (var i = 0; i < data.length; i++) {
				$("#datsan_kh").append(new Option(data[i].ten + " (" + data[i].sdt + ")", data[i].id));
			}
			$("#datsan_kh").chosen();
			$("#datsan_kh").trigger('chosen:updated');
		},
		error: function () {
			alert("Khong the lay danh sach khach hang!!!");
		}
	});
}

function veTimeTable(str) {
	var j2 = $.parseJSON(str);
	var data = {};
	var san_ids = [];
	var ten_sans = [];
	var gia = [];

	$.ajax({
		url: "/quanlysanbong/api/sanbong.php",
		type: "POST",
		data: {
			action: "view"
		},
		cache: false,
		success: function (j1) {
			var d = $.parseJSON(j1);
			for (var i = 0; i < d.length; i++) {
				san_ids.push(d[i].ma_san);
				ten_sans.push(d[i].ten_san);
				gia.push(d[i].gia);
				data[i] = {}; // new object
				data[i]["" + d[i].ten_san] = []; // new array
				var obj = {};
				var k = 0;
				var found = false;
				for (j = 0; j < j2.length; j++) {
					if (j2[j].ma_san == d[i].ma_san) {
						var t = extractHourAndMins(j2[j].bat_dau) + "-" + extractHourAndMins(j2[j].ket_thuc);
						obj[k++] = t;
						found = true;
					}
				}
				if (found) {
					data[i]["" + d[i].ten_san].push(obj);
				}
			}

			var obj = {
				// Beginning Time
				startTime: "05:00",
				// Ending Time
				endTime: "21:00",
				// Time to divide(minute)
				divTime: "15",
				// Time Table
				shift: data,
				// Other options
				option: {
					// workTime include time not displaying
					workTime: true,
					bgcolor: ["#00FFFF"],
					useBootstrap: false,
				}
			};

			var instance = new TimeTable(obj);
			$(".time_table").html("");
			instance.init(".time_table");
			caidatnutDatsan(san_ids, ten_sans, gia);
		}
	});
}

function tinhtiendatsan() {

	var dongia = parseInt($("#datsan_dongia").text());
	if (dongia == "0") {
		$("#datsan_tongtien").html("0đ");
		return;
	}
	var giobatdau = $("#datsan_batdau_gio").val();
	var gioketthuc = $("#datsan_ketthuc_gio").val();
	var phutbatdau = $("#datsan_batdau_phut").val();
	var phutketthuc = $("#datsan_ketthuc_phut").val();
	var start = parseFloat(giobatdau) + parseFloat(phutbatdau) / 60;
	var end = parseFloat(gioketthuc) + parseFloat(phutketthuc) / 60;
	var mins = (end - start) * 60;
	var tien = mins * dongia;
	$("#datsan_phut").html(mins);
	$("#datsan_tongtien").html(formatMoney(tien) + "đ");
	TongTienDat()
}

function caidatnutDatsan(san_ids, ten_sans, gia) {
	$(".btnDatSan").each(function (i) {
		$(this).attr("ma_san", san_ids[i]);
		$(this).attr("ten_san", ten_sans[i]);
		$(this).attr("gia", gia[i]);
		$(this).attr("title", "id=" + san_ids[i]);
	});

	$(".btnDatSan").click(function () {
		$("#datsan_tensan").attr("ma_san", $(this).attr("ma_san"));
		$("#datsan_tensan").html($(this).attr("ten_san"));
		$("#datsan_dongia").html($(this).attr("gia"));
		var ngay_dat = getCurrentFormattedDate();
		$(".datsan_ngaydat").html(ngay_dat);
		$(".ngay_dat").html(ngay_dat);
		getDsKhachHang();
		$("#formDatSan").css("display", "block");
		$("#grayscreen").css("display", "block");
		tinhtiendatsan();
	});

	$("#datsan_batdau_gio, #datsan_batdau_phut").change(function () {
		var giobatdau = parseInt($("#datsan_batdau_gio").val());
		var phutbatdau = parseInt($("#datsan_batdau_phut").val());
		var phutketthuc = phutbatdau + 15;

		var gioketthuc = giobatdau;
		if (phutketthuc == 60) {
			gioketthuc++;
			phutketthuc = 0;
		}
		$("#datsan_ketthuc_gio").val(gioketthuc);
		$("#datsan_ketthuc_phut").val(phutketthuc);

		$("#datsan_ketthuc_gio option").each(function (i, e) {
			var gkt = parseInt($(e).val());
			if (gkt < gioketthuc) {
				e.disabled = true;
			} else {
				e.disabled = false;
			}
		});
		tinhtiendatsan();
	});

	$("#datsan_ketthuc_gio").change(function () {
		tinhtiendatsan();
	});

	$("#datsan_ketthuc_phut").change(function () {
		var giobatdau = parseInt($("#datsan_batdau_gio").val());
		var phutbatdau = parseInt($("#datsan_batdau_phut").val());
		var gioketthuc = parseInt($("#datsan_ketthuc_gio").val());
		var phutketthuc = parseInt($("#datsan_ketthuc_phut").val());
		if (giobatdau == gioketthuc) {
			if (phutketthuc <= phutbatdau) {
				phutketthuc = phutbatdau + 15;
				$("#datsan_ketthuc_phut").val(phutketthuc);
			}
		}
		tinhtiendatsan();
	});
}

function resetTables() {
	$(".ds_datsan").html(LOADING_ORDERS);
	$(".time_table").html(LOADING_TIMETBL);
}

function xemDsDatSan(day) {
	//console.log("day=" + day);
	resetTables();
	$.ajax({
		url: "/quanlysanbong/api/xemdatsan.php",
		type: "GET",
		cache: false,
		data: {
			action: "xemdatsan",
			day: day
		},
		success: function (json) {
			console.log(json);
			var data = $.parseJSON(json);
			$(".tieudeds").html(getCurrentFormattedDate());
			$(".tieudetime").html(getCurrentFormattedDate());
			veTableDatSan(data);
			checkInputs();
			veTimeTable(json);
		},
		error: function () {
			alert("Khong the lay du lieu dat san!!!");
		}
	});
}

function xemDsDatSanIndex(day) {
	//console.log("day=" + day);
	resetTables();
	$.ajax({
		url: "/quanlysanbong/api/xemdatsan.php",
		type: "GET",
		cache: false,
		data: {
			action: "xemdatsan_1",
			day: day
		},
		success: function (json) {
			// console.log(json);
			$(".tieudetimeIndex").html(getCurrentFormattedDate());
			checkInputs();
			veTimeTable(json);
		},
		error: function () {
			alert("Khong the lay du lieu dat san!!!");
		}
	});
}

function xemDsDatSanIndex_1(day) {
	//console.log("day=" + day);
	resetTables();
	$.ajax({
		url: "/quanlysanbong/api/xemdatsan.php",
		type: "GET",
		cache: false,
		data: {
			action: "xemdatsan",
			day: day
		},
		success: function (json) {
			// console.log(json);
			var data = $.parseJSON(json);
			$(".tieudedsIndex").html(getCurrentFormattedDate());
			veTableDatSanIndex(data);
			checkInputs();
		},
		error: function () {
			alert("Khong the lay du lieu dat san!!!");
		}
	});
}

function xemDsHuySan(day) {
	//console.log("day=" + day);
	resetTables();
	$.ajax({
		url: "/quanlysanbong/api/xemdatsan.php",
		type: "GET",
		cache: false,
		data: {
			action: "xemhuysan",
			day: day
		},
		success: function (json) {
			// console.log(json);
			var data = $.parseJSON(json);
			veTableDatSanDanhSachHuy(data);
		},
		error: function () {
			alert("Khong the lay du lieu dat san!!!");
		}
	});
}

function xemDsThanhToan(day) {
	//console.log("day=" + day);
	resetTables();
	$.ajax({
		url: "/quanlysanbong/api/xemdatsan.php",
		type: "GET",
		cache: false,
		data: {
			action: "xemthanhtoan",
			day: day
		},
		success: function (json) {
			// console.log(json);
			var data = $.parseJSON(json);
			veTableDatSanDanhSachThanhToan(data);
		},
		error: function () {
			alert("Khong the lay du lieu dat san!!!");
		}
	});
}

function xemDoanhThu(start, end) {
	$.ajax({
		url: "/quanlysanbong/api/xemdatsan.php",
		type: "GET",
		cache: false,
		data: {
			action: "xemdoanhthu",
			start: start,
			end: end
		},
		success: function (json) {
			console.log(json);
			var data = $.parseJSON(json);
			veTableDatSan(data);
		},
		error: function () {
			alert("Khong the xem doanh thu!!!");
		}
	});
}

function veTableDatSanDanhSachThanhToan(data) {
	var html = "";
	html_content = "<div style='background-color: #d1dcde'><b>DANH SÁCH ĐÃ THANH TOÁN <span class='text-success'>(" + data.length + ")</span></b><button class='btn btn-show-thanhtoan'><i class='fas fa-caret-square-down'></i></button><button class='btn btn-hide-thanhtoan d-none'><i class='fas fa-caret-square-up'></i></button></div>"
	html += "<table class='mytable mytable_thanhtoan ' style='width:100%; text-align: center' >";
	html += "<thead><tr><th>#</th><th>Tên KH</th><th>SĐT</th><th>Sân</th><th>Bắt đầu</th><th>Kết thúc</th><th>Phút</th><th>Đơn giá (đồng/phút)</th><th>Tiền</th><th>Thanh toán</th></thead>";
	var tong_tien = 0;
	var da_thanh_toan = 0;
	var chua_thanh_toan = 0;
	for (var i = 0; i < data.length; i++) {
		var thanh_toan = data[i].da_thanh_toan;
		if (thanh_toan == "1") {
			var status = "<img src='images/passed.png' />";
		} else {
			var status = "<img src='images/failed.png' />";
		}
		html += "<tr>";
		html += "<td >" + (i + 1) + "</td>";
		html += "<td class='ten_kh'>" + data[i].ten_kh + "</td>";
		html += "<td class='sdt'>" + data[i].sdt + "</td>";
		html += "<td class='ten_san'>" + data[i].ten_san + "</td>";
		html += "<td class='bat_dau'>" + data[i].bat_dau + "</td>";
		html += "<td class='ket_thuc'>" + data[i].ket_thuc + "</td>";

		var don_gia = data[i].don_gia;
		var start = toDateTime(data[i].bat_dau);
		var end = toDateTime(data[i].ket_thuc);
		var mins = (Math.abs(end - start) / 1000) / 60;
		var money = mins * don_gia;

		if (thanh_toan == "1") {
			da_thanh_toan += money;
		} else {
			chua_thanh_toan += money;
		}
		tong_tien += money;
		html += "<td>" + mins + "</td>";
		html += "<td>" + formatMoney(don_gia) + "</td>";
		if (thanh_toan == "1") {
			html += "<td style='font-weight:bold;color:green;'>" + formatMoney(money) + "</td>";
		} else {
			html += "<td style='font-weight:bold;color:red;'>" + formatMoney(money) + "</td>";
		}
		if (thanh_toan == "0") {
			html += "<td><center><button class='btnThanhToan btn btn-light border border-dark' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-check text-success'></i></button>";
		} else {
			html += "<td><center><button disabled class='btnThanhToan btn btn-light border border-dark' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-check text-success'></i></button>";
		}

		if (thanh_toan == "0") {
			html += "<button class='btnXoaDatSanDanhSachThanhToan btn btn-light border border-dark' bat_dau='" + data[i].bat_dau + "' ket_thuc='" + data[i].ket_thuc + "'sdt='" + data[i].sdt + "' ten_kh='" + data[i].ten_kh + "' ten_san='" + data[i].ten_san + "' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-times text-danger'></i></button></center></td>";
		} else {
			html += "<button class='disabled btnXoaDatSanDanhSachThanhToan btn btn-light border border-dark' bat_dau='" + data[i].bat_dau + "' ket_thuc='" + data[i].ket_thuc + "'sdt='" + data[i].sdt + "' ten_kh='" + data[i].ten_kh + "' ten_san='" + data[i].ten_san + "' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-times text-danger'></i></button></center></td>";

		}
		// html += "<td><center><span><input type='checkbox' class='choose' name='choose' value='choose' bat_dau='" + data[i].bat_dau + "' ket_thuc='" + data[i].ket_thuc + "'sdt='" + data[i].sdt + "' ten_kh='" + data[i].ten_kh + "' ten_san='" + data[i].ten_san + "' datsan_id='" + data[i].datsan_id + "'></span></center></td>";
		html += "</tr>";
	}

	html += "</table>";
	$(".ds_datsanDanhSachThanhToan").html(html);
	$(".content_thanhtoan").html(html_content);

	$('.btn-show-thanhtoan').click(function () {
		$('.content_datsan').removeClass('border-bottom border-dark mx-3');
		$('.content_huysan').removeClass('border-bottom border-dark mx-3');
		$('.content_thanhtoan').addClass('border-bottom border-dark mx-3');

		Dropdown(event, 'thanhtoan')
	})


	// $('.btnAllDelete').click(function () {
	// 	$('.choose').each(function () {
	// 		if ($(this).prop("checked") == true) {
	// 			let ten_kh = $(this).attr("ten_kh");
	// 			let sdt = $(this).attr("sdt");
	// 			let ten_san = $(this).attr("ten_san");
	// 			let bat_dau = $(this).attr("bat_dau");
	// 			let ket_thuc = $(this).attr("ket_thuc");
	// 			let datsan_id = $(this).attr("datsan_id");
	// 			xoaDatSanIndex(datsan_id, ten_kh, sdt, ten_san, bat_dau, ket_thuc);
	// 		}

	// 	})
	// })

	$(".btnXoaDatSanDanhSachThanhToan").click(function () {
		let ten_kh = $(this).attr("ten_kh");
		let sdt = $(this).attr("sdt");
		let ten_san = $(this).attr("ten_san");
		let bat_dau = $(this).attr("bat_dau");
		let ket_thuc = $(this).attr("ket_thuc");
		let datsan_id = $(this).attr("datsan_id");
		xoaDatSanIndex(datsan_id, ten_kh, sdt, ten_san, bat_dau, ket_thuc);


	});
}

function veTableDatSanDanhSachHuy(data) {
	var html = "";
	html_content = "<div style='background-color: #d1dcde'><b>DANH SÁCH ĐANG YÊU CẦU HỦY SÂN <span class='text-danger'>(" + data.length + ")</span></b><button class='btn btn-show-huysan' ><i class='fas fa-caret-square-down'></i></button><button class='btn btn-hide-huysan d-none'><i class='fas fa-caret-square-up'></i></button></div>"
	html += "<table class='mytable mytable_huysan' style='width:100%; text-align: center' >";
	html += "<thead><tr><th>#</th><th>Tên KH</th><th>SĐT</th><th>Sân</th><th>Bắt đầu</th><th>Kết thúc</th><th>Phút</th><th>Đơn giá (đồng/phút)</th><th>Tiền</th><th>Thanh toán</th><th>Yêu cầu hủy đặt sân</th><th><center><button class='btn btn-light border border-dark btnAllDelete'><i class='fas fa-times text-danger'></i></button></center></th></thead>";
	var tong_tien = 0;
	var da_thanh_toan = 0;
	var chua_thanh_toan = 0;
	for (var i = 0; i < data.length; i++) {
		var thanh_toan = data[i].da_thanh_toan;
		if (thanh_toan == "1") {
			var status = "<img src='images/passed.png' />";
		} else {
			var status = "<img src='images/failed.png' />";
		}
		html += "<tr>";
		html += "<td >" + (i + 1) + "</td>";
		html += "<td class='ten_kh'>" + data[i].ten_kh + "</td>";
		html += "<td class='sdt'>" + data[i].sdt + "</td>";
		html += "<td class='ten_san'>" + data[i].ten_san + "</td>";
		html += "<td class='bat_dau'>" + data[i].bat_dau + "</td>";
		html += "<td class='ket_thuc'>" + data[i].ket_thuc + "</td>";

		var don_gia = data[i].don_gia;
		var start = toDateTime(data[i].bat_dau);
		var end = toDateTime(data[i].ket_thuc);
		var mins = (Math.abs(end - start) / 1000) / 60;
		var money = mins * don_gia;

		if (thanh_toan == "1") {
			da_thanh_toan += money;
		} else {
			chua_thanh_toan += money;
		}
		tong_tien += money;
		html += "<td>" + mins + "</td>";
		html += "<td>" + formatMoney(don_gia) + "</td>";
		if (thanh_toan == "1") {
			html += "<td style='font-weight:bold;color:green;'>" + formatMoney(money) + "</td>";
		} else {
			html += "<td style='font-weight:bold;color:red;'>" + formatMoney(money) + "</td>";
		}
		if (thanh_toan == "0") {
			html += "<td><center><button class='btnThanhToan btn btn-light border border-dark' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-check text-success'></i></button>";
		} else {
			html += "<td><center><button disabled class='btnThanhToan btn btn-light border border-dark' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-check text-success'></i></button>";
		}

		html += "<button class='btnXoaDatSanDanhSachHuy btn btn-light border border-dark' bat_dau='" + data[i].bat_dau + "' ket_thuc='" + data[i].ket_thuc + "'sdt='" + data[i].sdt + "' ten_kh='" + data[i].ten_kh + "' ten_san='" + data[i].ten_san + "' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-times text-danger'></i></button></center></td>";
		html += "<td><center><span>" + data[i].note + "</span></center></td>";
		html += "<td><center><span><input type='checkbox' class='choose' name='choose' value='choose' bat_dau='" + data[i].bat_dau + "' ket_thuc='" + data[i].ket_thuc + "'sdt='" + data[i].sdt + "' ten_kh='" + data[i].ten_kh + "' ten_san='" + data[i].ten_san + "' datsan_id='" + data[i].datsan_id + "'></span></center></td>";
		html += "</tr>";
	}

	html += "</table>";
	$(".ds_datsanDanhSachHuy").html(html);
	$(".content_huysan").html(html_content);

	$('.btn-show-huysan').click(function () {
		$('.content_datsan').removeClass('border-bottom border-dark mx-3');
		$('.content_huysan').addClass('border-bottom border-dark mx-3');
		$('.content_thanhtoan').removeClass('border-bottom border-dark mx-3');
		Dropdown(event, 'huysan')
	})


	$('.btnAllDelete').click(function () {
		$('.choose').each(function () {
			if ($(this).prop("checked") == true) {
				let ten_kh = $(this).attr("ten_kh");
				let sdt = $(this).attr("sdt");
				let ten_san = $(this).attr("ten_san");
				let bat_dau = $(this).attr("bat_dau");
				let ket_thuc = $(this).attr("ket_thuc");
				let datsan_id = $(this).attr("datsan_id");
				xoaDatSanIndex(datsan_id, ten_kh, sdt, ten_san, bat_dau, ket_thuc);
			}

		})
	})

	$(".btnXoaDatSanDanhSachHuy").click(function () {
		let ten_kh = $(this).attr("ten_kh");
		let sdt = $(this).attr("sdt");
		let ten_san = $(this).attr("ten_san");
		let bat_dau = $(this).attr("bat_dau");
		let ket_thuc = $(this).attr("ket_thuc");
		let datsan_id = $(this).attr("datsan_id");
		xoaDatSanIndex(datsan_id, ten_kh, sdt, ten_san, bat_dau, ket_thuc);


	});
}

function veTableDatSanIndex(data) {
	var html = "";
	html_content = "<div style='background-color: #d1dcde'><b>DANH SÁCH ĐẶT SÂN <span class='text-info'>(" + data.length + ")</span></b><button class='btn btn-show-index' ><i class='fas fa-caret-square-down'></i></button><button class='btn btn-hide-index d-none'><i class='fas fa-caret-square-up'></i></button></div>";
	html += "<table class='mytable mytable_index' style='width:100%; text-align: center' >";
	html += "<thead><tr><th>#</th><th>Tên KH</th><th>SĐT</th><th>Sân</th><th>Bắt đầu</th><th>Kết thúc</th><th>Phút</th><th>Đơn giá (đồng/phút)</th><th>Tiền</th><th>Thanh toán</th></thead>";
	var tong_tien = 0;
	var da_thanh_toan = 0;
	var chua_thanh_toan = 0;
	for (var i = 0; i < data.length; i++) {
		var thanh_toan = data[i].da_thanh_toan;
		if (thanh_toan == "1") {
			var status = "<img src='images/passed.png' />";
		} else {
			var status = "<img src='images/failed.png' />";
		}
		html += "<tr>";
		html += "<td >" + (i + 1) + "</td>";
		html += "<td class='ten_kh'>" + data[i].ten_kh + "</td>";
		html += "<td class='sdt'>" + data[i].sdt + "</td>";
		html += "<td class='ten_san'>" + data[i].ten_san + "</td>";
		html += "<td class='bat_dau'>" + data[i].bat_dau + "</td>";
		html += "<td class='ket_thuc'>" + data[i].ket_thuc + "</td>";

		var don_gia = data[i].don_gia;
		var start = toDateTime(data[i].bat_dau);
		var end = toDateTime(data[i].ket_thuc);
		var mins = (Math.abs(end - start) / 1000) / 60;
		var money = mins * don_gia;

		if (thanh_toan == "1") {
			da_thanh_toan += money;
		} else {
			chua_thanh_toan += money;
		}
		tong_tien += money;
		html += "<td>" + mins + "</td>";
		html += "<td>" + formatMoney(don_gia) + "</td>";
		if (thanh_toan == "1") {
			html += "<td style='font-weight:bold;color:green;'>" + formatMoney(money) + "</td>";
		} else {
			html += "<td style='font-weight:bold;color:red;'>" + formatMoney(money) + "</td>";
		}
		if (thanh_toan == "0") {
			html += "<td><center><button class='btnThanhToan_index btn btn-light border border-dark' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-check text-success'></i></button>";
		} else {
			html += "<td><center><button disabled class='btnThanhToan_index btn btn-light border border-dark' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-check text-success'></i></button>";
		}

		html += "<button class='btnXoaDatSanDanhSachHuy btn btn-light border border-dark' bat_dau='" + data[i].bat_dau + "' ket_thuc='" + data[i].ket_thuc + "'sdt='" + data[i].sdt + "' ten_kh='" + data[i].ten_kh + "' ten_san='" + data[i].ten_san + "' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-times text-danger'></i></button></center></td>";
		// html += "<td><center><span><input type='checkbox' class='choose' name='choose' value='choose' bat_dau='" + data[i].bat_dau + "' ket_thuc='" + data[i].ket_thuc + "'sdt='" + data[i].sdt + "' ten_kh='" + data[i].ten_kh + "' ten_san='" + data[i].ten_san + "' datsan_id='" + data[i].datsan_id + "'></span></center></td>";
		html += "</tr>";
	}


	html += "</table>";
	$(".ds_datsanIndex").html(html);
	$(".content_datsan").html(html_content);

	$('.btn-show-index').click(function () {
		$('.content_datsan').addClass('border-bottom border-dark mx-3');
		$('.content_huysan').removeClass('border-bottom border-dark mx-3');
		$('.content_thanhtoan').removeClass('border-bottom border-dark mx-3');

		Dropdown(event, 'datsan')
	})


	// $('.btnAllDelete_index').click(function() {
	// 	$('.choose').each(function() {
	// 		var ten_kh = $(this).attr("ten_kh");
	// 			var sdt = $(this).attr("sdt");
	// 			var ten_san = $(this).attr("ten_san");
	// 			var bat_dau = $(this).attr("bat_dau");
	// 			var ket_thuc = $(this).attr("ket_thuc");

	// 			var date = new Date();
	// 			var hoursNow = date.getHours();

	// 			var ngayPresent = date.getDate();
	// 			var thangPresent = date.getMonth();
	// 			var namPresent = date.getFullYear();

	// 			var datsan_id = $(this).attr("datsan_id");
	// 			var bat_dau = $(this).attr("bat_dau");

	// 			var dateBatDau = bat_dau.split(" ");
	// 			var ngayThangNam = dateBatDau[0].split("-");
	// 			var giobatdau = dateBatDau[1].split(":");

	// 			var gio = giobatdau[0];
	// 			var ngay = ngayThangNam[2];
	// 			var thang = ngayThangNam[1];
	// 			var nam = ngayThangNam[0];

	// 			var checkHours = gio - hoursNow;

	// 			var checkNgay = ngay - ngayPresent;
	// 			var checkThang = parseInt(thang) - 1 - thangPresent;
	// 			var checkNam = nam - namPresent;

	// 			console.log(checkHours )


	// 			if( checkNgay < 0 || checkThang < 0 || checkNam < 0) {
	// 				thongbaoloi("Đã quá thời gian hủy đặt sân!!! ");
	// 				$('.btnAllDelete_index').stop();
	// 			} else if (checkHours <= 0 ) {
	// 				thongbaoloi("Đã quá thời gian hủy đặt sân!!!");
	// 				$('.btnAllDelete_index').stop();
	// 			} else if(checkHours < 2) {
	// 				thongbaoloi("Bạn chỉ được hủy đặt sân cách giờ đặt 2 tiếng !!!");
	// 				$('.btnAllDelete_index').stop();
	// 			} else if (checkHours >= 2){
	// 				// if($(this). prop("checked") == true){
	// 				// 	console.log(checkHours )
	// 				// 	xoaDatSanIndex(datsan_id, ten_kh, sdt, ten_san, bat_dau, ket_thuc);
	// 				// }
	// 				console.log("thành công")
	// 			}

	// 	})
	// })

	$(".btnThanhToan_index").click(function () {
		var xac_nhan = confirm("Thanh toán đặt sân?");
		if (xac_nhan) {
			var datsan_id = $(this).attr("datsan_id");
			thanhToanDatSan_index(datsan_id,);
		}
	});

	$(".btnXoaDatSanIndex").click(function () {
		var ten_kh = $(this).attr("ten_kh");
		var sdt = $(this).attr("sdt");
		var ten_san = $(this).attr("ten_san");
		var bat_dau = $(this).attr("bat_dau");
		var ket_thuc = $(this).attr("ket_thuc");

		var date = new Date();
		var hoursNow = date.getHours();

		var ngayPresent = date.getDate();
		var thangPresent = date.getMonth();
		var namPresent = date.getFullYear();

		var datsan_id = $(this).attr("datsan_id");
		var bat_dau = $(this).attr("bat_dau");

		var dateBatDau = bat_dau.split(" ");
		var ngayThangNam = dateBatDau[0].split("-");
		var giobatdau = dateBatDau[1].split(":");

		var gio = giobatdau[0];
		var ngay = ngayThangNam[2];
		var thang = ngayThangNam[1];
		var nam = ngayThangNam[0];

		var checkHours = gio - hoursNow;

		var checkNgay = ngay - ngayPresent;
		var checkThang = parseInt(thang) - 1 - thangPresent;
		var checkNam = nam - namPresent;

		if (checkNgay < 0 || checkThang < 0 || checkNam < 0) {
			thongbaoloi("Đã quá thời gian hủy đặt sân!!! ");
		} else if (checkHours <= 0) {
			thongbaoloi("Đã quá thời gian hủy đặt sân!!!")
		} else if (checkHours <= 2) {
			thongbaoloi("Bạn chỉ được hủy đặt sân cách giờ đặt 2 tiếng !!!");
		} else {
			xoaDatSanIndex(datsan_id, ten_kh, sdt, ten_san, bat_dau, ket_thuc);
		}

	});
}

function veTableDatSan(data) {
	var html = "";
	html += "<table class='mytable' style='width:100%; text-align: center;'>";
	html += "<thead><tr><th>#</th><th>Tên KH</th><th>SĐT</th><th>Sân</th><th>Bắt đầu</th><th>Kết thúc</th><th>Phút</th><th>Tiền</th><th>trạng thái</th><th>Thanh toán</th><th>Yêu cầu hủy đặt sân</th></tr></thead>";
	var tong_tien = 0;
	var da_thanh_toan = 0;
	var chua_thanh_toan = 0;
	for (var i = 0; i < data.length; i++) {
		var thanh_toan = data[i].da_thanh_toan;
		if (thanh_toan == "1") {
			var status = "<img src='../images/passed.png' />";
		} else {
			var status = "<img src='../images/failed.png' />";
		}
		html += "<tr>";
		html += "<td>" + (i + 1) + "</td>";
		html += "<td class='ten_kh'>" + data[i].ten_kh + "</td>";
		html += "<td class='sdt'>" + data[i].sdt + "</td>";
		html += "<td class='ten_san'>" + data[i].ten_san + "</td>";
		html += "<td class='bat_dau'>" + data[i].bat_dau + "</td>";
		html += "<td class='ket_thuc'>" + data[i].ket_thuc + "</td>";

		var don_gia = data[i].don_gia;
		var start = toDateTime(data[i].bat_dau);
		var end = toDateTime(data[i].ket_thuc);
		var mins = (Math.abs(end - start) / 1000) / 60;
		var money = mins * don_gia;

		if (thanh_toan == "1") {
			da_thanh_toan += money;
		} else {
			chua_thanh_toan += money;
		}
		tong_tien += money;
		html += "<td>" + mins + "</td>";

		if (thanh_toan == "1") {
			html += "<td style='font-weight:bold;color:green;'>" + formatMoney(money) + "</td>";
		} else {
			html += "<td style='font-weight:bold;color:red;'>" + formatMoney(money) + "</td>";
		}

		html += "<td>" + status + "</td>";

		if (thanh_toan == "0") {
			html += "<td><center><button class='btnThanhToan_1 btn btn-light border border-dark' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-check text-success'></i></button>";
		} else {
			html += "<td><center><button disabled class='btnThanhToan_1 btn btn-light border border-dark' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-check text-success'></i></button>";
		}

		if (thanh_toan == "0") {
			html += "<button class='btnXoaDatSan  btn btn-light border border-dark' bat_dau='" + data[i].bat_dau + "' ket_thuc='" + data[i].ket_thuc + "'sdt='" + data[i].sdt + "' ten_kh='" + data[i].ten_kh + "' ten_san='" + data[i].ten_san + "' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-times text-danger'></i></button></center></td>";
		} else {
			html += "<button class='disabled btnXoaDatSan  btn btn-light border border-dark' bat_dau='" + data[i].bat_dau + "' ket_thuc='" + data[i].ket_thuc + "'sdt='" + data[i].sdt + "' ten_kh='" + data[i].ten_kh + "' ten_san='" + data[i].ten_san + "' datsan_id='" + data[i].datsan_id + "'><i class='fas fa-times text-danger'></i></button></center></td>";

		}

		html += "<td><center><span>" + data[i].note + "</span></center></td>";
		// html += "<td><center><span><input type='checkbox' class='choose' name='choose' value='choose' bat_dau='" + data[i].bat_dau + "' ket_thuc='" + data[i].ket_thuc + "'sdt='" + data[i].sdt + "' ten_kh='" + data[i].ten_kh + "' ten_san='" + data[i].ten_san + "' datsan_id='" + data[i].datsan_id + "'></span></center></td>";
		html += "</tr>";
	}


	html += "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Đã thanh toán</b></td><td style='font-weight:bold;color:green;'>" + formatMoney(da_thanh_toan) + "</td><td></td><td></td><td></td></tr>";
	html += "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Chưa thanh toán</b></td><td style='font-weight:bold;color:red;'>" + formatMoney(chua_thanh_toan) + "</td><td></td><td></td><td></td></tr>";
	html += "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Tổng tiền</b></td><td style='font-weight:bold;color:blue;'>" + formatMoney(tong_tien) + "</td><td></td><td></td><td></td></tr>";
	html += "</table>";
	$(".ds_datsan").html(html);

	// $('.btnAllDelete').click(function() {
	// 	$('.choose').each(function() {
	// 		var ten_kh = $(this).attr("ten_kh");
	// 			var sdt = $(this).attr("sdt");
	// 			var ten_san = $(this).attr("ten_san");
	// 			var bat_dau = $(this).attr("bat_dau");
	// 			var ket_thuc = $(this).attr("ket_thuc");

	// 			var date = new Date();
	// 			var hoursNow = date.getHours();

	// 			var ngayPresent = date.getDate();
	// 			var thangPresent = date.getMonth();
	// 			var namPresent = date.getFullYear();

	// 			var datsan_id = $(this).attr("datsan_id");
	// 			var bat_dau = $(this).attr("bat_dau");

	// 			var dateBatDau = bat_dau.split(" ");
	// 			var ngayThangNam = dateBatDau[0].split("-");
	// 			var giobatdau = dateBatDau[1].split(":");

	// 			var gio = giobatdau[0];
	// 			var ngay = ngayThangNam[2];
	// 			var thang = ngayThangNam[1];
	// 			var nam = ngayThangNam[0];

	// 			var checkHours = gio - hoursNow;

	// 			var checkNgay = ngay - ngayPresent;
	// 			var checkThang = parseInt(thang) - 1 - thangPresent;
	// 			var checkNam = nam - namPresent;

	// 			console.log(checkHours )


	// 			if( checkNgay < 0 || checkThang < 0 || checkNam < 0) {
	// 				thongbaoloi("Đã quá thời gian hủy đặt sân!!! ");
	// 				stop();
	// 			} else if (checkHours <= 0 ) {
	// 				thongbaoloi("Đã quá thời gian hủy đặt sân!!!");
	// 				stop();
	// 			} else if(checkHours < 2) {
	// 				thongbaoloi("Bạn chỉ được hủy đặt sân cách giờ đặt 2 tiếng !!!");
	// 				stop();
	// 			} else if (checkHours >= 2){
	// 				if($(this). prop("checked") == true){
	// 					console.log(checkHours )
	// 					xoaDatSanIndex(datsan_id, ten_kh, sdt, ten_san, bat_dau, ket_thuc);
	// 				}

	// 			}

	// 	})
	// })


	$(".btnThanhToan_1").click(function () {
		var xac_nhan = confirm("Thanh toán đặt sân?");
		if (xac_nhan) {
			var datsan_id = $(this).attr("datsan_id");
			let g_bat_dau = $('.g_bat_dau').text();
			let g_ket_thuc = $('.g_ket_thuc').text();
			thanhToanDatSan_1(datsan_id, g_bat_dau, g_ket_thuc);
		}
	});

	$(".btnXoaDatSan").click(function () {

		var ten_kh = $(this).attr("ten_kh");
		var sdt = $(this).attr("sdt");
		var ten_san = $(this).attr("ten_san");
		var bat_dau = $(this).attr("bat_dau");
		var ket_thuc = $(this).attr("ket_thuc");

		var date = new Date();
		var hoursNow = date.getHours();

		var ngayPresent = date.getDate();
		var thangPresent = date.getMonth();
		var namPresent = date.getFullYear();

		var datsan_id = $(this).attr("datsan_id");
		var bat_dau = $(this).attr("bat_dau");

		var dateBatDau = bat_dau.split(" ");
		var ngayThangNam = dateBatDau[0].split("-");
		var giobatdau = dateBatDau[1].split(":");

		var gio = giobatdau[0];
		var ngay = ngayThangNam[2];
		var thang = ngayThangNam[1];
		var nam = ngayThangNam[0];

		var checkHours = gio - hoursNow;

		var checkNgay = ngay - ngayPresent;
		var checkThang = parseInt(thang) - 1 - thangPresent;
		var checkNam = nam - namPresent;

		if (checkNgay < 0 || checkThang < 0 || checkNam < 0) {
			thongbaoloi("Đã quá thời gian hủy đặt sân!!! ");
		} else if (checkHours <= 0) {
			thongbaoloi("Đã quá thời gian hủy đặt sân!!!")
		} else if (checkHours <= 2) {
			thongbaoloi("Bạn chỉ được hủy đặt sân cách giờ đặt 2 tiếng !!!");
		} else {
			xoaDatSan($(this).attr("datsan_id"), ten_kh, sdt, ten_san, bat_dau, ket_thuc);
		}


	});
}

function Dropdown(evt, data) {
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


function xoaDatSan(datsan_id, ten_kh, sdt, ten_san, bat_dau, ket_thuc) {
	$.ajax({
		url: "/quanlysanbong/api/xoadatsan.php",
		type: "POST",
		cache: false,
		data: {
			datsan_id: datsan_id,

			ten_kh: ten_kh,
			sdt: sdt,
			ten_san: ten_san,
			bat_dau: bat_dau,
			ket_thuc: ket_thuc,
		},
		success: function (msg) {
			coonsole.log(msg);
			if (g_bat_dau == "" && g_ket_thuc == "") {
				var thoiGianthuc = $('.tieudetimeIndex').text();
				xemDsDatSanIndex(thoiGianthuc);
				xemDsDatSanIndex_1(thoiGianthuc);
				xemDsHuySan(thoiGianthuc);
				xemDsThanhToan(thoiGianthuc);
				thongbaotot(msg);

			} else {
				xemDoanhThu(g_bat_dau, g_ket_thuc);
			}
		},
		error: function () {
			alert("Khong the xoa dat san!!!");
		}
	});
}

function xoaDatSanIndex(datsan_id, ten_kh, sdt, ten_san, bat_dau, ket_thuc) {
	$.ajax({
		url: "/quanlysanbong/api/xoadatsan.php",
		type: "POST",
		cache: false,
		data: {
			datsan_id: datsan_id,

			ten_kh: ten_kh,
			sdt: sdt,
			ten_san: ten_san,
			bat_dau: bat_dau,
			ket_thuc: ket_thuc,
		},
		success: function (msg) {
			if (g_bat_dau == "" && g_ket_thuc == "") {
				var thoiGianthuc = $('.tieudetimeIndex').text();
				xemDsDatSanIndex(thoiGianthuc);
				xemDsDatSanIndex_1(thoiGianthuc);
				xemDsHuySan(thoiGianthuc);
				xemDsThanhToan(thoiGianthuc);
				thongbaotot(msg);
			} else {
				xemDoanhThu(g_bat_dau, g_ket_thuc);
			}
		},
		error: function () {
			alert("Khong the xoa dat san!!!");
		}
	});
}

function thanhToanDatSan(datsan_id) {
	$.ajax({
		url: "/quanlysanbong/api/thanhtoandatsan.php",
		type: "POST",
		cache: false,
		data: {
			datsan_id: datsan_id
		},
		success: function (msg) {
			var thoiGianthuc = $('.tieudetimeIndex').text();
			xemDsDatSanIndex(thoiGianthuc);
			xemDsDatSanIndex_1(thoiGianthuc);
			xemDsHuySan(thoiGianthuc);
			xemDsThanhToan(thoiGianthuc);
		}
	});
}

function thanhToanDatSan_index(datsan_id) {
	$.ajax({
		url: "/quanlysanbong/api/thanhtoandatsan.php",
		type: "POST",
		cache: false,
		data: {
			datsan_id: datsan_id
		},
		success: function (msg) {
			var thoiGianthuc = $('.tieudetimeIndex').text();
			xemDsDatSanIndex(thoiGianthuc);
			xemDsDatSanIndex_1(thoiGianthuc);
			xemDsHuySan(thoiGianthuc);
			xemDsThanhToan(thoiGianthuc);
			console.log(thoiGianthuc);

		}
	});
}

function thanhToanDatSan_1(datsan_id, g_bat_dau, g_ket_thuc) {
	$.ajax({
		url: "/quanlysanbong/api/thanhtoandatsan.php",
		type: "POST",
		cache: false,
		data: {
			datsan_id: datsan_id
		},
		success: function (msg) {

			xemDoanhThu(g_bat_dau, g_ket_thuc);

		}
	});
}

function formatMoney(num) {
	return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

function getCurrentFormattedDate() {
	var ngay = $(".datsan_ngaydat").val().split("/");
	var ngay_dat = ngay[2] + "-" + ngay[0] + "-" + ngay[1];
	return ngay_dat;
}

function getToday() {
	var today = new Date();
	return today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
}

function toDateTime(s) {
	// 2019-05-06 19:00:00
	var r = s.split(" ");

	var t1 = r[0].split("-");
	var year = t1[0];
	var month = t1[1] - 1;
	var day = t1[2];

	var t2 = r[1].split(":");
	var hour = t2[0];
	var minute = t2[1];
	var second = t2[2];

	//console.log(year + "," + month + "," + day + "," + hour + "," + minute + "," + second);
	return new Date(year, month, day, hour, minute, second);
}

function extractHourAndMins(s) {
	// 2019-05-06 19:00:00
	var r = s.split(" ");

	var t = r[1].split(":");
	var hour = t[0];
	var min = t[1];
	return hour + ":" + min;
}

function kiemtraten(ten) {
	if (ten == "" || ten.length < 7) {
		thongbaoloi(HEADING_LOI_KH, MSG_TEN_SDT);
		return false;
	}
	return true;
}

function kiemtrasdt(sdt) {
	if (sdt == "" || sdt.length < 10) {
		thongbaoloi(HEADING_LOI_KH, MSG_TEN_SDT);
		return false;
	}
	return true;
}

function kiemtratensan(ten) {
	if (ten == "") {
		thongbaoloi(HEADING_LOI_INPUT, "Tên sân không được để trống!");
		return false;
	}
	return true;
}

function kiemtraemail(email) {
	if (email == "") {
		thongbaoloi(HEADING_LOI_INPUT, "Email không được để trống!");
		return false;
	}
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
		return (true)
	}
	thongbaoloi("Bạn đã nhập một địa chỉ email không hợp lệ!!!");
	return (false);
}

function kiemtrausername(u) {
	if (u == "") {
		thongbaoloi(HEADING_LOI_INPUT, "Tên tai khoản không được để trống!");
		return false;
	}
	if (/^[a-zA-Z0-9]+$/.test(u)) {
		return true;
	}
	thongbaoloi("Tên tài khoarnkhoong được để trống!!!");
	return false;
}

function kiemtramatkhau(mk) {
	if (mk.trim() == "") {
		thongbaoloi("Mật khẩu không được bỏ trống!!!");
		return false;
	}
	if (mk.trim().length < 6) {
		thongbaoloi("Mật khẩu phải nhiều hơn 6 ký tự!!!");
		return false;
	}

	return true;
}

function thongbao(msg) {
	$.toast({
		heading: 'Thông báo',
		text: msg,
		loader: false,
		icon: 'info'
	});
};

function thongbaotot(msg) {
	$.toast({
		heading: 'Thành công!!!',
		text: msg,
		loader: false,
		icon: 'success'
	});
};

function thongbaoloi(msg) {
	$.toast({
		heading: 'Lỗi',
		text: msg,
		loader: false,
		icon: 'error'
	});
};

function thongbaoloi(heading, msg) {
	$.toast({
		heading: heading,
		text: msg,
		loader: false,
		icon: 'error'
	});
};

function tailaitrang() {
	setTimeout(function () { location.reload(); }, 1000);
}

function checkInputs() {
	$("input[type='text']").keypress(function (e) {
		var key = e.keyCode;
		var id = $(this).attr("id");
		var len = $(this).val().length;

		if (len == 0) {
			if (key == 32) {
				e.preventDefault();
			}
		}
		if (id.includes("ten")) {
			if (len >= 23) {
				e.preventDefault();
			}
			// allow only alphabet characters
			if ((key < 97 || key > 122) && (key < 65 || key > 90) && (key != 32) && (key != 13)) {
				thongbaoloi(HEADING_LOI_INPUT, MSG_CHI_NHAP_CHU);
				e.preventDefault();
			}
		}
		if (id.includes("sdt")) {
			if (len == 0) {
				// the first number must be '0'
				if (key != 48 && key != 13) {
					thongbaoloi(HEADING_LOI_INPUT, MSG_SDT_0);
					e.preventDefault();
				}
			}
			// allow only 10 characters for phone number
			if (len >= 10) {
				e.preventDefault();
			}
			// allow only numbers
			if ((key < 48 || key > 57) && (key != 13)) {
				thongbaoloi(HEADING_LOI_INPUT, MSG_CHI_NHAP_SO);
				e.preventDefault();
			}
		}
		if (id.includes("dongia")) {
			if (len >= 6) {
				e.preventDefault();
			}
			// allow only alphabet characters
			if (key < 48 || key > 57) {
				thongbaoloi(HEADING_LOI_INPUT, MSG_CHI_NHAP_SO);
				e.preventDefault();
			}
		}
	});

	$("input[type='text']").keyup(function (e) {
		var key = e.keyCode;
		var id = $(this).attr("id");
		if (id.includes("dongia")) {
			if ((key >= 48 && key <= 57) || key == 8) {
				tinhtiendatsan();
			}
		}
	});
}

function getDataKhoHangKiemKe() {
	$.ajax({
		url: "/quanlysanbong/api/khoHang.php",
		type: "GET",
		cache: false,
		data: {
			action: "getDataKhoHang",
		},
		success: function (json) {
			let data = $.parseJSON(json);
			// console.log(data)

			let html = "",
				order = 1,
				tongTien = 0,
				tongTonKho = 0;

			html += `<div style='height:500px; overflow-y:  scroll'>
			<table class='mytable text-center' id='thongTinKhoHang' >
			  <thead>
				<tr class="">
				  <th>Mã sản phẩm</th>
				  <th>Tên sản phẩm</th> 
				  <th>Gía tiền</th>
				  <th>Tồn kho</th>
				  <th>Thành tiền</th>
				  <th>Số lượng kiểm kê</th>
				  <th>Chênh lệch</th>
				  <th>Công cụ</th>
				</tr>
			  </thead>
			  <tbody id='sanPhamTonKho'>`;
			data.forEach((e) => {
				let thanhTien = parseInt(e.gia_tien) * parseInt(e.ton_kho);
				tongTien += Number(thanhTien);
				tongTonKho += Number(e.ton_kho);

				html += `
					  <tr>
						<td input='-1'>${e.id}</td>
						<td input='0'>${e.san_pham}</td>
						<td input='-1'>${formatMoney(e.gia_tien)}</td>
						<td input='0'>${e.ton_kho}</td>
						<td input='-1'>${formatMoney(thanhTien)}</td>
						<td input='1'><input class='so_luong_kiem_ke_thuc_te' sanPham=${e.id} kho=${e.ton_kho} type="number" min="0" onchange="countChenhlech(this.value,${e.ton_kho
					},${e.id})"/></td>
						<td input='1'><input value="-${e.ton_kho
					}" id="countChenhlech_${e.id}" disabled/></td>
						<td input='-1'>
						  <button title="Chỉnh sửa" class="btn-edit btn" onclick="chinhSuaThongTinKho(this,${order},${e.id
					})" order='${order}'><i class="fas fa-edit" aria-hidden="true"></i></button>
						  <button title="Xóa" class="btn-del btn" onclick="xoaSanPham(${e.id
					})"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
						</td>
					  </tr>
					`;
				order++;
			});

			html += `
				  </tbody>
				</table>
			  </div>
			  
			  <table class='mytable text-center'>
			  
				<tbody class='border'>
				<tr>
				<td width='439'>Tổng:</td>
				<td width='109'>${formatMoney(tongTonKho)}</td>
				<td width='136'>${formatMoney(tongTien)}</td>
				<td></td>
			  </tr>
				</tbody>
			  </table>
				
				
			  <div class="text-right">
              <a class="btn btn-primary" onclick="xuatFileExcel()">Xuất Excel</a>
				<a class="btn btn-success" onclick="luuPhieuKiemKe()">Lưu bảng kiểm kê</a>
				<a class="btn btn-danger" onclick="getDataKhoHangKiemKe();">Reset dữ liệu</a>
			  </div>
			`;


			$("#kho").html(html);
			$("#total").html('');
			$('#xemPhieuKiemKe').html('')
		},
		error: function () {
			alert("Lỗi lấy dữ liệu !!!");
		},
	});
}

function getDataKhoHang() {
	$.ajax({
		url: "/quanlysanbong/api/khoHang.php",
		type: "GET",
		cache: false,
		data: {
			action: "getDataKhoHang",
		},
		success: function (json) {
			let data = $.parseJSON(json);
			// console.log(data)

			let html = "",
				total = "",
				order = 1,
				tongTien = 0,
				tongTonKho = 0;

			html += `<div style='height:500px; overflow-y:  scroll'>
			<table class='mytable text-center' id='thongTinKhoHang' >
			  <thead>
				<tr class="">
				  <th>Mã sản phẩm</th>
				  <th>Tên sản phẩm</th> 
				  <th>Gía tiền</th>
				  <th>Tồn kho</th>
				  <th>Thành tiền</th>
				  <th>Công cụ</th>
				</tr>
			  </thead>
			  <tbody id='sanPhamTonKho'>`;
			data.forEach((e) => {
				let thanhTien = parseInt(e.gia_tien) * parseInt(e.ton_kho);
				tongTien += Number(thanhTien);
				tongTonKho += Number(e.ton_kho);

				html += `
					  <tr>
						<td >${e.id}</td>
						<td>${e.san_pham}</td>
						<td>${formatMoney(e.gia_tien)}</td>
						<td>${e.ton_kho}</td>
						<td>${formatMoney(thanhTien)}</td>
						<td>
						  <button title="Chỉnh sửa" class="btn-edit btn" onclick="chinhSuaThongTinKho(this,${order},${e.id
					})" order='${order}'><i class="fas fa-edit" aria-hidden="true"></i></button>
						  <button title="Xóa" class="btn-del btn" onclick="xoaSanPham(${e.id
					})"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
						</td>
					  </tr>
					`;
				order++;
			});

			html += `
				  </tbody>
				</table>
			  </div>
			`;
			total = `
		<table class='mytable text-center mr-1'>
		
		  <tbody class='border'>
		  <tr>
		  <td width='735'>Tổng:</td>
		  <td width='180'>${formatMoney(tongTonKho)}</td>
		  <td width='228'>${formatMoney(tongTien)}</td>
		  <td></td>
		</tr>
		  </tbody>
		</table>
		  
		  `;
			$("#kho").html(html);
			$("#total").html(total);
			$('#xemPhieuKiemKe').html('')

		},
		error: function () {
			alert("Lỗi lấy dữ liệu !!!");
		},
	});
}

function countChenhlech(tt, tk, id) {
	if (tt == null || tt == undefined || tt == "") tt = 0;
	let chenhLech = 0 - parseInt(tk) + parseInt(tt);

	$("#countChenhlech_" + id).val(chenhLech);

	if (chenhLech == 0)
		$("#countChenhlech_" + id).css("background-color", "green");

	if (chenhLech > 0)
		$("#countChenhlech_" + id).css({
			"background-color": "yellow",
			color: "black",
		});

	if (chenhLech < 0)
		$("#countChenhlech_" + id).css({
			"background-color": "red",
			color: "white",
		});
}

function chinhSuaThongTinKho(btn, order, id) {
	//  console.log(btn);
	$(btn).attr("disabled", "disabled");
	let row = $("#thongTinKhoHang tr")[order];

	let ten_col = $(row).find("td")[1];
	let ten_value = $(ten_col).text();
	$(ten_col).html(
		`<input style='width:100%' id='ten_${order}' type='text' value='${ten_value}' />`
	);

	let gia_col = $(row).find("td")[2];
	let gia_value = Number($(gia_col).text().replace(/,/g, ""));
	$(gia_col).html(
		`<input style='width:100%' id='gia_${order}' type='text' value='${gia_value}' />`
	);

	$(`#ten_${order}, #gia_${order}`).keyup(function (e) {
		if (e.keyCode == 27) {
			// ESC
			$(ten_col).html(ten_value);
			$(gia_col).html(gia_value);
			$($(".btn-edit")[order - 1]).removeAttr("disabled");
		}
		if (e.keyCode == 13) {
			// ENTER
			var ten_moi = $("#ten_" + order)
				.val()
				.trim();
			var gia_moi = $("#gia_" + order)
				.val()
				.trim();

			suaThongTinKho(ten_moi, gia_moi, id);

			$(ten_col).html(ten_moi);
			$(gia_col).html(gia_moi);
			$($(".btn-edit")[order - 1]).removeAttr("disabled");
		}
	});
}
function suaThongTinKho(ten, gia, id) {
	$.ajax({
		url: "/quanlysanbong/api/khoHang.php",
		type: "POST",
		cache: false,
		data: {
			action: "suaThongTinKho",
			ten,
			gia,
			id,
		},
		success: function (res) {
			// console.log(res);
			thongbaotot(res);
			getDataKhoHang();
		},
		error: function () {
			alert("Lỗi lấy dữ liệu !!!");
		},
	});
}
function xoaSanPham(id) {
	$.ajax({
		url: "/quanlysanbong/api/khoHang.php",
		type: "POST",
		cache: false,
		data: {
			action: "xoaSanPham",
			id,
		},
		success: function (res) {
			// console.log(res);
			thongbaotot(res);
			getDataKhoHang();
		},
		error: function () {
			alert("Lỗi lấy dữ liệu !!!");
		},
	});
}

function luuPhieuKiemKe() {
	let valueArr = []
	let access = true;
	document.querySelectorAll('.so_luong_kiem_ke_thuc_te').forEach(el => {
		let product = {
			id: '',
			thuc_te: '',
			ton_kho: ''
		}

		product.id = el.getAttribute('sanPham');
		product.thuc_te = el.value;
		product.ton_kho = el.getAttribute('kho');

		valueArr.push(product);
	});


	valueArr.forEach(el => {
		if (el === '') access = false; return
	})

	if (access) {
		// console.log(valueArr);
		let user = $('#taikhoan_user').text()
		luuPhieuKiemKeAPI(valueArr, user)
	} else {
		thongbaoloi('Không được để trống số lượng kiểm kho')
		return
	}
}

function luuPhieuKiemKeAPI(arr, user) {
	$.ajax({
		url: "/quanlysanbong/api/khoHang.php",
		type: "POST",
		cache: false,
		data: {
			action: "PHIEU_KIEM_KE",
			user: user
		},
		success: function (res) {
			$.ajax({
				url: "/quanlysanbong/api/khoHang.php",
				type: "POST",
				cache: false,
				data: {
					action: "PHIEU_KIEM_KE_CHI_TIET",
					id: res,
					arr: arr
				},
				success: function (res) {
					// console.log(res);
					thongbaotot(res);
				},
				error: function (err) {
					console.log(err)
					thongbaoloi(err);
				},
			});
		},
		error: function (err) {
			console.log(err)
			thongbaoloi(err);
		},
	});
}

function xuatPhieuKiemKe() {
	let html = `
	  <div class="container">
		  <div class="row">
			  <div class="col">
				  <div class="datePicker" style="margin:5px 0 20px 0;display: flex;">
					  <h2 style="margin-right:10px;">Chọn khoảng thời gian :</h2>
					  <input type="text" id="datepicker_kho" style="text-align:center;align-self:center;height:30px;"/><br/>
				  </div>
			  </div>
		  </div>
	  </div>
	  `;
	$("#kho").html(html);
	$("#total").html('');

	let start = moment().subtract(29, "days");
	let end = moment();

	function cb(start, end) {
		let bat_dau =
			start._d.getFullYear() +
			"-" +
			(parseInt(start._d.getMonth()) + 1) +
			"-" +
			start._d.getDate();

		let ket_thuc =
			end._d.getFullYear() +
			"-" +
			(parseInt(end._d.getMonth()) + 1) +
			"-" +
			end._d.getDate();

		// $("#tieude").html("<b>Doanh thu từ ngày <span class='start'>" + bat_dau + "</span> đến <span class='end'>" + ket_thuc + "</span></b>");

		// console.log(bat_dau, ket_thuc);
		xemPhieuKiemKe(bat_dau, ket_thuc)
	}

	$("#datepicker_kho").daterangepicker(
		{
			startDate: start,
			endDate: end,
			ranges: {
				"Hôm nay": [moment(), moment()],
				"Hôm qua": [moment().subtract(1, "days"), moment().subtract(1, "days")],
				"7 ngày trước": [moment().subtract(6, "days"), moment()],
				"30 ngày trước": [moment().subtract(29, "days"), moment()],
				"Tháng này": [moment().startOf("month"), moment().endOf("month")],
				"Tháng trước": [
					moment().subtract(1, "month").startOf("month"),
					moment().subtract(1, "month").endOf("month"),
				],
			},
		},
		cb
	);

	cb(start, end);
}

function xemPhieuKiemKe(start, end) {
	// console.log(start, end)
	$.ajax({
		url: "/quanlysanbong/api/khoHang.php",
		type: "GET",
		cache: false,
		data: {
			action: "XEM_PHIEU_KIEM_KE",
			start: start,
			end: end,
		},
		success: function (json) {
			// console.log(json);
			var data = $.parseJSON(json);
			// console.log(data);
			veXemPhieuKiemKe(data)
		},
		error: function () {
			alert("Khong the xem doanh thu!!!");
		},
	});
}

function veXemPhieuKiemKe(data) {
	let html = "";
	html += `<div class='container' style='height:500px; overflow-y:  auto'>
			<table class='mytable text-center' id='thongTinKhoHang' >
			  <thead>
				<tr class="">
				  <th>Mã phiếu kiểm</th>
				  <th>Người kiểm</th> 
				  <th>Ngày kiểm</th>
				</tr>
			  </thead>
			  <tbody id='sanPhamTonKho'>`;
	if (data.length == 0) {
		html += `
					  <tr>
						<td colspan='3'>Không tìm thấy phiếu kiểm kê nào</td>
					  </tr>
					`;
	} else {
		data.forEach((e) => {
			html += `
								  <tr onclick='phieuKiemKeChiTiet(${e.id})' data-toggle="modal" data-target="#exampleModalCenter">
									<td >${e.id}</td>
									<td>${e.user}</td>
									<td>${e.ngay_tao}</td>
								  </tr>
								`;
		});
	}

	html += `
		  </tbody>
		</table>
		</div>
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Phiếu kiểm kê</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body" id='phieu_kiem_ke_chi_tiet'>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			  </div>
			</div>
		  </div>
		</div>
		`;
	$('#xemPhieuKiemKe').html(html)
}

function phieuKiemKeChiTiet(id) {
	$.ajax({
		url: "/quanlysanbong/api/khoHang.php",
		type: "GET",
		cache: false,
		data: {
			action: "XEM_PHIEU_KIEM_KE_CHI_TIET",
			id: id
		},
		success: function (json) {
			// console.log(json);
			var data = $.parseJSON(json);
			// console.log(data);
			let html = "",
				order = 1,
				tongTien = 0,
				tongTonKho = 0;

			html += `<div style='height:500px; overflow-y:  scroll'>
			<table class='mytable text-center' id='thongTinKhoHang' >
			  <thead>
				<tr class="">
				  <th>Mã</th>
				  <th>Tên sản phẩm</th> 
				  <th>Số lượng kiểm kê</th>
				  <th>Tồn kho</th>
				  <th>Chênh lệch</th>
				</tr>
			  </thead>
			  <tbody id='sanPhamTonKho'>`;
			data.forEach((e) => {
				getNameProducts(e.san_pham)
				html += `
					  <tr>
						<td>${e.id}</td>
						<td id='san_pham_${e.san_pham}'></td>
						<td>${e.so_luong_thuc_te}</td>
						<td>${e.so_luong_ton_kho}</td>
						<td>${Number(e.so_luong_thuc_te) - Number(e.so_luong_ton_kho)}</td>
					  </tr>
					`;
			})

			html += `
				  </tbody>
				</table>
			  </div>
			`;


			$("#phieu_kiem_ke_chi_tiet").html(html);
		},
		error: function (err) {
			console.log(err)
		},
	});
}


function getNameProducts(id) {
	$.ajax({
		url: "/quanlysanbong/api/khoHang.php",
		type: "GET",
		cache: false,
		data: {
			action: "SAN_PHAM_ID",
			id: id
		},
		success: function (json) {
			var data = JSON.parse(json);
			console.log(data[0].san_pham,)
			$(`#san_pham_${id}`).html(data[0].san_pham)
		},
		error: function (err) {
			console.log(err)
		},
	});
}

function getSanPham() {
	$.ajax({
		url: "/quanlysanbong/api/khoHang.php",
		type: "GET",
		cache: false,
		data: {
			action: "getDataKhoHang",
		},
		success: function (json) {
			var data = JSON.parse(json);
			// console.log(data)
			let html = '';
			data.forEach((item) => {
				html += `
        <tr>
            <td>
              ${item.san_pham}
            </td>
            <td>
              ${formatMoney(item.gia_tien)}
            </td>
            <td><input type="number" class='form-control menu_do_uong_dat_san' gia_tien='${item.gia_tien}' san_pham_id='${item.id}' onchange="countChenhlechSanPhamDatSan(this.value,${item.ton_kho},${item.id})"/></td>
            <td>
              <input class="form-control menu_do_uong_dat_san_ton_kho" name='${item.san_pham}' value="${item.ton_kho}" id="countChenhlechSanPhamDatSan_${item.id}" disabled/>
            </td>
        </tr>
        `
			})
			$('#menu_do_uong_dat_san').html(html)
		},
		error: function (err) {
			console.log(err)
		},
	});
}

function countChenhlechSanPhamDatSan(tt, tk, id) {
	if (tt == null || tt == undefined || tt == "") tt = 0;
	let conLai = parseInt(tk) - parseInt(tt);

	$("#countChenhlechSanPhamDatSan_" + id).val(conLai);

	if (conLai == 0 || conLai > 0)
		$("#countChenhlechSanPhamDatSan_" + id).css("background-color", "green");

	if (conLai < 0)
		$("#countChenhlechSanPhamDatSan_" + id).css({
			"background-color": "red",
			color: "white",
		});
	tinhTienDoAn()
	TongTienDat()
}

function arrMenuDatSan() {
	let valueArr = []
	document.querySelectorAll('.menu_do_uong_dat_san').forEach(el => {
		let product = {
			id: '',
			so_luong: '',
		}

		product.id = el.getAttribute('san_pham_id');
		product.so_luong = el.value;

		valueArr.push(product);
	});

	valueArr = valueArr.filter(e => e.so_luong != '')

	return valueArr
}

function luuMenuDatSan(arr, id) {
	$.ajax({
		url: "/quanlysanbong/api/khoHang.php",
		type: "POST",
		cache: false,
		data: {
			action: "TAO_MENU_DO_UONG",
			id: id,
			data: arr
		},
		success: function (json) {
			console.log(json)
		},
		error: function (err) {
			console.log(err)
		},
	});
}

function tinhTienDoAn() {
	let valueArr = []
	document.querySelectorAll('.menu_do_uong_dat_san').forEach(el => {
		let product = {
			so_luong: '',
			gia_tien: '',
		}

		product.gia_tien = el.getAttribute('gia_tien');
		product.so_luong = el.value;

		valueArr.push(product);
	});

	valueArr = valueArr.filter(e => e.so_luong != '')
	let tong_tien = 0;

	valueArr.forEach(e => {
		tong_tien += e.so_luong * e.gia_tien;
	})
	$('#tongtien_douong').html(formatMoney(tong_tien) + "đ")
}

function TongTienDat() {
	let tien_san = parseInt($("#datsan_tongtien").text().replace(/,/g, ""))
	let tien_do_uong = parseInt($("#tongtien_douong").text().replace(/,/g, ""))
	// console.log(tien_san, tien_do_uong)
	let tien = (tien_san + tien_do_uong) * 1000
	// console.log(tien)
	$('#TongTien').html(formatMoney(tien) + "đ")
}

function laySanPhamAmKho() {
	let valueArr = []
	document.querySelectorAll('.menu_do_uong_dat_san_ton_kho').forEach(el => {
		let obj = {
			name: '',
			value: 0
		}
		if (parseInt(el.value) < 0) {
			obj.name = el.getAttribute('name')
			obj.value = parseInt(el.value)
			valueArr.push(obj);
		}
	});

	return valueArr

}

async function chartDoanhThu() {
	let DoanhThuChart = []
	for (let i = 1; i <= 12; i++) {
		let nam = new Date().getFullYear();
		let bat_dau = nam + '-' + i + '-' + '01'
		let ket_thuc = nam + '-' + i + '-' + '31'
		// console.log(bat_dau, ket_thuc)

		let rs = await xemDoanhThuThang(bat_dau, ket_thuc).then(res => {
			var data = $.parseJSON(res);
			let obj = 0;
			if (data.length > 0) {
				data.forEach(e => {
					obj += parseInt(e.tong_tien)
				})
			}
			DoanhThuChart.push(obj)
		})
	}

	const MONTHS = [
		"tháng 1",
		"tháng 2",
		"tháng 3",
		"tháng 4",
		"tháng 5",
		"tháng 6",
		"tháng 7",
		"tháng 8",
		"tháng 9",
		"tháng 10",
		"tháng 11",
		"tháng 12",
	];

	const dataSource = {
		labels: MONTHS,
		datasets: [
			{
				label: "Doanh thu",
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 159, 64, 0.2)',
					'rgba(255, 205, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(201, 203, 207, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 159, 64, 0.2)',
					'rgba(255, 205, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(54, 162, 235, 0.2)'
				],
				borderColor: [
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)',
					'rgb(75, 192, 192)',
					'rgb(54, 162, 235)',
					'rgb(153, 102, 255)',
					'rgb(201, 203, 207)',
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)',
					'rgb(75, 192, 192)',
					'rgb(54, 162, 235)'
				],
				//   fill: false,
				//   tension: 0.1,
				data: DoanhThuChart,

				borderWidth: 1
			},
		],
	};

	const config = {
		type: "bar",
		data: dataSource,
		options: {},
	};

	const myChart = new Chart(document.getElementById("ChartDoanhThu"), config);
}

function xemDoanhThuThang(start, end) {
	let ajax = $.ajax({
		url: "/quanlysanbong/api/xemdatsan.php",
		type: "GET",
		cache: false,
		data: {
			action: "xemdoanhthu",
			start: start,
			end: end,
		},
	});
	return ajax
}

async function chartDoanhThuSan() {
	let san = []
	let sanObj = []
	let doanhSoSan = []

	let html = `
    <option value="-1">-- Doanh thu tất cả sân --</option>
  `
	let multiSelect = ''

	$('#chart_san_bong').html(`<canvas id='ChartSanBong'></canvas>`)

	let nam = new Date().getFullYear();
	let bat_dau = nam + '-' + '01' + '-' + '01'
	let ket_thuc = nam + '-' + '12' + '-' + '31'

	let getSan = await $.ajax({
		url: "/quanlysanbong/api/sanbong.php",
		type: "POST",
		data: {
			action: "view"
		},
		cache: false,
	}).then(res => {
		let data = $.parseJSON(res);

		data.forEach(e => {
			san.push(e.ten_san);

			let obj = {
				id: '',
				name: '',
			}

			obj.id = e.ma_san;
			obj.name = e.ten_san;
			sanObj.push(obj);
		})
	});

	for (let e of sanObj) {
		let tien = await xemDoanhThuSan(bat_dau, ket_thuc, e.id)
		doanhSoSan.push(tien);
	}

	sanObj.forEach(e => {
		html += `
      <option value="${e.id}">${e.name}</option>
    `
		multiSelect += `
      <button id="multi_select_sanID_${e.id}" class='btn btn-outline-secondary' checked='false' name='${e.name}' onclick=createChartCompare("multi_select_sanID_${e.id}","${e.id}")>${e.name}</button>
    `
	})

	$('#select_san_chart').html(html)
	$('#multi_select_san_chart').html(multiSelect)

	setTimeout(() => {
		const dataSource = {
			labels: san,
			datasets: [
				{
					label: "Doanh thu",
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(255, 159, 64, 0.2)',
						'rgba(255, 205, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(201, 203, 207, 0.2)',
						'rgba(255, 99, 132, 0.2)',
						'rgba(255, 159, 64, 0.2)',
						'rgba(255, 205, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(54, 162, 235, 0.2)'
					],
					borderColor: [
						'rgb(255, 99, 132)',
						'rgb(255, 159, 64)',
						'rgb(255, 205, 86)',
						'rgb(75, 192, 192)',
						'rgb(54, 162, 235)',
						'rgb(153, 102, 255)',
						'rgb(201, 203, 207)',
						'rgb(255, 99, 132)',
						'rgb(255, 159, 64)',
						'rgb(255, 205, 86)',
						'rgb(75, 192, 192)',
						'rgb(54, 162, 235)'
					],
					//   fill: false,
					//   tension: 0.1,
					data: doanhSoSan,

					borderWidth: 1
				},
			],
		};

		const config = {
			type: "bar",
			data: dataSource,
			options: {},
		};

		const myChart = new Chart(document.getElementById("ChartSanBong"), config);
	}, 200);
}

async function xemDoanhThuSan(start, end, san) {
	let tien = 0;

	let a = await $.ajax({
		url: "/quanlysanbong/api/xemdatsan.php",
		type: "GET",
		cache: false,
		data: {
			action: "xemdoanhthutungsan",
			start: start,
			end: end,
			id: san
		},
		success: async function (res) {
			let data = $.parseJSON(res);

			let b = await data.forEach(e => {
				tien += parseInt(e.tong_tien);
			})
		}
	});

	return tien
}

async function chartDoanhThuSanTheoThang(id) {
	if (id == -1) {
		chartDoanhThuSan();
		return;
	}

	$('#chart_san_bong').html(`<canvas id='ChartSanBongTheoThang'></canvas>`)

	let DoanhThuChart = []
	for (let i = 1; i <= 12; i++) {
		let nam = new Date().getFullYear();
		let bat_dau = nam + '-' + i + '-' + '01'
		let ket_thuc = nam + '-' + i + '-' + '31'
		// console.log(bat_dau, ket_thuc)

		let rs = await xemDoanhThuSan(bat_dau, ket_thuc, id);
		DoanhThuChart.push(rs)

	}

	const MONTHS = [
		"tháng 1",
		"tháng 2",
		"tháng 3",
		"tháng 4",
		"tháng 5",
		"tháng 6",
		"tháng 7",
		"tháng 8",
		"tháng 9",
		"tháng 10",
		"tháng 11",
		"tháng 12",
	];

	const dataSource = {
		labels: MONTHS,
		datasets: [
			{
				label: "Doanh thu",
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 159, 64, 0.2)',
					'rgba(255, 205, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(201, 203, 207, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 159, 64, 0.2)',
					'rgba(255, 205, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(54, 162, 235, 0.2)'
				],
				borderColor: [
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)',
					'rgb(75, 192, 192)',
					'rgb(54, 162, 235)',
					'rgb(153, 102, 255)',
					'rgb(201, 203, 207)',
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)',
					'rgb(75, 192, 192)',
					'rgb(54, 162, 235)'
				],
				//   fill: false,
				//   tension: 0.1,
				data: DoanhThuChart,

				borderWidth: 1
			},
		],
	};

	const config = {
		type: "bar",
		data: dataSource,
		options: {},
	};

	const myChart = new Chart(document.getElementById("ChartSanBongTheoThang"), config);
}

async function createChartCompare(tagID, id) {
	let button = document.getElementById(tagID);
	let checked = button.getAttribute('checked')
	let name = button.getAttribute('name')
	let ajax
	let DoanhThuChart = []

	if (checked == "false") {
		button.classList.remove("btn-outline-secondary")
		button.classList.add("btn-primary")
		button.setAttribute('checked', 'true')
		for (let i = 1; i <= 12; i++) {
			let nam = new Date().getFullYear();
			let bat_dau = nam + '-' + i + '-' + '01'
			let ket_thuc = nam + '-' + i + '-' + '31'
			// console.log(bat_dau, ket_thuc)

			ajax = await xemDoanhThuSan(bat_dau, ket_thuc, id);
			DoanhThuChart.push(ajax)
		}


		const MONTHS = [
			"tháng 1",
			"tháng 2",
			"tháng 3",
			"tháng 4",
			"tháng 5",
			"tháng 6",
			"tháng 7",
			"tháng 8",
			"tháng 9",
			"tháng 10",
			"tháng 11",
			"tháng 12",
		];

		const dataSource = {
			labels: MONTHS,
			datasets: [
				{
					label: "Doanh thu",
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(255, 159, 64, 0.2)',
						'rgba(255, 205, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(201, 203, 207, 0.2)',
						'rgba(255, 99, 132, 0.2)',
						'rgba(255, 159, 64, 0.2)',
						'rgba(255, 205, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(54, 162, 235, 0.2)'
					],
					borderColor: [
						'rgb(255, 99, 132)',
						'rgb(255, 159, 64)',
						'rgb(255, 205, 86)',
						'rgb(75, 192, 192)',
						'rgb(54, 162, 235)',
						'rgb(153, 102, 255)',
						'rgb(201, 203, 207)',
						'rgb(255, 99, 132)',
						'rgb(255, 159, 64)',
						'rgb(255, 205, 86)',
						'rgb(75, 192, 192)',
						'rgb(54, 162, 235)'
					],
					data: DoanhThuChart,

					borderWidth: 1
				},
			],
		};

		const config = {
			type: "line",
			data: dataSource,
			options: {
				responsive: true,
				maintainAspectRatio: false,
			}
		};

		let div = document.createElement("div")
		div.id = `div_compare_san_chart_${id}`
		div.style.height = '300px'
		div.style.width = '300px'
		div.style.margin = '10px'
		div.style.display = 'inline-block'

		let h2 = document.createElement("h2")
		h2.innerText = name
		h2.style.display = 'inline'

		let canvas = document.createElement("canvas")
		canvas.id = `compare_san_chart_${id}`
		canvas.style.display = 'inline'
		canvas.style.margin = '20px'
		canvas.style.height = '300px !importance'
		canvas.style.width = '300px !importance'

		div.appendChild(h2);
		div.appendChild(canvas);

		let parent = document.getElementById("compare_san_chart")
		parent.appendChild(div);



		const myChart = new Chart(document.getElementById(`compare_san_chart_${id}`), config);


	} else {
		button.classList.add("btn-outline-secondary")
		button.classList.remove("btn-primary")
		button.setAttribute('checked', 'false')
		document.getElementById(`div_compare_san_chart_${id}`).remove()
	}


	// var divElem = document.createElement("div");
	// elementAttr.setAttribute('class', 'divclass');
	// //if you want to add text inside
	// //var imText = document.createTextNode("Hello Wolrd");
	// // divElem.appendChild(imText);
	// //you need a parent Div to put this inside
	// var parent = document.getElementById("parent");
	// parent.appendChild(divElem);

}
