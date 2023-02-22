<?php
header("Cache-Control: no-cache, must-revalidate");

$QDate = $_GET["selDate"];
$QTime = $_GET["selTime"];

if($QDate == Null){
$QDate = date('Y-m-d');
$QTime = date('H:i');
}

$T1 = $QDate.'T'.$QTime;
?>
<html>
<head>
<link href="../css/MobileStyle.css" rel="stylesheet"/>

<link href="../css/jquery-ui.css" rel="stylesheet"/>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>
<body>

<?php
include("../function/Functions.php");

pconn();

formid();

date_default_timezone_set('America/New_York');

?>
<div id="wgtform">
<h1> JQ Weight</h1>
<?php linktable(); ?>

<table>
	<tr>
		<td colspan=2>
			<input name="selDT" id="selDT" type=datetime-local>
		</td><td colspan=2>
			 <input id='txtWeight' name='txtWeight' class='single'></input>
		</td>
		<td>
			<input type="button" class = "link" onclick="AddManual()" value="Add" />
		</td></tr>
		<tr><td>
			<input type="button" class = "link" onclick="UpdateSch()" value="Reset" />
		</td><td>
			<input type="button" class = "link" onclick="location.href='../food/JQFoodEvents.php';" value="Food" />
		</td>
		<td>
			<input type="button" class = "link" onclick="btnWgt(1)" value="+1" />
		</td>
		<td>
			<input type="button" class = "link" onclick="btnWgt(-1)" value="-1" />
		</td>
	</tr>
</table>

<table>
	<tr>
	
	<td>
	
	<p><input type="date" id='selE' name='selE'></p>
	
	</td>
	
		<td>
		
			<select id="selA" class="ssmselect">
				<option value="A">All
				</option>
				
				<option value="L">Low
				</option>
				
				<option value="M">Avg
				</option>
				
				<option value="H">High
				</option>
			</select>
		
		</td>
		
		<td>
			<select id="selI" class="ssmselect">
				<option value="A">All
				</option>
				<option value=1>1d
				</option>
				<option value=2>2d
				</option>
				<option value=3>3d
				</option>
				<option value=4>4d
				</option>
				<option value=7>1w
				</option>
				<option value=14>2w
				</option>
				<option value=21>3w
				</option>
				<option value=30>1m
				</option>
				<option value=60>2m
				</option>
				<option value=90>3m
				</option>
				<option value=180>6m
				</option>
				<option value=275>9m
				</option>
				<option value=365>1y
				</option>
			</select>
		</td>
		
		<td>
				<input type="button" class = "link" onclick="btnChart()" value="Chart" />
		</td>
	
	</tr>
</table>
</div>
<div id="view">
<?php include("ViewWeight.php"); ?>
</div>
<script>

var val3 ="<?php echo $SW ?>";

var arrW = <?php echo json_encode( $data ); ?>

let lastT =  arrW[0][0];
let lastW = arrW[2][0];

var spinner;
 
  $( function() {
    spinner = $( "#txtWeight" ).spinner({
    	step: 0.2
    });
    
    spinner.spinner( "value", val3 );
    
});

var val = "<?php echo $T1 ?>";
document.getElementById("selDT").value=val;

var val2 ="<?php echo $QTime ?>";
document.getElementById("selTime").value=val2;

function getSW()
{
alert(arrW[0][0]);

var val3  ="<?php echo $SW ?>";

spinner.spinner( "value", val3 );

}

function btnWgt(a)
{
var v1 = $( "#txtWeight" ).val();
var v2 = parseFloat(v1) + a;
$( "#txtWeight" ).val(v2);
}

function btnChart()
{
var vA = $( "#selA" ).val();
var vI = $( "#selI" ).val();
var vE = $( "#selE" ).val();

var vStr = '../weight/ViewWeight.php?I='+vI+'&A='+vA+'&E='+vE;

UpdatePView(vStr);

}


function btnJQDelE(a, b, c)
{

var result = confirm("Delete record?");

if (result == true) {
  	$.post("../del/DelJQ.php",
	{
		v1: a,
		c1: b,
		selTbl: c
	});
	setTimeout(function(){
        UpdateSch();
        }, 1000);
}

}

function UpdateSch()
{
    $.ajax({
        url: '../weight/ViewWeight.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
         $('#view').html( data )
    })
    .fail(function() {
        $('#view').prepend('No Add');
    });

	ResetTime();

}

function AddManual()
{
	var W = $( "#txtWeight" ) . val();
	
	var WD = $( "#selDT" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: WD,
		
		v2: W,
		
		selTbl: 'tblWeight'
	});
	setTimeout(function(){
        UpdateSch();
        }, 1000);
        
        if(WD>lastT){
        	
        	lastT=WD;
        	lastW=W;
        
        }

	spinner.spinner( "value", lastW );

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
	
	var H = m.getHours();
	
	if(H<10){
		H="0"+H;
		}
	
	var Mn = m.getMinutes();
	
	if(Mn<10){
		Mn="0"+Mn;
		}

	var NDTime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn;

$( "#selDT" ) . val(NDTime);
}

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
</body>
</html>