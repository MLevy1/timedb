<?php
	include("../function/Functions.php");
	formid();
?>
<html>
	<head>
		<title>Activities</title>
		<link rel="stylesheet" href="../../styles.css" />
		<script src="../function/JSFunctions.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script>
		
			function UpdatePView(a)
			{
				$.ajax({
					url: a,
					type: 'GET',
					dataType: 'html'
				})
				.done(function( data ) {
					$('#view').html( data )
				})
				.fail(function() {
					$('#view').prepend('X');
				});
			}
		</script>
	</head>

	<body>
		<h1>Activities</h1>
		<h2>New Activity</h2>
		<hr />
		<form method='post' action='../add/AddAct.php'>
			<table width=100%>
				<tr>
					<td><b>ActID:</td>
					<td>
						<input class='single' type='text' name='inpActID'/>
					</td>
					<td><b>Activity:</td>
					<td colspan="2">
						<input name='inpAct' width="300pts" type='text' size='16.5' />
					</td>
				</tr>
				<tr>
					<td><b>Profile Code:</td>
					<td>
						<input class='single' type='text' name='codesel'/>
					</td>
					<td><b>Use Code:</td>
					<td colspan="2">
						<?php
							addsel2('usesel', 'PUCode', 'PUCodeDesc', 'tblPUCodes');
						?>
				</tr>
				<tr>
					<td><b>Weekly Hrs:</td>
					<td>
						<input type='text' name='inpWklyHrs' class='single'/>
					</td>
					<td><b>Weekly Mins:</td>
					<td>
						<input type='text' name='inpWklyMins' class='single'/>
					</td>
					<td>
						<input type="submit" name="submit" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="form" value="<?php echo $form; ?>">
		</form>
		<hr />
		<table width=100%>
			<tr>
				<td><b>View Activties</td>
				<td>
					<input type="button" class="link" onclick="location.href='../view/ViewAllActDur.php';" value="All Dur" />
				</td>
				<td>
					<a href="javascript:UpdatePView('../view/ViewAct.php?I=y');">Inactive</a>
				</td>
				<td>
					<a href="javascript:UpdatePView('../view/ViewAct.php');">Active</a>
				</td>
			</tr>
		</table>
		<hr />
		<div id="view">
			<?php 
				include ("../view/ViewAct.php"); 
			?>
		</div>
	</body>
</html>