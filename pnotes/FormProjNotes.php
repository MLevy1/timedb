<?php 
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");

pconn();

$selCont1 = $_REQUEST['selCont'];

if($selCont1 === null){
$selCont1 = "Admin - Personal";
}

?>
<html>
<head>

<!-- NEW -->

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

<!-- END NEW -->

<script>
var val = "<?php echo $selCont1 ?>";
document.getElementById("selCont").value=val;
</script>
<title>Project Notes</title>
<link rel="stylesheet" href="../../styles.css" />
</head>
<body>
<h1>Project Notes</h1>
<?php include('../view/LinkTable.php'); ?>
<h2>Add New Note</h2>
<table>
<form method="post" action="../pnotes/AddProjNote.php">
<tr><td>
<b>Note: </b>
</td><td>
	<textarea rows="5" cols="40" id="txtNote" name="txtNote"></textarea>
</td></tr><tr><td>
<b>ContID: </b>
</td><td>
<select id='selCont' name='selCont'>
<?php
$sql = "SELECT tblCont.ContID, tblCont.ContDesc, tblCont.Active, tblProj.ProjDesc, tblProj.ProjStatus
        FROM tblCont
        INNER JOIN tblProj ON tblCont.ProjID=tblProj.ProjID
        WHERE tblProj.ProjStatus!='Closed'
        AND tblCont.Active!='N'
        ORDER BY ContDesc";

$result = mysqli_query($conn, $sql);

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ContID'] . "'>" .$row['ContDesc']." - ".$row['ProjDesc'] . "</option>";
}
?>

</select>
</td></tr><tr><td></td><td>
	<input type="submit" name="submit" />
</td></tr>

</form>
</table>

<!-- New -->

<hr \>
	<table width=100%>
	<tr><td>
		<b>View Project Notes
	</td><td>
		<a href="javascript:UpdatePView('../pnotes/ViewProjNotes.php?selSQL=All');">All</a>
	</td><td>
		<a href="javascript:UpdatePView('../pnotes/ViewProjNotes.php?selSQL=A');">Active</a>
	</td><td>
		<a href="javascript:UpdatePView('../pnotes/ViewProjNotes.php?selSQL=I');">Inactive</a>
	</td></tr>
	</table>
<hr \>

<!-- End New -->

<h2>Notes List</h2>
<div id='view'>
<?php include ('../pnotes/ViewProjNotes.php'); ?>
</div>
</body></html>

