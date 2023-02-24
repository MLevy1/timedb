<?php
include("../function/Functions.php");
?>
<html>
<head>
    <title>Projects</title>
    <link rel="stylesheet" href="../../styles.css" />
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
	<h1>Projects</h1>
	<?php include('../view/LinkTable.php'); ?>
	<form method='post' action='../add/AddProj.php'>
	<h2>New Project</h2>
	<hr />
	<table width=100%>
		<tr>
			<td><b>ProjID</td>
			<td><input type='text' name='inpProjID' size='5'></input></td>
			<td><b>Project Desc</td>
			<td><input size='20' type='text' name='inpProj'></input></td>
			</tr><tr>
			<td><b>Profile Code</td>
			<td colspan='2'>
<?php
addsel2('codesel', 'PUCode', 'PUCodeDesc', 'tblPUCodes');
?>
			</td><td><input type="submit" name="submit" /></td></tr>
	</table>
	</form>
	<hr />
	<table width=100%>
	<tr><td>
		<b>View Projects
	</td><td>
		<a href="javascript:UpdatePView('../view/ViewProj.php?I=y');">Inactive</a>
	</td><td>
	<a href="javascript:UpdatePView('../view/ViewProj.php');">Active</a>
	</td></tr>
	</table>
<hr />

<div id="view">
<?php include ("../view/ViewProj.php"); ?>
</div>
</body>

</html>
