function LoadDiv(div, form)
{
	$( document ).ready(function() {
		$(function() {

			setTimeout(function(){
     	 		$("#"+div).load(form);
      		}, 500);
		});
	});
}


function JDel(a, b, c, div, form)
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
        	$("#"+div).load(form);
        }, 1000);
}

}


function UpdateEvents(a, b)
{
    $.ajax({
        url: '../view/FooterEventQueries.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#vtest').html( data )
    })
    .fail(function() {
        $('#vtest').prepend('No Add: '+a+' '+b+' '+Date()+'<br>');
    });
}


function UpdateButtons(a)
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

function UpdateLinks()
{
    $.ajax({
        url: '../view/LinkTable.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#ltbl').html( data )
    })
    .fail(function() {
        ;
    });
}

function btnJQ(a, b, c, d, e)
{	
	//var page= '../btn/btnSetJDyn.php?selHrRange='.e;
	
	var page1= '../btn/btnSetJDyn.php';
	
	$.post("../add/AddJQ.php",
	{
		v1: a,
		v2: b,
		selTbl: 'tblEvents'
	});
	setTimeout(function(){
        UpdateEvents(a, b);
        }, 500);
        UpdateLinks();
        if(d==='y'){
        	//UpdateButtons(page1);
        	UpdateButtons('../btn/btnSetJDyn.php?selHrRange='+e);
        }
        if(d==='n'){
        	UpdateButtons('../btn/btnSetJQ.php');
        }
        if(d==='p'){
        	UpdateButtons('../btn/btnJProb.php');
        }
	$("button").css("background-color", "lightgray");
	$("#"+c).css("background-color", "pink");
}

function btnJQGoal(a, b, c, d)
{
	var tvar = $( "#GDate" ) . val();

	$.post("../add/AddJQ.php",
	{
		v1: a,
		v2: b,
		v3: tvar,
		selTbl: 'tblNewDailyGoals'
	});
	setTimeout(function(){
        UpdateGoals();
        }, 100);
	$("button").css("background-color", "lightgray");
	$("#"+d).css("background-color", "yellow");
}

function UpdateGoals()
{
    $.ajax({
        url: '../view/ViewNewDailyGoalsP.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#vtest').html( data )
    })
    .fail(function() {
        $('#vtest').prepend('Error updating.');
    });
}

function AddNewGoal()
{
	var a = $( "#selGoal" ) . val();
	var b = $( "#selCont" ) . val();
	var tvar = $( "#GDate" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: a,
		v2: b,
		v3: tvar,
		selTbl: 'tblNewDailyGoals'
	});
	setTimeout(function(){
        UpdateGoals();
        }, 100);
}

function btnJQGrade(a, b)
{
	$.post("../update/UpdateJQ.php",
	{
		v1: a,
		v2: b,
		selTbl: 'tblNewDailyGoals'
	});
	setTimeout(function(){
        UpdateGoals();
        }, 100);
}

function btnJQDel(a, b, c)
{
	$.post("../del/DelJQ.php",
	{
		v1: a,
		c1: b,
		selTbl: c
	});
	setTimeout(function(){
        UpdateGoals();
        }, 100);
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