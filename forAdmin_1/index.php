<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>QUẢN LÝ SÂN BÓNG</title>
<?php
	include("session.php");
	include("header.php");
?>
<section class="datSan">
        <div class="datePicker" style="margin:0px 0 20px 0;display: flex;">
            <h2 style="margin-right:10px;">Ngày được chọn:</h2>
            <input type="text" class="datsan_ngaydat" style="text-align:center;align-self:center;height:30px;"/><br/>
        </div>

        <div class='time_table_body'>
            <b>TÌNH TRẠNG ĐẶT SÂN NGÀY <span class='tieudetimeIndex'></span></b><br /><br />

            <div class="time_table" style="background-color:white;"></div><br />
        </div>

        <div class='row'>
            <div class='col-4 text-center'>
                <p class="content_datsan border-bottom border-dark mx-3" ><span class='tieudedsIndex'></span></p>	
            </div>
            <div class='col-4 text-center'>
                <p class="content_huysan"></span></p>	
            </div> 
            <div class='col-4 text-center'>
                <p class="content_thanhtoan" ></p>	
            </div>     
        </div>
	
        <br />

        <div class='ds_datsanIndex tabcontent' id='datsan' style="background-color:white;"></div>
       
        
        <div class='ds_datsanDanhSachHuy tabcontent' id='huysan' style="background-color:white;"></div>

        <div class='ds_datsanDanhSachThanhToan tabcontent' id='thanhtoan' style="background-color:white;"></div>
</section>
<br/>
<br/>
<br/>
<div class='border-top border-dark' style="display: flex;flex-direction: row;justify-content:flex-start">
	<img src='../picture/sodosanbong.png' class='py-5' style="width: 750px;height: 350px;"/>
	<div style="margin-left:30px;" class='py-5'>
		<h2 style="padding:0;margin:0;"> Thông tin sân bóng:</h2>
		<div style="margin-left:30px; text-align:center; padding: 5px 0 10px 0;	">
			<p><i>sân A:</i> Sân bóng đá cỏ nhân tạo <b>7</b> người.(40m x 70m)</p>
			<p><i>sân B:</i> Sân bóng đá cỏ nhân tạo <b>7</b> người.(40m x 70m)</p>
			<p><i>sân C:</i> Sân bóng đá cỏ nhân tạo <b>5</b> người.(24m x 40m)</p>
			<p><i>sân D:</i> Sân bóng đá cỏ nhân tạo <b>5</b> người.(24m x 40m)</p>
			<p><i>sân E:</i> Sân bóng đá cỏ nhân tạo <b>7</b> người.(40m x 70m)</p>
			<p><i>sân F:</i> Sân bóng đá cỏ nhân tạo <b>5</b> người.(24m x 40m)</p>
			<p><i>sân G:</i> Sân bóng đá cỏ nhân tạo <b>7</b> người.(40m x 70m)</p>
			<p><i>sân H:</i> Sân bóng đá cỏ nhân tạo <b>5</b> người.(24m x 40m)</p>
			<p><i>sân I:</i> Sân bóng đá cỏ nhân tạo <b>11</b> người.(75m x 110m)</p>
		</div>
		
	</div>
</div>


<style>
body{
	background-color: #d1dcde;
}

.input-note{
	border: 1px solid #515556;
	border-radius: 20px 0 0 20px;
	border-right:none;
	margin:0;
}
.input-note:focus-visible{
	outline: none;
}
.btn-send-note{
	border: 1px solid #515556;
	border-radius: 0 20px 20px 0;
	border-left:none;
	background-color: white;
	
}
.btn-send-note:hover{
	background-color: white;
	color: #7cd2e2;
}

#formDatSan {
	position:absolute;
	margin:auto;
	top:0;
	right:0;
	bottom:0;
	left:0;
	width:1250px;
	height:550px;
	z-index:100;
	background:#eee;
	padding:15px;
	border:0px solid #000;
	box-shadow:5px 5px 20px #000;
	display:none;
	border-radius:10px;
	background-color: #e1f5fe;
}
#formDatSan td{
	vertical-align:center;
	padding-top:5px;
}

#grayscreen{
	width:100%;
	height:500%;
	background:#333;
	opacity:0.7;z-index:99;
	display:none;
	position:absolute;
	left:0;
	top:0;}
#datsan_themkhach{
	display:block;
}
</style>



<section class="formDatSan">
        <div id='grayscreen'></div>
        <div id='formDatSan'>
            <div class="row">
                <div class="col">
                    <b style='font-size: 18px;'>ĐẶT SÂN</b><br />
                    <br />
                    <table>
                        <tr>
                            <td>Sân:</td>
                            <td><span id='datsan_tensan' style='font-weight:bold;color:red;'></span></td>
                        </tr>
                        <tr>
                            <td>Khách hàng:</td>
                            <td><select id='datsan_kh' class='chosen'></select></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" id='chbThemKhach' />Khách hàng mới</td>
                            <td>
                                <div id='datsan_themkhach' class='disabled'>
                                    <table>
                                        <tr>
                                            <td>Tên</td>
                                            <td><input type='text' id='datsan_them_ten' /></td>
                                        </tr>
                                        <tr>
                                            <td>Số điện thoại</td>
                                            <td><input type='text' id='datsan_them_sdt' /></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><button id='datsan_btnthemkh'>Thêm</button></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>CHỌN NGÀY: </b>
                            </td>
                            <td>
                                <span class='ngay_dat'></span><br/>
                            
                        </tr>
                        <tr>
                            <td>Bắt đầu:</td>
                            <td>
                                Giờ: 
                                <select id="datsan_batdau_gio">
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                </select>
                                Phút:
                                <select id="datsan_batdau_phut">
                                    <option value="0">00</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Kết thúc:</td>
                            <td>
                                Giờ: 
                                <select id='datsan_ketthuc_gio'>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                </select>
                                Phút:
                                <select id="datsan_ketthuc_phut">
                                    <option value="0">00</option>
                                    <option value="15" selected>15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Tổng thời gian (phút):</td>
                            <td><span id='datsan_phut'></span></td>
                        </tr>
                        <tr>
                            <td>Đơn giá (/phút):</td>
                            <td><span type='text' id='datsan_dongia' size='5'></span>đ</td>
                        </tr>
                        <tr>
                            <td>Tiền đồ uống:</td>
                            <td><span id='tongtien_douong' style='color:red;font-weight:bold;' onchange='TongTienDat()'>0đ</span></td>
                        </tr>
                        <tr>
                            <td>Tiền đặt sân:</td>
                            <td><span id='datsan_tongtien' style='color:red;font-weight:bold;' onchange='TongTienDat()'>0đ</span></td>
                        </tr>
                        <tr>
                            <td>Tổng tiền:</td>
                            <td><span id='TongTien' style='color:red;font-weight:bold;'>0đ</span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><br />
                                <button class='btn btn-primary' id='datsan_ok'>Đồng ý</button>
                                <button class='btn btn-primary' id='datsan_cancel'>Hủy</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col">
                    <div class="col"  style='height:445px;overflow-y:auto'>
                        <b style='font-size: 18px;'>Đồ uống</b><br />
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" width='30%'>Sản phẩm</th>
                                    <th scope="col" width='20%'>Gía tiền</th>
                                    <th scope="col" width='25%'>Số lượng</th>
                                    <th scope="col" width='25%'>Tồn kho</th>
                                </tr>
                            </thead>
                            <tbody id='menu_do_uong_dat_san'>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <?php
        include("footer.php");
    ?>
	<script>
        $(document).ready(function() {
            
            xemDsDatSanIndex(getToday());
            xemDsDatSanIndex_1(getToday());
            xemDsHuySan(getToday());
            xemDsThanhToan(getToday());
            getSanPham()


            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            document.getElementById("datsan").style.display = "block";

            $('.datsan_ngaydat').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2019,
                maxYear: parseInt(moment().format('YYYY'), 10)
            }, function(start, end, label) {
                xemDsDatSanIndex(start.format("YYYY-MM-DD"));
                xemDsDatSanIndex_1(start.format("YYYY-MM-DD"));
                xemDsHuySan(start.format("YYYY-MM-DD"));
                xemDsThanhToan(start.format("YYYY-MM-DD"));
            });
 
            
            function taoDatSan(ma_kh, ma_san, bat_dau, ket_thuc, don_gia, ten_san, tong_tien, tien_dat_san, tien_do_uong) {
                $.ajax({
                    url: "../api/taodatsan.php",
                    type: "POST",
                    cache: false,
                    data: {
                        ma_kh : ma_kh,
                        ma_san : ma_san,
                        bat_dau : bat_dau,
                        ket_thuc : ket_thuc,
                        don_gia : don_gia,
                        ten_san : ten_san,
                        tong_tien : tong_tien,
                    },
                    success: async function(msg) {
                        if (msg.includes("trùng")) {
                            thongbaoloi("Không thể tạo đặt sân", msg);
                        } else {
                            thongbaotot('Đặt sân thành công');
                        }
                        // console.log(msg);
                        let thoiGianthuc = $('.tieudetimeIndex').text();
                        xemDsDatSanIndex(thoiGianthuc);
                        xemDsDatSanIndex_1(thoiGianthuc);
                        xemDsHuySan(thoiGianthuc);
                        xemDsThanhToan(thoiGianthuc);

                        let arr = await  arrMenuDatSan();
                        // console.log(arr);
                        if (arr.length > 0) {
                            let luuMenuDatSan_await = await luuMenuDatSan(arr,msg,tien_dat_san,tien_do_uong)
                        }

                        getSanPham()
                        document.getElementById('tongtien_douong').innerText = '0'
                    },
                    error: function() {
                        thongbaoloi("Lỗi hệ thống!!");
                    }
                });
            }
            
            $("#datsan_ok").click(function() {
                // insert into database
                let ma_kh = $("#datsan_kh").val();
                let ma_san = $("#datsan_tensan").attr("ma_san");
                let ten_san = $("#datsan_tensan").text();
                let don_gia = parseInt($("#datsan_dongia").text().replace(/,/g, ""));                           
                let tong_tien =parseInt($("#TongTien").text().replace(/,/g, ""));
                let ngay_dat = $(".datsan_ngaydat").text();
                let bat_dau_gio = $("#datsan_batdau_gio").val();
                let bat_dau_phut = $("#datsan_batdau_phut").val();
                let ket_thuc_gio = $("#datsan_ketthuc_gio").val();
                let ket_thuc_phut = $("#datsan_ketthuc_phut").val();
                let bat_dau = ngay_dat + " " + bat_dau_gio + ":" + bat_dau_phut + ":" + "00";
                let ket_thuc = ngay_dat + " " + ket_thuc_gio + ":" + ket_thuc_phut + ":" + "00";

                let tien_dat_san = parseInt($("#datsan_tongtien").text().replace(/,/g, ""));              
                let tien_do_uong = parseInt($("#tongtien_douong").text().replace(/,/g, ""));
                
                let date = new Date();

                let hoursNow = date.getHours();
                let minutesNow = date.getMinutes();
                let checkHours = parseInt(bat_dau_gio) - hoursNow;
                let checkMinutes = parseInt(minutesNow) - parseInt(bat_dau_phut);

                let ngayPresent = date.getDate();
                let thangPresent = date.getMonth();
                let namPresent = date.getFullYear();

                let ngay = $(".datsan_ngaydat").val().split("/");
	            

                let checkNgay = parseInt(ngay[1]) - ngayPresent;
                let checkThang = parseInt(ngay[0]) - 1 - thangPresent;
                let checkNam = parseInt(ngay[2]) - namPresent;

                let checkThoiGianDatGio = parseInt(ket_thuc_gio) - parseInt(bat_dau_gio);
                let checkThoiGianDatPhut = parseInt(ket_thuc_phut) - parseInt(bat_dau_phut);
                
                let objAmKho = laySanPhamAmKho();

                if(objAmKho.length > 0){
                    for (let x of objAmKho) {
                        thongbaoloi(x.name + ' đang bị âm kho')
                    }
                    return
                }

                if (don_gia == "") {
                    $("#datsan_dongia").val("0");
                }
                
                if( checkNgay < 0 && checkThang < 0 && checkNam < 0) {

                    thongbaoloi("Đã quá thời gian đặt sân!!! ");

                } else if ( checkThang > 0 && checkNam >= 0  || checkNam > 0) {

                    if(checkThoiGianDatGio >= 1 && checkThoiGianDatPhut >=0 || checkThoiGianDatGio > 1 ){
                        taoDatSan(ma_kh, ma_san, bat_dau, ket_thuc, don_gia, ten_san, tong_tien, tien_dat_san, tien_do_uong);
                        $("#formDatSan").css("display","none");
                        $("#grayscreen").css("display","none");
                    } else {
                        thongbaoloi("Bạn phải đặt sân nhiều hơn 1 tiếng đồng hồ");
                    }

                } else if (checkNgay >= 1 && checkThang == 0 && checkNam == 0) {

                    if(checkThoiGianDatGio >= 1 && checkThoiGianDatPhut >=0 || checkThoiGianDatGio > 1 ){
                        taoDatSan(ma_kh, ma_san, bat_dau, ket_thuc, don_gia, ten_san, tong_tien, tien_dat_san, tien_do_uong);
                        $("#formDatSan").css("display","none");
                        $("#grayscreen").css("display","none");
                    } else {
                        thongbaoloi("Bạn phải đặt sân nhiều hơn 1 tiếng đồng hồ");
                    }

                } else if (checkNgay == 0 && checkThang == 0 && checkNam == 0 && checkHours < 0 ) {

                    thongbaoloi("Đã quá thời gian đặt sân!!!")

                }else if (checkNgay == 0 && checkThang == 0 && checkNam == 0 && checkHours == 0  && checkMinutes > 30) {

                    thongbaoloi("Đã quá thời gian đặt sân!!!")

                } else if(checkNgay == 0 && checkThang == 0 && checkNam == 0 && checkHours >= 0 || checkNgay == 0 && checkThang == 0 && checkNam == 0 && checkHours == 0 && checkMinutes <= 30) {

                    if(checkThoiGianDatGio >= 1 && checkThoiGianDatPhut >=0 || checkThoiGianDatGio > 1){
                        taoDatSan(ma_kh, ma_san, bat_dau, ket_thuc, don_gia, ten_san, tong_tien, tien_dat_san, tien_do_uong);
                        $("#formDatSan").css("display","none");
                        $("#grayscreen").css("display","none");
                    } else {
                        thongbaoloi("Bạn phải đặt sân nhiều hơn 1 tiếng đồng hồ");
                    }

                }else{
                    thongbaoloi("Thời gian không hợp lệ!!!");
                }


            });
            
            $("#datsan_cancel").click(function() {
                $("#formDatSan").css("display","none");
                $("#grayscreen").css("display","none");
                $("#datsan_them_ten").val("");
                $("#datsan_them_sdt").val("");
                getSanPham()
            });

            $("#datsan_btnthemkh").click(function() {
                let ten = $("#datsan_them_ten").val();
                let sdt = $("#datsan_them_sdt").val();
                if (kiemtraten(ten) && kiemtrasdt(sdt)) {
                    themKhachHang(ten, sdt);
                }
            });
            
            $("#chbThemKhach").change(function() {
                if($(this).is(":checked")) {
                    $("#datsan_themkhach").removeClass("disabled");
                } else {
                    $("#datsan_themkhach").addClass("disabled");
                }
            });
            
            function themKhachHang(ten, sdt) {
                let tk = ten.toLowerCase().replace(/ /g, "");
                $.ajax({
                    url: "../api/dskhachhang.php",
                    type: "POST",
                    cache: false,
                    data: {
                        action: "add",
                        ten : ten,
                        sdt : sdt,
                        tk : tk
                    },
                    success: function(msg) {
                        if (msg.includes("đã tồn tại")) {
                            thongbaoloi(msg);
                        } else {
                            $("#datsan_them_ten").val("");
                            $("#datsan_them_sdt").val("");
                            getDsKhachHang();
                            thongbaotot(msg);
                        }
                    },
                    error: function() {
                        alert("Khong the them khach hang moi!!!");
                    }
                });
            }
        });
    </script>