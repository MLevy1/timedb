<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css" />
<link href="../css/MobileStyle.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<div id="qry">

<?php
include("../function/Functions.php");
include("../form/qryMorningForm.php");
?>
</div>
</head>
<body onload="startTime()">
<h1>Life Clock</h1>
<?php
linktable(); ?>

<p id ="test"></p>
<p id ="test1"></p>
<p id ="test2"></p>
<p id ="test3"></p>

<div id ="buttons">
</div>
<div id="vtest">
</div>
<script>

var arrC = <?php echo json_encode( $arrActList ); ?>

var arrE = <?php echo json_encode( $arrETimes ); ?>

var TCheck = null;

var EventTime = null;

var EL = null;

var PTime = null;

var TTime = null;

var BegTime = new Date(1984, 5, 6, 9, 7);

var B = BegTime.getTime();

var ADBT = new Date(1987, 11, 11, 10, 0);

var ADB = ADBT.getTime();

var MLAD = B-ADB;

var NLBT = new Date(2020, 0, 16, 5, 25, 39);

var NLB = NLBT.getTime();

//PAGE CLOCK
function startTime() {


	if(EL==null){

		EL = 'test2';

	}else{

		EL = EL;
	}

    var today = new Date();

    if(EventTime==null){
    }else{
    	var diff = (today.getTime() - EventTime.getTime()) / 1000;

     	rdiff = Math.round(diff) + PTime;
     	tdiff = Math.round(diff) + TTime;

		var ELT = formatTime(rdiff);
		var ELTT = formatTime(tdiff);

    	document.getElementById(EL).innerHTML = ELT;
    	document.getElementById(EL).value = rdiff;

    	document.getElementById('Totalt').innerHTML = ELTT;
    	document.getElementById('Totalt').value = tdiff;
    }

    var TSec = today.getTime();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    var BL = 1100000000;
    
    document.getElementById('test').innerHTML =
    h + ":" + m + ":" + s;
    //var t = setTimeout(startTime, 500);
    

var VT = Math.round((TSec-B)/1000).toLocaleString('en-US');

var VTN = Math.round((TSec-NLB)/1000).toLocaleString('en-US');
    
//var BLD = B + (BL*1000);

var BLD = TSec + MLAD;

var bBLD = new Date(BLD);

document.getElementById('test3').innerHTML = (bBLD.toString());

document.getElementById('test2').innerHTML = (VT);

document.getElementById('test1').innerHTML = (VTN);
    
//document.getElementById('test3').innerHTML = (BLD);
    
    
    var t = setTimeout(startTime, 500);
    
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}


function formatTime(t){

		var h = t / (3600);
		var hr = Math.floor(h);
		var m = (h - hr)*60;
		var mr = Math.floor(m);
		var s = (m - mr)*60;
		var sr = Math.round(s);

		if(mr<10){

			mr='0'+mr;

		}

		if(sr<10){

			sr='0'+sr;

		}

		return (hr+":"+mr+":"+sr);

}


function getEventTime(){

	EventTime = new Date();
	var h = EventTime.getHours();
 	var m = EventTime.getMinutes();
 	var s = EventTime.getSeconds();
	m = checkTime(m);
	s = checkTime(s);

}
//END CLOCK


</script>

</body>
</html>