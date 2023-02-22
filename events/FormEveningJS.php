<html>
<head>
  <meta charset="UTF-8">
  <title>FormEveningJS</title>
  <link rel="stylesheet" href="style.css" />
<link href="../css/MobileStyle.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?php include("../function/Functions.php"); ?>

<div id="qry">
<?php
include("../events/qryMorningForm.php");
?>
</div>
<script>


</script>
</head>
<body onload="startTime()">
<h1>Evening JS</h1>
<?php linktable(); ?>

<p id ="test"></p>
<p id ="test1"></p>
<p id ="test2"></p>

<div id ="buttons">

<table width=100% border='1px solid black'>
<tr>

	</td><td class='mtblcell'>
	<div id='btnPack'></<div>
	</td><td class='mtblcell'>
	<p id='Packt'></p>

	</td><td class='mtblcell'>
	<div id='btnLaundry'></<div>
	</td><td class='mtblcell'>
	<p id='Laundryt'></p>

</td></tr><tr>

	</td><td class='mtblcell'>
	<div id='btnDog'></<div>
	</td><td class='mtblcell'>
	<p id='Dogt'></p>
	
	<td class='mtblcell'>
	<div id='btnSheets'></<div>
	</td><td class='mtblcell'>
	<p id='Sheetst'></p>

</td></tr><tr>	 
		 
	<td class='mtblcell'>
	<div id='btnDress'></<div>
	</td><td class='mtblcell'>
	<p id='Dresst'></p>	 		 
		
	</td><td class='mtblcell'>
	<div id='btnKitchen'></<div>
	</td><td class='mtblcell'>
	<p id='Kitchent'></p>	
		
</td></tr><tr>

	<td class='mtblcell'>
	<div id='btnBathroom'></<div>
	</td><td class='mtblcell'>
	<p id='Bathroomt'></p>
				
	</td><td class='mtblcell'>
	<div id='btnVacuum'></<div>
	</td><td class='mtblcell'>
	<p id='Vacuumt'></p>
		
</td></tr><tr>

	<td class='mtblcell'>
	<div id='btnRun'></<div>
	</td><td class='mtblcell'>
	<p id='Runt'></p>
		
	</td><td class='mtblcell'>
	<div id='btnTV'></<div>
	</td><td class='mtblcell'>
	<p id='TVt'></p>
		
</td></tr><tr>

	<td class='mtblcell'>
	<div id='btnGym'></<div>
	</td><td class='mtblcell'>
	<p id='Gymt'></p>
		
		
	<td class='mtblcell'>
	<div id='btnTrash'></<div>
	</td><td class='mtblcell'>
	<p id='Trasht'></p>
		
</td></tr><tr>

	</td><td class='mtblcell'>
	<div id='btnCook'></<div>
	</td><td class='mtblcell'>
	<p id='Cookt'></p>	
		
	<td class='mtblcell'>
	<div id='btnLawn'></<div>
	</td><td class='mtblcell'>
	<p id='Lawnt'></p>		
		
</td></tr><tr>

</td><td class='mtblcell'>
	<div id='btnDinner'></<div>
	</td><td class='mtblcell'>
	<p id='Dinnert'></p>
		
	<td class='mtblcell'>
	<div id='btnTeeth'></<div>
	</td><td class='mtblcell'>
	<p id='Teetht'></p>

</td></tr><tr>
		
	<td class='mtblcell'>
	<div id='btnDishes'></<div>
	</td><td class='mtblcell'>
	<p id='Dishest'></p>

	</td><td class='mtblcell'>
	<div id='btnBed'></<div>
	</td><td class='mtblcell'>
	<p id='Bedt'></p>

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
       	$('#qry').html( data )
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

MornBtn('Pack', 'Pack','PERSONAL.2', 'P32');

MornBtn('Dog', 'Dog', 'Dog', 'P16');

MornBtn('Trash','Trash', 'PERSONAL.3', 'P41');

MornBtn('Dress', 'Dress','PERSONAL.2','P20');

MornBtn('Dinner','Dinner', 'PERSONAL.8', 'P14');

MornBtn('Bathroom', 'Bathroom', 'PERSONAL.2', 'B01');

MornBtn('Run', 'Run', 'Dog', 'P42');

MornBtn('Cook', 'Cook', 'PERSONAL.8', 'P13');

MornBtn('Teeth', 'Brush Teeth', 'PERSONAL.2', 'P09');

MornBtn('Gym', 'Gym', 'PERSONAL.4', 'P31');

MornBtn('Dishes', 'Dishes','PERSONAL.3', 'P35');

MornBtn('Laundry','Laundry', 'PERSONAL.3', 'P34');

MornBtn('Sheets', 'Sheets','PERSONAL.3', 'P61');

MornBtn('Kitchen','Kitchen', 'PERSONAL.3', 'P58');

MornBtn('Vacuum', 'Vacuum','PERSONAL.3', 'P59');

MornBtn('TV', 'TV', 'PERSONAL.1', 'N03');

MornBtn('Lawn', 'Lawn', 'PERSONAL.3', 'P37');

MornBtn('Bed', 'Bed', 'NA', 'N04');

function AllContTime()
{
	ContTime(arrC.B01PERSONAL2, 'Bathroomt');
	ContTime(arrC.P16Dog, 'Dogt');
	ContTime(arrC.P41PERSONAL3, 'Trasht');
	ContTime(arrC.P60PERSONAL2, 'Lawnt');
	ContTime(arrC.P09PERSONAL2, 'Teetht');
	ContTime(arrC.P32PERSONAL2, 'Packt');
	ContTime(arrC.P20PERSONAL2, 'Dresst');
	
	ContTime(arrC.N04NA, 'Bedt');
	ContTime(arrC.P13PERSONAL8, 'Cookt');
	ContTime(arrC.P14PERSONAL8, 'Dinnert');
	ContTime(arrC.P35PERSONAL3, 'Dishest');
	
	ContTime(arrC.P31PERSONAL4, 'Gymt');
	ContTime(arrC.P58PERSONAL3, 'Kitchent');
	ContTime(arrC.P34PERSONAL3, 'Laundryt');
	ContTime(arrC.P42Dog, 'Runt');
	ContTime(arrC.P61PERSONAL3, 'Sheetst');
	ContTime(arrC.N03PERSONAL1, 'TVt');
	ContTime(arrC.P59PERSONAL3, 'Vacuumt');
	
	var T = 
	fix0(arrC.B01PERSONAL2) +
	fix0(arrC.P16Dog) +
	fix0(arrC.P41PERSONAL3) +
	fix0(arrC.P37PERSONAL3) +
	fix0(arrC.P09PERSONAL2) +
	fix0(arrC.P32PERSONAL2) +
	fix0(arrC.P20PERSONAL2) +
	fix0(arrC.N04NA) +
	fix0(arrC.P13PERSONAL8) +
	fix0(arrC.P14PERSONAL8) +
	fix0(arrC.P35PERSONAL3) +
	fix0(arrC.P31PERSONAL4) +
	fix0(arrC.P58PERSONAL3) +
	fix0(arrC.P34PERSONAL3) +
	fix0(arrC.P42Dog) +
	fix0(arrC.P61PERSONAL3) +
	fix0(arrC.N03PERSONAL1) +
	fix0(arrC.P59PERSONAL3);
	
	
	ContTime(T, 'Totalt');
	
}

AllContTime();

startTime();
</script>

</body>
</html>