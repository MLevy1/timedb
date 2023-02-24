<?php 
header("Cache-Control: no-cache, must-revalidate");
?>
<html>
<head>
    <title>New Convo Topic</title>
<?php include("../function/Functions.php"); ?>
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
	<h1>New Convo Topic</h1>
	<a href="../menu/MenuConvo.htm">Convo Menu</a>
	<?php include('../view/LinkTable.php'); ?>
	<form method='post' action='AddCTTopic.php'>
	<table>
		<tr>
			<td>Topic</td>
			<td>
				<textarea rows="1" cols="30" name='CTTopic'></textarea>
			</td></tr>
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
		<a href="javascript:UpdatePView('../ct/ViewCTTopic.php?selSQL=All');">All</a>
	</td><td>
		<a href="javascript:UpdatePView('../ct/ViewCTTopic.php?selSQL=A');">Active</a>
	</td><td>
		<a href="javascript:UpdatePView('../ct/ViewCTTopic.php?selSQL=I');">Inactive</a>
	</td></tr>
	</table>
<hr />

<div id='view'>
<?php include("ViewCTTopic.php"); ?>
</div>
</body></html>
