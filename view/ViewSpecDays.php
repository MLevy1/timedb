<?php header("Cache-Control: no-cache, must-revalidate"); ?>
<h1>Daily Duration - Selected Activity</h1>
<a href="../menu/MenuEventLists.htm">Events Menu</a>
<link rel="stylesheet" href="../../styles.css" />

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<?php
include('../function/Functions.php');
linktable();
?>
<div id='vtest'>

<?php include('../view/ViewDayInfo.php'); ?>

</div>
<script>
function btnJQDate(a, b)
{
	$.post("../add/AddJQ.php",
	{
		v1: a,
		v2: b,
		selTbl: 'tblDateInfo'
	});
	alert(a+" "+b+" Done!!");
	UpdateDInfo();
}

function UpdateDInfo()
{
    $.ajax({
        url: '../view/ViewDayInfo.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#vtest').html( data )
    })
    .fail(function() {
        $('#vtest').prepend('No Add: '+'<br>');
    });
}

</script>