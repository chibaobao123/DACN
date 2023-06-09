<!DOCTYPE html>
<html>
	<head>
		<title>jQuery Boilerplate</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="../table2excel/table2excel.js"></script>
		<script src="../table2excel/table2excel.min.js"></script>
	</head>
	<?php
		include("../header.php");
	?>
	<body>
		<!-- <table class="table2excel" data-tableName="Test Table 1">
			<thead>
				<tr class="noExl"><td>This shouldn't get exported</td><td>This shouldn't get exported either</td></tr>
				<tr><td>This Should get exported as a header</td><td>This should too</td></tr>
			</thead>
			<tbody>
				<tr>
					<td style="background-color: blue; color: purple;">data1a with a <a href="#">link one</a> and <a href="#">link two</a> and color won't be exported.</td>
					<td>data1b with a <img src="image_file.jpg" alt="image">.</td></tr>
				<tr>
					<td>data2a with a <input tyle="text" value="text value">.</td>
					<td>data2b with a <input tyle="number">.</td>
				</tr>
			</tbody>
			<tfoot>
				<tr><td colspan="2">This footer spans 2 cells</td></tr>
			</tfoot>
		</table>
		<button class="exportToExcel">Export to XLS</button>

		<table class="table2excel" data-tableName="Test Table 2">
			<thead>
				<tr class="noExl"><td>This shouldn't get exported</td><td>This shouldn't get exported either</td></tr>
				<tr><td>This Should get exported as a header</td><td>This should too</td></tr>
			</thead>
			<tbody>
				<tr><td>data1a</td><td>data1b</td></tr>
				<tr><td>data2a</td><td>data2b</td></tr>
			</tbody>
			<tfoot>
				<tr><td colspan="2">This footer spans 2 cells</td></tr>
			</tfoot>
		</table>
		<button class="exportToExcel">Export to XLS</button>
		
		<table class="table2excel table2excel_with_colors" data-tableName="Test Table 3">
			<thead>
				<tr class="noExl"><td>This shouldn't get exported</td><td>This shouldn't get exported either</td></tr>
				<tr><td style="background-color: green;">This Should get exported as a header and maintain background color</td><td>This should too</td></tr>
			</thead>
			<tbody>
				<tr><td style="background-color: green; color: red;">data1a</td><td>data1b</td></tr>
				<tr><td>data2a</td><td>data2b</td></tr>
			</tbody>
			<tfoot>
				<tr><td colspan="2">This footer spans 2 cells</td></tr>
			</tfoot>
		</table>
		<button class="exportToExcel">Export to XLS</button> --> 

		<div class="row">
			<div class="col">
				<label><b>Mã hóa đơn:</b></label>
				<p>1</p>
				<label><b>Bắt đầu:</b></label>
				<p>1</p>
				<label><b>Đơn giá (/phút):</b></label>
				<p>1</p>
				<label><b>Thanh toán:</b></label>
				<p>1</p>
			</div>
			<div class="col">
				<label><b>Sân:</b></label>
				<p>1</p>
				<label><b>Kết thúc:</b></label>
				<p>1</p>
				<label><b>Tiền đặt sân:</b></label>
				<p>1</p>
				<label><b>Ngày tạo hóa đơn:</b></label>
				<p>1</p>
			</div>
		</div>
		<label><b>Ghi chú:</b></label>
		<textarea class="form-control" type="text"></textarea>

		<script>
			// $(function() {
			// 	$(".exportToExcel").click(function(e){
			// 		var table = $(this).prev('.table2excel');
			// 		if(table && table.length){
			// 			var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
			// 			$(table).table2excel({
			// 				name: "Excel Document Name",
			// 				filename: "myFileName" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
			// 				fileext: ".xls",
			// 				exclude_img: true,
			// 				exclude_links: true,
			// 				exclude_inputs: true,
			// 				preserveColors: preserveColors
			// 			});
			// 		}
			// 	});
				
			// });
		</script>
	</body>
</html>