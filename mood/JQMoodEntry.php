<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

formid();

date_default_timezone_set('America/New_York');

$QDate = $_GET["selDate"];
$QTime = $_GET["selTime"];

if($QDate == Null){
$QDate = date('Y-m-d');
$QTime = date('H:i');
}

$T1 = $QDate.'T'.$QTime;

?>
<head>

<link href="../../styles.css" rel="stylesheet"/>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body>

<h1> JQ Mood</h1>

<?php linktable(); ?>

<table>
	<tr>
	
		<td colspan=2>
			<input name="selDT" id="selDT" type=datetime-local>
		</td><td colspan=3>
			 <input id='txtMood' name='txtMood'></input>
		</td>
		<td>
			<input type="button" class = "link" onclick="AddManual()" value="Add" />
		</td></tr><td>
			<input type="button" class = "link" onclick="UpdateChart()" value="Update" />
		</td><td>
			<input type="button" class = "link" onclick="ResetTime()" value="Reset" />
		</td><td>
			<input type="button" class = "link" onclick="AddMood(-1)" value="-1" />
		</td> <td>
			<input type="button" class = "link" onclick="AddMood(0)" value="0" />
		</td> <td>
			<input type="button" class = "link" onclick="AddMood(1)" value="1" />
		</td>
	</tr>
</table>

<table>
	<tr>
		<td>
	
			<input type="button" class = "link" onclick="UpdateTbl('../mood/ViewMood.php?I=1')" value="Day" />
			
		</td>
		<td>
	
			<input type="button" class = "link" onclick="UpdateTbl('../mood/ViewMood.php?I=7')" value="Week" />
		
		</td>
		<td>
		
			<input type="button" class = "link" onclick="UpdateTbl('../mood/ViewMood.php?I=30')" value="Month" />
		
		</td>
		<td>
		
			<input type="button" class = "link" onclick="UpdateTbl('../mood/ViewMood.php?I=90')" value="Quarter" />
		
		</td>
		<td>
		
			<input type="button" class = "link" onclick="UpdateTbl('../mood/ViewMood.php')" value="All" />
		
		</td>
	</tr>
</table>

<div id="tbl">
<?php include("../mood/ViewMood.php"); ?>
</div>

<script>
var val3 ="<?php echo $SW ?>";

var spinner;
 
  $( function() {
    spinner = $( "#txtMood" ).spinner({
    	min: -1,
    	max: 1
    });
   
   spinner.spinner( "value", val3 );   
    
});

var val = "<?php echo $T1; ?>";
document.getElementById("selDT").value=val;

var val2 ="<?php echo $QTime ?>";
document.getElementById("selTime").value=val2;

function btnJQDelE(a, b, c, d)
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
        UpdateTbl('../mood/ViewMood.php');
        }, 1000);
        
        $( "#txtMood" ) . val(d);
        
        }
        
}

function UpdateTbl(a)
{
    $.ajax({
        url: a,
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#tbl').html( data )
    })
    .fail(function() {
        $('#tbl').prepend('X');
    });
}


function AddManual()
{
	var W = $( "#txtMood" ) . val();
	
	var WD = $( "#selDT" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: WD,
		
		v2: W,
		
		selTbl: 'tblMood'
	});
	setTimeout(function(){
        UpdateTbl('../mood/ViewMood.php');
        }, 1000);

}

function AddMood(a)
{
	ResetTime();
	
	var WD = $( "#selDT" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: WD,
		
		v2: a,
		
		selTbl: 'tblMood'
	});
	setTimeout(function(){
        UpdateTbl('../mood/ViewMood.php');
        }, 1000);
        
        $( "#txtMood" ) . val(a);

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

</script>
</body>
</html>