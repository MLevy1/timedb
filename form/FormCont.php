<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");

formid();
?>

<html>
<head>
    <title>Sub-Projects</title>
    <link rel="stylesheet" href="../css/MobileStyle.css" />
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
	<h1>Sub-Projects</h1>
	<?php include('../view/LinkTable.php'); ?>
	<form method='post' action='../add/AddCont.php'>
	<table>
		<tr>
			<td><b>ContID:</td>
			<td><input type='text' name='inpContID'></input></td>
		</tr><tr>
			<td><b>Cont. Desc:</td>
			<td><input type='text' name='inpCont'></input></td>
		</tr><tr>
			<td><b>Project</td>
			<td>
<?php
addsel2('projsel', 'ProjID', 'ProjDesc', 'tblProj');
?>
		</tr><tr><td></td>
			<td>	<input type="submit" name="submit" /></td></tr>
	</table>
	</form>
	<hr />
	<table>
	<tr><td>
		<b>View Sub-Projects
	</td><td>
		<a href="javascript:UpdatePView('../view/ViewCont.php?I=y');">Inactive</a>
	</td><td>
	<a href="javascript:UpdatePView('../view/ViewCont.php');">Active</a>
	</td></tr>
	</table>
<hr />

<div id="view">
	<?php include("../view/ViewCont.php"); ?>
</div>
</body>
</html>
