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

<head>
<link href="../css/MobileStyle.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="../css/jquery-ui.css" />

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
include("../function/Functions.php");

pconn();

formid();

date_default_timezone_set('America/New_York');

?>

</head>

<body>
<h1>Schedule</h1>
<?php linktable(); ?>

<table>
<tr><td>
<input onblur="blurfunct()" name="selDT" id="selDT" type=datetime-local>
</td><td >
<input type="button" class="link"  onclick="location.href='../sch/FormAutoSch.php';" value="Auto" />
</td><td>
<input type="button" class = "link" onclick="AddTime(5)" value="+05M" />
</td><td>
<input type="button" class = "link" onclick="AddTime(15)" value="+15M" />
</td><td>
<input type="button" class = "link" onclick="AddTime(30)" value="+30M" />
</td><td>
<input type="button" class = "link" onclick="AddTime(60)" value="+01H" />
</tr><tr>
<td>
 <p>
    <input id="selDurH" name="value" value=0 size=3/>
    <input id="selDurM" name="value" value=0  size=3/>
</p>
</td>

<td>
<input type="button" class = "link" onclick="AddSEvent()" value="Sch Event" />
</td>
<td>
<input type="button" class = "link" onclick="AddTime(-5)" value="-05M" />
</td><td>
<input type="button" class = "link" onclick="AddTime(-15)" value="-15M" />
</td><td>
<input type="button" class = "link" onclick="AddTime(-30)" value="-30M" />
</td><td>
<input type="button" class = "link" onclick="AddTime(-60)" value="-01H" />
</td></tr>
</table>

<?php
include ("../sch/btnSetJQSch.php");
?>

<h1>Dynamic</h1>
<div id ="buttons">
<?php
include ("../sch/btnSetJQDSch.php");
?>
</div>
<h1>Manual</h1>
<table>
<tr><td>
<?php
include("../function/DBConn.php");

$sql = "SELECT * FROM tblAct WHERE Status != 'Inactive' ORDER BY ActDesc";
$result = $conn->query($sql);

echo "<select id='selAct' name='selAct'>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ActID'] . "'>" . $row['ActDesc'] . "</option>";
}

echo "</select>";

$conn->close();
?>
</td></tr><tr><td>
<?php
include("../function/DBConn.php");

$sql = "SELECT tblCont.ContID, tblCont.ContDesc FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE tblProj.Projstatus != 'Closed' AND tblCont.Active!='N' ORDER BY ContID";
$result = $conn->query($sql);

echo "<select id='selCont' name='selCont'>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ContID'] . "'>" . $row['ContID'] . " " . $row['ContDesc'] ."</option>";
}

echo "</select>";

$conn->close();
?>
</td></tr><tr><td>
<input type="button" class = "link" onclick="AddManual()" value="Add" />
</td></tr>
<tr><td>
<input type="button" class = "link" onclick="UpdateSch()" value="Update" />
</td></tr>
<tr><td>
<input type="button" class = "link" onclick="UpdateVar()" value="Var" />
</td></tr>
</table>
</form>

<div id="sched2">

</div>

<div id="sched">
<?php include("../sch/SFooterEventQueries.php"); ?>
</div>

<script>
$(function () {
     $('#seconds').spinner({
         spin: function (event, ui) {
             if (ui.value >= 60) {
                 $(this).spinner('value', ui.value - 60);
                 $('#minutes').spinner('stepUp');
                 return false;
             } else if (ui.value < 0) {
                 $(this).spinner('value', ui.value + 60);
                 $('#minutes').spinner('stepDown');
                 return false;
             }
         }
     });
     $('#selDurM').spinner({
         spin: function (event, ui) {
             if (ui.value >= 60) {
                 $(this).spinner('value', ui.value - 60);
                 $('#hours').spinner('stepUp');
                 return false;
             } else if (ui.value < 0) {
                 $(this).spinner('value', ui.value + 60);
                 $('#hours').spinner('stepDown');
                 return false;
             }
         }
     });
     $('#selDurH').spinner({
         min: 0});
 });
</script>
<script>
var val = "<?php echo $T1 ?>";
document.getElementById("selDT").value=val;

var val2 ="<?php echo $QTime ?>";
document.getElementById("selTime").value=val2;

function btnJQs(act, cont, btnid, tbl)
{   

//For timed events
var selDurH = $( "#selDurH" ) . val();
var selDurM =$( "#selDurM" ) . val();
	
var min = (parseInt(selDurH)*60)+parseInt(selDurM);
//end timed events

    var dtime = $( "#selDT" ) . val();

    var p1 = '../sch/btnSetJQDSch.php';
    var p2 = '?selDate=';
    var p3 = dtime.substring(0,10);
    var p4 = '&selTime=';
    var p5 = dtime.substring(11,16);

    var p6 = p1+p2+p3+p4+p5; 
    
    $.post("../add/AddJQ.php",
    {
        v1: act,
        v2: cont,
        v3: dtime,
        selTbl: tbl
    });
    
        $("#"+btnid).css("background-color", "blue");

    setTimeout(function(){
        UpdateSch();
        UpdateButtonsS(p6);
        $("button").css("background-color", "lightgray");
        }, 1000);

	//For Timed Events
	if(min>0){

	var CTime = $( "#selDT" ) . val();
	
	var Y = CTime.substring(0,4);
	var M = CTime.substring(5,7);
	var D = CTime.substring(8,10);
	var H = CTime.substring(11,13);
	var Mn = CTime.substring(14,16);
	 
	var MTime = new Date(Y,M,D,H,Mn);
	 
	var m =  new Date(MTime.getTime());
	
	var OM = m.getMinutes();
	
	var NM = OM + min;
	
	m.setMinutes(NM);
	
	var Y = m.getFullYear();
	var M = m.getMonth();
	
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

	var ETime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn;
	
	UpdateVar(ETime);
	
		}
	//End Timed Events

}

function btnJQDelE1(a, b, c)
{
	$.post("../del/DelJQ.php",
	{
		v1: a,
		c1: b,
		selTbl: c
	});
	setTimeout(function(){
        UpdateSch();
        }, 100);

}

function UpdateVar(ETime)
{
	var CTime = $( "#selDT" ) . val();
	
	var a = '../sch/ViewSEvent2.php?TestTime=';
	
	$.ajax({
	url: a+CTime,
	type: 'GET',
	dataType: 'html'
	})
	.done(function(data) {
	
       act1 = data.substring(0,3);
	cont1 = data.substring(4);
	
		$.post("../add/AddJQ.php",
	{
		v1: act1,
		v2: cont1,
		v3: ETime,
		selTbl: 'tblSchedEvents'
	});
	setTimeout(function(){
        UpdateSch();
        }, 1000);
		
	
	
	})
	.fail(function() {
	$('#sched2').prepend('X');
	alert("E!");
	});
	
}


function UpdateButtonsS(a)
{
    $.ajax({
        url: a,
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
         $('#buttons').html( data )
    })
    .fail(function() {
        $('#buttons').prepend('X');
    });
}

function UpdateSch()
{

var CTime = $( "#selDT" ) . val();
	var D = CTime.substring(0,10);
	
	var a = '../sch/SFooterEventQueries.php?selDate=';
	
    $.ajax({
	url: a+D,
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
         $('#sched').html( data )
    })
    .fail(function() {
        $('#sched').prepend('No Add');
    });

}

function AddManual()
{

	var selDurH = $( "#selDurH" ) . val();
	var selDurM =$( "#selDurM" ) . val();
	
	var min = (parseInt(selDurH)*60)+parseInt(selDurM);
	
	var act = $( "#selAct" ) . val();
	var cont = $( "#selCont" ) . val();
	var tvar = $( "#selDT" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: act,
		v2: cont,
		v3: tvar,
		selTbl: 'tblSchedEvents'
	});
	
	setTimeout(function(){
        UpdateSch();
        }, 1000);
	
	//For Timed Events
	if(min>0){

	var CTime = $( "#selDT" ) . val();
	
	var Y = CTime.substring(0,4);
	var M = CTime.substring(5,7);
	var D = CTime.substring(8,10);
	var H = CTime.substring(11,13);
	var Mn = CTime.substring(14,16);
	 
	var MTime = new Date(Y,M,D,H,Mn);
	 
	var m =  new Date(MTime.getTime());
	
	var OM = m.getMinutes();
	
	var NM = OM + min;
	
	m.setMinutes(NM);
	
	var Y = m.getFullYear();
	var M = m.getMonth();
	
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

	var ETime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn;
	
	UpdateVar(ETime);
	
		}
	//End Timed Events
	
}


function blurfunct()
{
var dtime = $( "#selDT" ) . val();

var p1 = '../sch/btnSetJQDSch.php';
var p2 = '?selDate=';
var p3 = dtime.substring(0,10);
var p4 = '&selTime=';
var p5 = dtime.substring(11,16);

var p6 = p1+p2+p3+p4+p5;

UpdateButtonsS(p6);

UpdateSch();
}

function AddTime(min)
{
	var CTime = $( "#selDT" ) . val();
	
	var Y = CTime.substring(0,4);
	var M = CTime.substring(5,7);
	var D = CTime.substring(8,10);
	var H = CTime.substring(11,13);
	var Mn = CTime.substring(14,16);
	 
	var MTime = new Date(Y,M,D,H,Mn);
	 
	var m =  new Date(MTime.getTime());
	
	var OM = m.getMinutes();
	
	var NM = OM + min;
	
	m.setMinutes(NM);
	
	var Y = m.getFullYear();
	var M = m.getMonth();
	
	if(M===0){
		
		M=12;
		Y=(Y-1);
		
	}else if(D==31){
	
		M=(M-1);
		
	}

	if(M<10){

		M="0"+M;
		
	}
	
	if(D==31){
	
		D=31;
		
	}else{
	
	var D = m.getDate();
	
	}
	
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
	
	blurfunct();
}

function AddSEvent(){
	
	var selDurH = $( "#selDurH" ) . val();
	var selDurM =$( "#selDurM" ) . val();
	
	var min = (parseInt(selDurH)*60)+parseInt(selDurM);
	
	if(min==0){
		alert("NO!!!");
		}
		else{
	
	var CTime = $( "#selDT" ) . val();
	
	var Y = CTime.substring(0,4);
	var M = CTime.substring(5,7);
	var D = CTime.substring(8,10);
	var H = CTime.substring(11,13);
	var Mn = CTime.substring(14,16);
	 
	var MTime = new Date(Y,M,D,H,Mn);
	 
	var m =  new Date(MTime.getTime());
	
	var OM = m.getMinutes();
	
	var NM = OM + min;
	
	m.setMinutes(NM);
	
	var Y = m.getFullYear();
	var M = m.getMonth();
	
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

	var ETime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn;
	
	
	UpdateVar(ETime);
	
	
	}
}

</script>
</body>
</html>