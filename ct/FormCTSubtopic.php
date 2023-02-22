<?php
header("Cache-Control: no-cache, must-revalidate");
//include("../function/password_protect.php"); ?>
<html>
<head>
    <title>New Subtopic</title>
<?php include("../function/Functions.php"); ?>
<link rel="stylesheet" href="../css/MobileStyle.css" />

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
	<h1>New Subtopic</h1>
	<a href="../menu/MenuConvo.htm">Convo Menu</a>
	<?php include('../view/LinkTable.php'); ?>
	<form method='post' action='AddCTSubtopic.php'>
	<table>
		<tr>
			<td>Topic</td>
			<td>
<?php
include("../function/DBConn.php");

/*
$varSQL = $_GET["selSQL"];

if ($varSQL == NULL) {
	$varSQL = "SELECT DISTINCT tblCTTopic.CTTOP, tblCTTopic.CTTopic FROM tblCTTopic WHERE Active != 'N' ORDER BY CTTopic";
}
*/

$sql = "SELECT DISTINCT tblCTTopic.CTTOP, tblCTTopic.CTTopic
FROM tblCTTopic
WHERE Active != 'N'
ORDER BY CTTopic";

$result = $conn->query($sql);
?>

<select name='selCTTopic'>
<option></option>

<?php
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['CTTOP'] . "'>" . $row['CTTopic'] . "</option>";
}
$conn->close();
?>
	</select>
	</td></tr><tr>
	<td>Subtopic</td>
       <td>
            <textarea rows="2" cols="45" name='inpCTSubtopic'></textarea>
            </td>
            </tr><tr>
            <td>Detail</td>
            <td>
                <textarea rows="4" cols="45" name='inpCTSTDetail'></textarea>
            </td></tr>
            <tr>
	     <td>Tone</td>
	     <td>
	     <select name="selTone" id="selTone">
	     <option>Positive</option>
	     <option>Neutral</option>
	     <option>Negative</option>
	     </select>
	     </td>
	     </tr>
            <tr>
	     <td></td>
			<td><input type="submit" />
			</td></tr>
</table></form>

<hr />
	<table width=100%>
	<tr><td>
		<b>View Subtopics
	</td><td>
		<a href="javascript:UpdatePView('../ct/ViewCTSubtopic.php?selSQL=I');">Inactive</a>
	</td><td>
	<a href="javascript:UpdatePView('../ct/ViewCTSubtopic.php');">Active</a>
	</td></tr>
	<tr><td></td>
	<td>
		<a href="javascript:UpdatePView('../ct/ViewCTSubtopic.php?selSQL=Neg');">Negative</a>
	</td><td>
		<a href="javascript:UpdatePView('../ct/ViewCTSubtopic.php?selSQL=P');">Positive</a>
	</td></tr>
	</table>
<hr />

<div id='view'>
<?php include("ViewCTSubtopic.php"); ?>
</div>
</body></html>
