<?php
	include("../session.php");

    if (isset($_GET['action'])) {

        if ($_GET['action']=='getDataKhoHang') {
            $sql = "SELECT * FROM kho_hang";

			$rs = mysqli_query($db, $sql);
			$json_response = array();
			
			while($row = mysqli_fetch_row($rs)) {
				$r['id'] = $row['0'];
				$r['san_pham'] = $row['1'];
				$r['gia_tien'] = $row['2'];
				$r['ton_kho'] = $row['3'];
				array_push($json_response, $r);
			}
			echo json_encode($json_response);
        }
    }

	if (isset($_POST['action']) && $_POST['action']=='suaThongTinKho') {
		$ten = $_POST['ten'];
		$gia = $_POST['gia'];
		$id = $_POST['id'];
		$rs = mysqli_query($db, "UPDATE kho_hang SET san_pham='$ten', gia_tien='$gia' WHERE id='$id'");
		if ($rs) {
			echo "Cập nhật thành công sản phẩm ".$ten;
		}
	}

	if (isset($_POST['action']) && $_POST['action']=='xoaSanPham') {
		$id = $_POST['id'];
		$rs = mysqli_query($db, "DELETE FROM kho_hang WHERE id='$id'");
		if ($rs) {
			echo "Xóa thành công sản phẩm ".$ten;
		}
	}

	if (isset($_POST['action']) && $_POST['action']=='PHIEU_KIEM_KE') {
		$user = $_POST['user'];
		$date = date('Y-m-d H:i:s');
		$rs = mysqli_query($db, "INSERT INTO phieu_kiem_ke(user,ngay_tao) VALUE('$user','$date')");
		if ($rs) {
			$result = mysqli_query($db, "SELECT MAX(id) as ID FROM phieu_kiem_ke");
			while ($row = $result->fetch_assoc()) {
				echo $row['ID'];
			}
		}
	}

	if (isset($_POST['action']) && $_POST['action']=='PHIEU_KIEM_KE_CHI_TIET') {
		$phieu_kiem_ke_id = $_POST['id'];
		$arr = array($_POST['arr']);
		// echo var_dump(count($arr[0]));

		for ($x = 0; $x < count($arr[0]); $x++) {
			// echo var_dump($arr[0][$x]);
			// echo var_dump($arr[0][$x]['id']);
			// echo var_dump($arr[0][$x]['thuc_te']);
			// echo var_dump($arr[0][$x]['ton_kho']);

			$sanPham = $arr[0][$x]['id'];
			$thuc_te = $arr[0][$x]['thuc_te'];
			$ton_kho = $arr[0][$x]['ton_kho'];

			$rs = mysqli_query(
				$db, 
				"INSERT INTO phieu_kiem_ke_chi_tiet(san_pham,so_luong_thuc_te,so_luong_ton_kho,phieu_kiem_ke) 
					VALUE('$sanPham','$thuc_te','$ton_kho',$phieu_kiem_ke_id)"
				);
		}

		echo 'Đã lưu Phiếu kiểm kê';

	}

	if (isset($_GET['action']) && $_GET['action']=='XEM_PHIEU_KIEM_KE') {
		$bat_dau = $_GET['start'];
		$ket_thuc = $_GET['end'];

		$sql = "SELECT * FROM phieu_kiem_ke WHERE ngay_tao BETWEEN '$bat_dau 00:00:00' AND '$ket_thuc 23:59:59'";
	
		$rs = mysqli_query($db, $sql);
		$json_response = array();
		
		while($row = mysqli_fetch_row($rs)) {
			$r['id'] = $row['0'];
			$r['user'] = $row['1'];
			$r['ngay_tao'] = $row['2'];
			array_push($json_response, $r);
		}
		echo json_encode($json_response);
	}

	if (isset($_GET['action']) && $_GET['action']=='XEM_PHIEU_KIEM_KE_CHI_TIET') {
		$id = $_GET['id'];

		$sql = "SELECT * FROM phieu_kiem_ke_chi_tiet where phieu_kiem_ke='$id'";
	
		$rs = mysqli_query($db, $sql);
		$json_response = array();
		
		while($row = mysqli_fetch_row($rs)) {
			$r['id'] = $row['0'];
			$r['san_pham'] = $row['1'];
			$r['so_luong_thuc_te'] = $row['2'];
			$r['so_luong_ton_kho'] = $row['3'];
			array_push($json_response, $r);
		}
		echo json_encode($json_response);
	}

	if (isset($_GET['action']) && $_GET['action']=='SAN_PHAM_ID') {
		$id = $_GET['id'];

		$sql = "SELECT * FROM kho_hang where id='$id'";
	
		$rs = mysqli_query($db, $sql);
		$json_response = array();
		
		while($row = mysqli_fetch_row($rs)) {
			$r['id'] = $row['0'];
			$r['san_pham'] = $row['1'];
			$r['gia_tien'] = $row['2'];
			$r['ton_kho'] = $row['3'];
			array_push($json_response, $r);
		}
		echo json_encode($json_response);
	}

	if (isset($_POST['action']) && $_POST['action']=='TAO_MENU_DO_UONG') {
		$dat_san_id = $_POST['id'];
		$arr = array($_POST['data']);
		$tien_dat_san = $_POST['tien_dat_san'];
		$tien_do_uong = $_POST['tien_do_uong'];
		$date = date('Y-m-d H:i:s');

		$create_hoa_don = mysqli_query(
			$db, 
			"INSERT INTO hoa_don(dat_san,tien_dat_san,tien_do_uong,ngay_tao) 
				VALUE('$dat_san_id','$tien_dat_san','$tien_do_uong','$date')"
		);

		$get_id_hoa_don = mysqli_query(
			$db, 
			"SELECT MAX(id) as id FROM hoa_don"
		);

		$id_hoa_don = mysqli_fetch_assoc($get_id_hoa_don);
		$id = $id_hoa_don['id'];

		// echo var_dump(($arr[0]));

		for ($x = 0; $x < count($arr[0]); $x++) {
			$sanPham = $arr[0][$x]['id'];
			$so_luong = $arr[0][$x]['so_luong'];

			$create_hoa_don_chi_tiet = mysqli_query(
				$db, 
				"INSERT INTO hoa_don_chi_tiet(san_pham,so_luong,hoa_don) 
					VALUE('$sanPham','$so_luong','$id')"
			);

			// echo var_dump($arr[0][$x]);


			$ton_kho = mysqli_query(
					$db, 
					"SELECT ton_kho FROM kho_hang where id='$sanPham'"
				);

			$row = mysqli_fetch_assoc($ton_kho); 
			
			$update_ton_kho = (int)($row['ton_kho']) - (int)($so_luong);
			$ton_kho = (string)$update_ton_kho;

			$update = mysqli_query(
				$db, 
				"UPDATE kho_hang
				SET ton_kho = '$ton_kho'
				WHERE id='$sanPham';"
			);

			$rs = mysqli_query(
				$db, 
				"INSERT INTO phieu_menu_do_uong(san_pham,so_luong,dat_san_id) 
					VALUE('$sanPham','$so_luong',$dat_san_id)"
				);
		}

		echo 'Đã lưu Phiếu đồ ăn';

	}

	if (isset($_GET['action']) && $_GET['action']=='HOA_DON_CHI_TIET') {
		$id = $_GET['id'];

		$sql = " SELECT 
			hd.id as hoa_don_id,
			sb.ten as ten_san,
			hd.tien_dat_san, hd.tien_do_uong, hd.ngay_tao,
			kh.san_pham as ten_sanPham,
			hdct.so_luong,
			khach_hang.ten as ten_khachHang,
			ds.bat_dau, ds.ket_thuc, ds.da_thanh_toan, ds.don_gia, ds.note,
			khach_hang.sdt,
			kh.gia_tien
			
			FROM hoa_don as hd
			LEFT JOIN hoa_don_chi_tiet as hdct
			ON hd.id = hdct.hoa_don
			LEFT JOIN dat_san AS ds
			ON ds.id = hd.dat_san
			LEFT JOIN san_bong AS sb
			ON sb.id = ds.ma_san
			LEFT JOIN kho_hang AS kh
			ON kh.id = hdct.san_pham
			LEFT JOIN khach_hang
			ON khach_hang.id = ds.ma_kh	
			WHERE hd.dat_san = $id;
		";
	
		$rs = mysqli_query($db, $sql);
		$json_response = array();
		
		while($row = mysqli_fetch_row($rs)) {
			$r['hoa_don_id'] = $row['0'];
			$r['ten_san'] = $row['1'];
			$r['tien_dat_san'] = $row['2'];
			$r['tien_do_uong'] = $row['3'];
			$r['ngay_tao'] = $row['4'];
			$r['ten_sanPham'] = $row['5'];
			$r['so_luong'] = $row['6'];
			$r['ten_khachHang'] = $row['7'];
			$r['bat_dau'] = $row['8'];
			$r['ket_thuc'] = $row['9'];
			$r['da_thanh_toan'] = $row['10'];
			$r['don_gia'] = $row['11'];
			$r['note'] = $row['12'];
			$r['sdt'] = $row['13'];
			$r['gia_tien'] = $row['14'];
			array_push($json_response, $r);
		}

		echo json_encode($json_response);
	}

	if (isset($_GET['action']) && $_GET['action']=='HOA_DON_CHI_TIET_KHONG_DO_UONG') {
		$id = $_GET['id'];

		$sql = " SELECT khach_hang.ten as 'ten_kh', khach_hang.sdt, 
			san_bong.ten, 
			dat_san.bat_dau, dat_san.ket_thuc, dat_san.id, dat_san.da_thanh_toan, 
			dat_san.don_gia, dat_san.ma_san, dat_san.note, dat_san.tong_tien 
			FROM dat_san, khach_hang, san_bong 
			WHERE dat_san.ma_kh=khach_hang.id 
			AND dat_san.ma_san=san_bong.id 
			AND dat_san.id = $id 
			ORDER BY san_bong.ten, dat_san.bat_dau
		";
	
		$rs = mysqli_query($db, $sql);
		$json_response = array();
		
		while($row = mysqli_fetch_row($rs)) {
			$r['ten_kh'] = $row['0'];
			$r['sdt'] = $row['1'];
			$r['ten_san'] = $row['2'];
			$r['bat_dau'] = $row['3'];
			$r['ket_thuc'] = $row['4'];
			$r['id'] = $row['5'];
			$r['da_thanh_toan'] = $row['6'];
			$r['don_gia'] = $row['7'];
			$r['ma_san'] = $row['8'];
			$r['note'] = $row['9'];
			$r['tong_tien'] = $row['10'];
			array_push($json_response, $r);
		}

		echo json_encode($json_response);
	}

	if (isset($_POST['action']) && $_POST['action']=='THEM_NHIEU_SAN_PHAM') {
		$ten = $_POST['ten'];
		$gia = $_POST['gia'];
		$so_luong = $_POST['so_luong'];

		$create = mysqli_query(
			$db, 
			"INSERT INTO kho_hang(san_pham,gia_tien,ton_kho) 
				VALUE('$ten','$gia','$so_luong')"
		);

		if($create){
			echo true;
		} else {
			echo var_dump($create);
		}
	}

	if (isset($_POST['action']) && $_POST['action']=='CAP_NHAT_SAN_PHAM') {
		$id = $_POST['id'];
		$so_luong = $_POST['so_luong'];

		$ton_kho = mysqli_query(
			$db, 
			"SELECT ton_kho FROM kho_hang where id='$id'"
		);

		$row = mysqli_fetch_assoc($ton_kho); 
	

		$update_ton_kho = (int)($row['ton_kho']) + (int)($so_luong);

		$update = mysqli_query(
			$db, 
			"UPDATE kho_hang
			SET ton_kho = '$update_ton_kho'
			WHERE id='$id';"
		);

		if($update){
			echo "Cập nhật thành công";
		}
	}

	if (isset($_GET['action']) && $_GET['action']=='CHART_SAN_PHAM') {
		$id = $_GET['id'];

		$so_luong = mysqli_query(
			$db, 
			"SELECT SUM(so_luong) as total FROM hoa_don_chi_tiet where san_pham='$id'"
		);

		$row = mysqli_fetch_assoc($so_luong); 

		if($row['total'] == null){
			echo '0';
		}else{
			echo $row['total'];
		}
	}

?>