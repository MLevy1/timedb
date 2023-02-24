<html>
<head>
  <meta charset="UTF-8">
  <title>FormMorningJS</title>
  <link rel="stylesheet" href="style.css" />
<link href="../../styles.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<?php include("../function/Functions.php"); ?>

<div id="qry">
<?php include("../events/qryMorningForm.php"); ?>
</div>
</head>
<body onload="startTime()">
<h1>Morning JS</h1>
<?php linktable(); ?>

<p id ="test"></p>
<p id ="test1"></p>
<p id ="test2"></p>
<p id ="test3"></p>


<div id ="buttons">

<table width=100% border='1px solid black'>
<tr>
	<td class='mtblcell'>
      <div id='btnBathroom'></<div>
	</td><td class='mtblcell'>
		 <p id='Bathroomt'></p>
	</td><td class='mtblcell'>
		<div id='btnDog'></<div>
	</td><td class='mtblcell'>
		<p id='Dogt'></p>
</td></tr><tr>
	<td class='mtblcell'>
		<div id='btnShower'></<div>
	</td><td class='mtblcell'>
		 <p id='Showert'></p>
	</td><td class='mtblcell'>
		<div id='btnBreakfast'></<div>
	</td><td class='mtblcell'>
		<p id='Breakfastt'></p>
</td></tr><tr>
	<td class='mtblcell'>
		<div id='btnFloss'></<div>
	</td><td class='mtblcell'>
		<p id='Flosst'></p>
	</td><td class='mtblcell'>
		<div id='btnWalkD'></<div>
	</td><td class='mtblcell'>
		<p id='WalkDt'></p>
</td></tr><tr>
	<td class='mtblcell'>
		<div id='btnTeeth'></<div>
	</td><td class='mtblcell'>
		<p id='Teetht'></p>
	</td><td class='mtblcell'>
		<div id='btnPack'></<div>
	</td><td class='mtblcell'>
		<p id='Packt'></p>
</td></tr><tr>
	<td class='mtblcell'>
		<div id='btnShave'></<div>
	</td><td class='mtblcell'>
		<p id='Shavet'></p>
	</td><td class='mtblcell'>
		<div id='btnDriveC'></<div>
	</td><td class='mtblcell'>
		<p id='DriveCt'></p>
</td></tr><tr>
	<td class='mtblcell'>
		<div id='btnDress'></<div>
	</td><td class='mtblcell'>
		<p id='Dresst'></p>
	</td><td class='mtblcell'>
		<div id='btnWalkC'></<div>
		</td><td class='mtblcell'>
		<p id='WalkCt'></p>
</td></tr>
<tr><td colspan=2></td><td class='mtblcell'>
		<b>Total
		</td><td class='mtblcell'>
		<p id='Totalt'></p>
</td></tr>
</table>
</div>
<a href="javascript:UpdateEvents();">Update</a>
<div id="vtest">
<?php include("../view/FooterEventQueries.php"); ?>
</div>
<script>
var arrC = <?php echo json_encode( $arrActList ); ?>

var arrE = <?php echo json_encode( $arrETimes ); ?>

var TCheck = null;

var EventTime = null;

var EL = null;

var PTime = null;

var TTime = null;

//PAGE CLOCK
function startTime() {

	if(EL===null){

		EL = 'test2';

	}else{

		EL = EL;
	}

    var today = new Date();

    if(EventTime===null){
    }else{
    	var diff = (today.getTime() - EventTime.getTime()) / 1000;

     	rdiff = Math.round(diff) + PTime;
     	tdiff = Math.round(diff) + TTime;

	var ELT = formatTime(rdiff);
	var ELTT = formatTime(tdiff);

    	document.getElementById(EL).innerHTML = ELT;
    	document.getElementById(EL).value = rdiff;

	document.getElementById('Totalt') . 	
	innerHTML = ELTT;
    	
    	document.getElementById('Totalt') . value = 
    	tdiff;
    }

    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('test').innerHTML =
    h + ":" + m + ":" + s;
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

function MornBtn(btnid, btnname, btncontid, btnactid)
{

var AC = btnactid + btncontid;

var btnETime0 = arrE[AC][0];

if (btnETime0 < 1){

	var btnETime = arrE[AC][1];

}else{

	btnETime = btnETime0 + 'd';

}

var btnid1 = "btn"+ btnid;
document.getElementById(btnid1).innerHTML = (`<button id='`+ btnid +`' onclick="btnJQ1('`+ btnactid +`', '` + btncontid + `', '` + btnid +`')">`+ btnname + `<br>` + btnETime + `</button>`);
}

function fix0(a)
{
	if (a === undefined) {
		return 0;
	}
	else{
		return a;
	}

}

function ContTime(a, b)
{
if (a === undefined) {
	document.getElementById(b).innerHTML = '0:00:00';
	document.getElementById(b).value = 0;
}
else{

	var ELT = formatTime(a);

	document.getElementById(b).innerHTML = ELT;
	document.getElementById(b).value = a;
}
}

function Updateqry()
{
    $.ajax({
        url: '../events/qryMorningForm.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	$('#qry').html( data );
       	$('#qry').prepend( 'Y' );
    })
    .fail(function() {
        $('#qry').prepend('X');
    });
}

function JQPost(a, b, tbl)
{
	$.post("../add/AddJQ.php",
	{
		v1: a,
		v2: b,
		selTbl: tbl
	});
}

function btnJQ1(a, b, c)
{
	JQPost(a, b, 'tblEvents');

	UpdateEvents(a, b);
	
	EL = c+'t';

	PTime = document.getElementById(EL).value;
	
	TTime = document.getElementById('Totalt').value;

	getEventTime();

	$("button").css("background-color", "lightgray");
	
	$("#"+c).css("background-color", "lightgreen");
}

MornBtn('Bathroom', 'Bathroom', 'PERSONAL.2', 'B01');
MornBtn('Dog', 'Dog', 'Dog', 'P16');
MornBtn('Shower','Shower', 'PERSONAL.2', 'P29');
MornBtn('Breakfast','Breakfast', 'PERSONAL.8', 'B02');
MornBtn('Floss', 'Floss', 'PERSONAL.2', 'P60');
MornBtn('WalkD', 'Walk(D)', 'Dog', 'P30');
MornBtn('Teeth', 'Brush Teeth', 'PERSONAL.2', 'P09');
MornBtn('Shave','Shave & Hair', 'PERSONAL.2', 'P33');
MornBtn('Pack', 'Pack','PERSONAL.2', 'P32');
MornBtn('Dress', 'Dress','PERSONAL.2','P20');
MornBtn('DriveC', 'Drive(C)','TRANS.4', 'N02');
MornBtn('WalkC', 'Walk(C)','TRANS.4', 'P30');

function AllContTime()
{
	ContTime(arrC.B01PERSONAL2, 'Bathroomt');
	ContTime(arrC.P16Dog, 'Dogt');
	ContTime(arrC.P29PERSONAL2, 'Showert');
	ContTime(arrC.B02PERSONAL8, 'Breakfastt');
	ContTime(arrC.P60PERSONAL2, 'Flosst');
	ContTime(arrC.P30Dog, 'WalkDt');
	ContTime(arrC.P09PERSONAL2, 'Teetht');
	ContTime(arrC.P30TRANS4, 'WalkCt');
	ContTime(arrC.P33PERSONAL2, 'Shavet');
	ContTime(arrC.P32PERSONAL2, 'Packt');
	ContTime(arrC.P20PERSONAL2, 'Dresst');
	ContTime(arrC.N02TRANS4, 'DriveCt');
	
	var T = 
		fix0(arrC.B01PERSONAL2) + 
		fix0(arrC.P16Dog) + 
		fix0(arrC.P29PERSONAL2) + 
		fix0(arrC.B02PERSONAL8) + 		
		fix0(arrC.P60PERSONAL2) + 
		fix0(arrC.P30Dog) + 
		fix0(arrC.P09PERSONAL2) + 
		fix0(arrC.P30TRANS4) + 
		fix0(arrC.P33PERSONAL2) + 
		fix0(arrC.P32PERSONAL2) + 
		fix0(arrC.P20PERSONAL2) + 
		fix0(arrC.N02TRANS4);
	
	ContTime(T, 'Totalt');
	
}

AllContTime();

startTime();
</script>
</body>
</html>