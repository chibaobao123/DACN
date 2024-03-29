<!doctype html>
<html lang="en">
  <head>
    <title>Trang chủ cho người dùng</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/common.css" />
    <link rel="stylesheet" type="text/css" href="../libForUser/time_table/TimeTable.css" />
    <link rel="stylesheet" type="text/css" href="../libForUser/date_picker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="../libForUser/toast/jquery.toast.min.css" />
    <link rel="stylesheet" type="text/css" href="../libForUser/chosen/chosen.css" />
    <link rel="shortcut icon" type="image/png" href="favicon.png"/>
    <?php
	    include("../session.php");
    ?>
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

        #grayscreen {
            width:100%;
            height:500%;
            background:#333;
            opacity:0.7;z-index:99;
            display:none;
            position:absolute;
            left:0;
            top:0;
        }
        #datsan_themkhach {
            display:block;
        }
        
    </style>
  </head>
  <body>

    <header>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="./userPage.php">
            <i class="fas fa-home" style="margin-right:10px; font-size:35px;"></i>
            </a>
            <form class="form-inline my-2 my-lg-0">
				<a class='nav-link text-light name_user'  href='taiKhoanUser.php'><i class="fas fa-user" style="margin-right:10px"></i><?php echo $_SESSION['login_user']; ?></a>
				<button class="btn btn-danger p-0"><a class="nav-link text-dark p-1"  href='../logout.php'>Đăng xuất</a></button>
			</form>
        </nav>
    </header>

    <section class="datSan">
        <div class="datePicker" style="margin:45px 0 20px 0;display: flex;">
            <h2 style="margin-right:10px;">Ngày được chọn:</h2>
            <input type="text" class="datsan_ngaydat" style="text-align:center;align-self:center;height:30px;"/><br/>
        </div>

        <div >
            <b>DANH SÁCH ĐẶT SÂN NGÀY <span class='tieudeds'></span></b>	
        </div>
	
        <br />
        <br />

        <div class='ds_datsan' style="background-color:white;"></div>
        <br />
        <br />

        <b>TÌNH TRẠNG ĐẶT SÂN NGÀY <span class='tieudetime'></span></b><br /><br />

        <div class="time_table" style="background-color:white;"></div> <br />
    </section>

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
                            <td><span id='tongtien_douong' style='color:red;font-weight:bold;' onchange="TongTienDat()">0đ</span></td>
                        </tr>
                        <tr>
                            <td>Tiền đặt sân:</td>
                            <td><span id="datsan_tongtien" style="color:red;font-weight:bold;" onchange="TongTienDat()">0đ</span></td>
                        </tr>
                        <tr>
                            <td>Tổng tiền:</td>
                            <td><span id='TongTien' style='color:red;font-weight:bold;'>0đ</span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><br />
                                <button class='btn btn-primary' id='datsan_ok'>Đồng ý</button>
                                <button class='btn btn-primary' id='datsan_test' onclick="TongTienDat()">test</button>
                                <button class='btn btn-primary' id='datsan_cancel'>Hủy</button>
                            </td>
                        </tr>
                    </table>
                </div>
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
    </section>
    
    <?php
        include("footer.php");
    ?>

    <!-- Optional JavaScript -->
    <script src="../libForUser/jquery-3.4.1.js"></script>
    <script src="../libForUser/time_table/createjs.min.js"></script>
    <script src="../libForUser/time_table/TimeTable.js"></script>
    <script src="../libForUser/date_picker/moment.min.js"></script>
    <script src="../libForUser/date_picker/daterangepicker.min.js"></script>
    <script src="../libForUser/toast/jquery.toast.min.js"></script>
    <script src="../libForUser/chosen/chosen.jquery.js"></script>
    <script src="../libForUser/common.js"></script>
    <script src="https://kit.fontawesome.com/93ec6d166b.js" crossorigin="anonymous"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script>
        $(document).ready(function() {
            
            xemDsDatSan(getToday());
            xemDsDatSan_2(getToday());
            getSanPham()

            $('.datsan_ngaydat').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2019,
                maxYear: parseInt(moment().format('YYYY'), 10)
            }, function(start, end, label) {
                xemDsDatSan(start.format("YYYY-MM-DD"));
                xemDsDatSan_2(start.format("YYYY-MM-DD"));
            });
            
            
            function taoDatSan(ma_kh, ma_san, bat_dau, ket_thuc, don_gia, ten_san, tong_tien) {
                $.ajax({
                    url: "/quanlysanbong/api/taoDatSanForUser.php",
                    type: "POST",
                    cache: false,
                    data: {
                        ma_kh : ma_kh,
                        ma_san : ma_san,
                        bat_dau : bat_dau,
                        ket_thuc : ket_thuc,
                        don_gia : don_gia,
                        ten_san: ten_san,
                        tong_tien: tong_tien,
                    },
                    success: function(msg) {
                        if (msg.includes("trùng")) {
                            thongbaoloi("Không thể tạo đặt sân", msg);
                        } else {
                            thongbaotot(msg);
                        }
                        console.log(msg);
                        let thoiGianthuc = $('.tieudeds').text();
                        xemDsDatSan_2(thoiGianthuc);
                        xemDsDatSan(thoiGianthuc);
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
	            

                let checkNgay = ngay[1] - ngayPresent;
                let checkThang = parseInt(ngay[0]) - 1 - thangPresent;
                let checkNam = ngay[2] - namPresent;

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
                            getSanPham()
                            document.getElementById('tongtien_douong').innerText = '0'
                    } else {
                        thongbaoloi("Bạn phải đặt sân nhiều hơn 1 tiếng đồng hồ");
                    }

                } else if (checkNgay >= 1 && checkThang == 0 && checkNam == 0) {

                    if(checkThoiGianDatGio >= 1 && checkThoiGianDatPhut >=0 || checkThoiGianDatGio > 1 ){
                        taoDatSan(ma_kh, ma_san, bat_dau, ket_thuc, don_gia, ten_san, tong_tien, tien_dat_san, tien_do_uong);
                            $("#formDatSan").css("display","none");
                            $("#grayscreen").css("display","none");
                            getSanPham()
                            document.getElementById('tongtien_douong').innerText = '0'
                    } else {
                        thongbaoloi("Bạn phải đặt sân nhiều hơn 1 tiếng đồng hồ");
                    }

                } else if (checkNgay == 0 && checkThang == 0 && checkNam == 0 && checkHours < 2 ) {

                    thongbaoloi("Đã quá thời gian đặt sân!!! Bạn phải đặt sân trước 2 tiếng!!!")

                } else if(checkHours >= 0 || checkHours == 0 && checkMinutes <= 30) {

                    if(checkThoiGianDatGio >= 1 && checkThoiGianDatPhut >=0 || checkThoiGianDatGio > 1 ){
                        taoDatSan(ma_kh, ma_san, bat_dau, ket_thuc, don_gia, ten_san, tong_tien, tien_dat_san, tien_do_uong);
                            $("#formDatSan").css("display","none");
                            $("#grayscreen").css("display","none");
                            getSanPham()
                            document.getElementById('tongtien_douong').innerText = '0'
                    } else {
                        thongbaoloi("Bạn phải đặt sân nhiều hơn 1 tiếng đồng hồ");
                    }

                }else{
                    thongbaoloi("Đã quá thời gian đặt sân!!! ");
                }

             });
            
            $("#datsan_cancel").click(function() {
                $("#formDatSan").css("display","none");
                $("#grayscreen").css("display","none");
                $("#datsan_them_ten").val("");
                $("#datsan_them_sdt").val("");
            });
        });
    </script>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>