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
		echo var_dump(($arr[0]));

		for ($x = 0; $x < count($arr[0]); $x++) {
			$sanPham = $arr[0][$x]['id'];
			$so_luong = $arr[0][$x]['so_luong'];

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

?>