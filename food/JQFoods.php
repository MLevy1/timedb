<?php
header("Cache-Control: no-cache, must-revalidate");
?>

<head>
<link href="../../styles.css" rel="stylesheet"/>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

</head>
<body>

<?php
include("../function/Functions.php");

pconn();

formid();

date_default_timezone_set('America/New_York');

?>

<h1>Foods</h1>
<?php linktable(); ?>

<table width=100%>
	<tr>
		
		<td><b>Food</td>
		
		<td>
		
			<input id='txtFood' name='txtFood'></input>
			
		</td>
		
		<td>
		
			<p id="pFID" name="pFID"></p>
		
		</td>
		
		<td>	
			<input type="button" class = "link" onclick="AddFood()" value="Add" />
		</td>
		<td>
			<input type="button" class = "link" onclick="btnUpdateF()" value="Update" />
		</td>
	</tr>
</table>

<div id="ViewTbl">
<?php include("../food/ViewFoods.php"); ?>
</div>

<script>

function btnUpdateF()
{

	var a = $( "#txtFood" ) . val();
	var b = $( "#pFID" ) . text();

	$.post("../update/UpdateJQ.php",
	{

		v1: a,
		v2: b,
		selTbl: "tblFoods"
	});
	setTimeout(function(){
        	LoadDiv("ViewTbl", "../food/ViewFoods.php");
       }, 1000);

}


function btnJQDelE(a, b, c)
{

var result = confirm("Delete record?");

if (result == true) {
  	$.post("./timedb/del/DelJQ.php",
	{
		v1: a,
		c1: b,
		selTbl: c
	});
	setTimeout(function(){
        	LoadDiv("ViewTbl", "../food/ViewFoods.php");
        }, 500);
}

}

function Updatetbl()
{
    $.ajax({
        url: '../food/ViewFoods.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
         $('#ViewTbl').html( data )
    })
    .fail(function() {
        $('#ViewTbl').prepend('No Add');
    });

}

function AddFood()
{

	var a = $( "#txtFood" ) . val();
	
	var b = "N";
	
	$.post("../add/AddJQ.php",
	{
		v1: a,
		
		selTbl: 'tblFoods'
	});
	
	setTimeout(function(){
        LoadDiv("ViewTbl", "../food/ViewFoods.php");
        }, 1000);

}

function btnEdit1(a, b, c, d)
{

$('#pFID').text( a );
$('#txtFood').val( d );

}
</script>
</body>
</html>