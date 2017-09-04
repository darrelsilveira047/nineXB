<?php
	defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title><?= $title; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/bootstrap.min.css" />
		<style>
			.centeralign {
				text-align:center !important;
				display: inline-flex !important;
				padding-top: 6px !important;
			}
		</style>
	</head>
	<body>
		<div class='container'>
			<h2 style='text-align: center;'>Employee Details</h2>
			<div class='row'>
				<div class="col-md-8 col-md-offset-2">
					<table class = 'table table-striped'>
						<tr>
							<th>First name</th>
							<th>Last name</th>
							<th>Email Address</th>
							<th>Job Role</th>
							<th>Action</th>
						</tr>
						<?php
							foreach ($employees as $emp) {
								$html = "";
								$html .= "<tr id = 'row".$emp['emp_id']."'><td><span id='spfn" . $emp['emp_id'] . "'>" . $emp['emp_fname'] . "</span></td>";
								$html .= "<td><span id='spln" . $emp['emp_id'] . "'>" . $emp['emp_lname']. "</span></td>";
								$html .= "<td><span id='spem" . $emp['emp_id'] . "'>" . $emp['emp_email'] . "</span></td>";
								$html .= "<td><span id='spjr" . $emp['emp_id'] . "'>" . $emp['emp_job_role'] . "</span></td>";
								$html .= "<td class = 'centeralign'><button class='btn btn-info btn-xs' id='btnedit" . $emp['emp_id'] . "' title = 'Edit' onclick='editEmp(\"". $emp['emp_id'] ."\")'><span class='glyphicon glyphicon-pencil'></span></button>";
								$html .= "&nbsp;<button class='btn btn-danger btn-xs' id='btndel" . $emp['emp_id'] . "' title='Delete' onclick='deleteEmp(\"" . $emp['emp_id'] . "\")'><span class='glyphicon glyphicon-trash'></span></button>";
								$html .= "&nbsp;<button class='btn btn-success btn-xs' style = 'display:none;margin-top: 6px;margin-left: -6px;' id='btnsave" . $emp['emp_id'] . "' title = 'Save' onclick='updateEmp(\"". $emp['emp_id'] ."\")'><span class='glyphicon glyphicon-floppy-saved'></span></button>";
								$html .= "&nbsp;<button class='btn btn-default btn-xs' style = 'display:none;margin-top: 6px;' id = 'btncancel" . $emp['emp_id'] . "' title = 'Cancel' onclick='cancelEmp(\"". $emp['emp_id'] ."\")'><span class='glyphicon glyphicon-remove'></span></button></td></tr>";
								echo $html;
							}
						?>
						<tr id = 'insertrow'>
							<td><input class='form-control' id = 'fname' type="text"  placeholder="Add new..." /></td>
							<td><input class='form-control' id = 'lname' type="text"  placeholder="Add new..." /></td>
							<td><input class='form-control' id = 'email' type="email"  placeholder="Add new..." /></td>
							<td><input class='form-control' id = 'jrole' type="text"  placeholder="Add new..." /></td>
							<td style='text-align:center !important;display: inline-flex !important;padding-top: 14px !important;'>
								<button class='btn btn-warning btn-xs' title = 'Clear' onclick='clearInputs()'><span class='glyphicon glyphicon-remove'></span></button>
							</td>
						</tr>
					</table>
					<button class = 'btn btn-primary' onclick='submit()'>Submit!</button>
				</div>
			</div>
		</div>
		<script type="text/javascript"  src="<?= BASE_URL; ?>js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript"  src="<?= BASE_URL; ?>js/bootstrap.min.js"></script>
		<script>
			function submit() {
				var myusername = $("#username").val();
				var url = '<?= BASE_URL ?>' + 'insert';
				$.ajax({
					type: "POST",
					url: url,
					dataType: "json",
					async : false,
					data: {
						fname: $("#fname").val().trim(),
						lname: $("#lname").val().trim(),
						email: $("#email").val().trim(),
						jobrole: $("#jrole").val().trim(),
					},
					success: function(response) {
						console.log(response);
						if ( ! response.error) {
							var html = "<tr id = 'row" + response.emp_id + "' >";
							html += "<td><span id = 'spfn" + response.emp_id + "'>" + response.emp_fname + "</span></td>";
							html += "<td><span id = 'spln" + response.emp_id + "'>" + response.emp_lname + "</span></td>";
							html += "<td><span id = 'spem" + response.emp_id + "'>" + response.emp_email + "</span></td>";
							html += "<td><span id = 'spjr" + response.emp_id + "'>" + response.emp_job_role + "</span></td>";
							html += "<td class = 'centeralign'><button class='btn btn-info btn-xs' id = 'btnedit" + response.emp_id + "' title = 'Edit' onclick='editEmp(\"" + response.emp_id + "\")'><span class='glyphicon glyphicon-pencil'></span></button>";
							html +=	"&nbsp;<button class='btn btn-danger btn-xs' id = 'btndel" + response.emp_id + "' title='Delete' onclick='deleteEmp(\"" + response.emp_id + "\")'><span class='glyphicon glyphicon-trash'></span></button>";
							html += "&nbsp;<button class='btn btn-success btn-xs' style = 'display:none;margin-top: 6px;margin-left: -6px;' id = 'btnsave" + response.emp_id + "' title = 'Save' onclick='updateEmp(\"" + response.emp_id + "\")'><span class='glyphicon glyphicon-floppy-saved'></span></button>";
							html += "&nbsp;<button class='btn btn-default btn-xs' style = 'display:none;margin-top: 6px;' id = 'btncancel" + response.emp_id + "' title = 'Cancel' onclick='cancelEmp(\"" + response.emp_id + "\")'><span class='glyphicon glyphicon-remove'></span></button></td></tr>";
							$('#insertrow').before(html);
							clearInputs();
						} else {
							alert(response.error);
						}
					},
					error: function(response) {
						console.log(response);
					}
				});
			}

			function deleteEmp(id) {
				var deleteUrl = '<?= BASE_URL ?>' + 'delete';
				$.ajax({
					type: "POST",
					url: deleteUrl,
					dataType: "json",
					async : false,
					data: {
						id : id
					},
					success: function(response) {
						if (response > 0) {
							$('#row' + id).remove();
						} else {
							alert('No rows were deleted');
						}
					},
					error: function(response) {
						console.log(response);
					}
				});
			}

			function editEmp(id) {
				var spfn = '#spfn' + id;
				var spln = '#spln' + id;
				var spem = '#spem' + id;
				var spjr = '#spjr' + id;
				var fntag = "<input class='form-control' id = 'fname" + id + "' type='text' value = '" + $(spfn).text() + "'/>";
				var lntag = "<input class='form-control' id = 'lname" + id + "' type='text' value = '" + $(spln).text() + "'/>";
				var emtag = "<input class='form-control' id = 'email" + id + "' type='text' value = '" + $(spem).text() + "'/>";
				var jrtag = "<input class='form-control' id = 'jrole" + id + "' type='text' value = '" + $(spjr).text() + "'/>";
				$(spfn).hide().before(fntag);
				$(spln).hide().before(lntag);
				$(spem).hide().before(emtag);
				$(spjr).hide().before(jrtag);
				$('#btndel' + id + ', #btnedit' + id).hide();
				$('#btnsave'+ id + ', #btncancel' + id).show();
			}

			function updateEmp(id) {
				updateurl = '<?= BASE_URL ?>' + 'update';
				var fnText = $("#fname" + id).val().trim();
				var lnText = $("#lname" + id).val().trim();
				var emText = $("#email" + id).val().trim();
				var jrText = $("#jrole" + id).val().trim();
				$.ajax({
					type: "POST",
					url: updateurl,
					dataType: "json",
					async : false,
					data: {
						id: id,
						fname: fnText,
						lname: lnText,
						email: emText,
						jobrole: jrText,
					},
					success: function(response) {
						if ( ! response.error){
							$('#spfn' + id).text(fnText).show();
							$('#spln' + id).text(lnText).show();
							$('#spem' + id).text(emText).show();
							$('#spjr' + id).text(jrText).show();
							$("#fname" + id + ", #lname" + id + ", #email" + id + ", #jrole" + id).remove();
							$('#btndel' + id + ', #btnedit' + id).show();
							$('#btnsave' + id + ', #btncancel' + id).hide();
						} else {
							alert(response.error);
						}
						
					},
					error: function(response) {
						console.log(response);
					}
				});
			}

			function cancelEmp(id) {
				$('#spfn' + id).show();
				$('#spln' + id).show();
				$('#spem' + id).show();
				$('#spjr' + id).show();
				$("#fname" + id + ", #lname" + id + ", #email" + id + ", #jrole" + id).remove();
				$('#btndel' + id + ', #btnedit' + id).show();
				$('#btnsave' + id + ', #btncancel' + id).hide();
			}

			function clearInputs() {
				$("#fname, #lname, #email, #jrole ").val('');
			}
		</script>
	</body>
</html>