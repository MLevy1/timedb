<?php
header("Cache-Control: no-cache, must-revalidate");

$QDate = date('Y-m-d');
$QTime = date('H:i');

$T1 = $QDate.'T'.$QTime;
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

<h1>Food Events</h1>
<?php linktable(); ?>

<table width=100%>
	<tr>
	
		<td><b>Date/Time</td>
	
		<td colspan=3>
			<input name="selDT" id="selDT" type=datetime-local>
		</td>
		
		</tr><tr>
		
		<td><b>Food</td>
		
		<td colspan=3>
			
			<?php addsel2NS("txtFood", "FoodID", "Food", "tblFoods"); ?>
			
		</td>
		
		</tr><tr>
		
		<td><b>Event Type</td>
		
		<td>
		
			<select id='txtType' name='txtType' class='single'>
			
				<option>M</option>
				<option>C</option>
			</select>
		
	
		
		</td>
		
		<td>	
			<input type="button" class = "link" onclick="AddManual()" value="Add" />
		</td>
		
		<td>
			<input type="button" class = "link" onclick="ResetTime()" value="Reset" />
		</td>
		
		<td>

			<input type="button" class = "link" onclick="LoadDiv('form', '../food/JQFoods.php?link=1')" value="Foods" />
		
	</tr>
</table>

<hr/>

<table>
	<tr>
		<td>
			<input type="button" class = "link" onclick="LoadDiv('ViewTbl', '../food/ViewFoodEvents.php?I=1')" value="Day" />
		</td>
		<td>
			<input type="button" class = "link" onclick="LoadDiv('ViewTbl', '../food/ViewFoodEvents.php?I=7')" value="Week" />
		</td>
		<td>
			<input type="button" class = "link" onclick="LoadDiv('ViewTbl', '../food/ViewFoodEvents.php?I=30')" value="Month" />
		</td>
		<td>
			<input type="button" class = "link" onclick="LoadDiv('ViewTbl', '../food/ViewFoodEvents.php?I=90')" value="Quarter" />
		</td>
		<td>
			<input type="button" class = "link" onclick="LoadDiv('ViewTbl', '../food/ViewFoodEvents.php')" value="All" />
		</td>
		<td>
			<input type="button" class = "link" onclick="btnEdit()" value="Edit" />
		</td>
	</tr>
</table>

<hr/>

<table>

<tr>
<td><p id="pTS" name="pTS"></p></td>

<td> <p id="inpF" name="inpF"></p></td>

<td> <?php addsel2NS("selFood", "FoodID", "Food", "tblFoods"); ?> </td>

<td>
<input type="button" class = "link" onclick="btnUpdateFE()" value="Update" />
</td>
</tr>

</table>

<hr/>

<div id="ViewTbl">
<?php include("ViewFoodEvents.php"); ?>
</div>

<script>
var val = "<?php echo $T1 ?>";
document.getElementById("selDT").value=val;

var val2 ="<?php echo $QTime ?>";
document.getElementById("selTime").value=val2;

function btnUpdateFE()
{

	var a = $( "#selFood" ) . val();
	var b = $( "#pTS" ) . text();

	$.post("../update/UpdateJQ.php",
	{

		v1: a,
		v2: b,
		selTbl: "tblFoodEvents"
	});
	
	setTimeout(function(){
	
        	LoadDiv('ViewTbl', '../food/ViewFoodEvents.php');
        	
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
	
        LoadDiv('ViewTbl', '../food/ViewFoodEvents.php');
        
        }, 500);
}

}

function AddManual()
{
	var Food = $( "#txtFood" ) . val();

	var EType = $( "#txtType" ) . val();
	
	var FEDate = $( "#selDT" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: FEDate,
		
		v2: Food,

		v3: EType,
		
		selTbl: 'tblFoodEvents'
	});
	setTimeout(function(){
	
        LoadDiv('ViewTbl', '../food/ViewFoodEvents.php');
        
        }, 1000);

}

function ResetTime()
{

	var m =  new Date(); 

	var Y = m.getFullYear();
	var M = m.getMonth();
	
	var M = M+1;
	
	if(M<10){
		M="0"+M;
		}
	
	var D = m.getDate();
	
	if(D<10){
		D="0"+D;
		}
	
	var Mn = m.getMinutes();
	
	if(Mn===0){
	
		lMn = 59;
	
	}else{
	
		var lMn = Mn-1;
	
	}
	
	var H = m.getHours();
	
	if(Mn===0){
	
		lH = H-1;
		
	}else{
		
		lH=H;
		
	}
	
	if(H<10){
		H="0"+H;
		}
	
	if(lH<10){
	
		lH="0"+lH;
	}
	
	if(Mn<10){
		Mn="0"+Mn;
		}
		
	if(lMn<10){
		lMn="0"+lMn;
		}

	var NDTime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn;
	
$( "#selDT" ) . val(NDTime);

}


function btnEdit1(a, b, c, d)
{

$('#pTS').text( a );
$('#inpF').text( d );

}

</script>
</body>
</html>