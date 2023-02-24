console.log("start loading JSFunctions");

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
  	$.post("./del/DelJQ.php",
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
        url: './view/FooterEventQueries.php',
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
        url: './view/LinkTable.php',
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
	
	var page1= './btn/btnSetJDyn.php';
	
	$.post("./add/AddJQ.php",
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
        	UpdateButtons('./btn/btnSetJQ.php');
        }
        if(d==='p'){
        	UpdateButtons('./btn/btnJProb.php');
        }
	$("button").css("background-color", "lightgray");
	$("#"+c).css("background-color", "pink");
}

function btnJQGoal(a, b, c, d)
{
	var tvar = $( "#GDate" ) . val();

	$.post("./add/AddJQ.php",
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
        url: './view/ViewNewDailyGoalsP.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#vtest').html( data )
	LoadDiv('buttons', './goals/btnSetJQGoals.php');
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
	
	$.post("./add/AddJQ.php",
	{
		v1: tvar,
		v2: a,
		v3: b,
		selTbl: 'tblNewDailyGoals'
	});
	
	setTimeout(function(){
        	UpdateGoals();
        }, 100);
}

function btnJQGrade(a, b)
{
	$.post("./update/UpdateJQ.php",
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
	$.post("./del/DelJQ.php",
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

function loadPage(page, script) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("main").innerHTML = this.responseText;

            // Load the JavaScript file if a path was provided
            if (script) {
                var scriptTag = document.createElement('script');
                scriptTag.src = script;
                document.head.appendChild(scriptTag);
            }

            // Execute any JavaScript code returned in the response
            var scriptCode = this.getResponseHeader('X-JS-Code');
            if (scriptCode) {
                eval(scriptCode);
            }
        }
    };
    xhttp.open("GET", page, true);
    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.send();
}



function includeHTML() {
            var z, i, elmnt, file, xhttp;
            /* Loop through a collection of all HTML elements */
            z = document.getElementsByTagName("*");
            for (i = 0; i < z.length; i++) {
                elmnt = z[i];
                /* Search for elements with the include attribute */
                file = elmnt.getAttribute("include");
                if (file) {
                    /* Make an HTTP request to the included file */
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4) {
                            if (this.status == 200) {elmnt.innerHTML = this.responseText;}
                            if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
                            /* Remove the attribute, and call this function again */
                            elmnt.removeAttribute("include");
                            includeHTML();
                        }
                    }
                    xhttp.open("GET", file, true);
                    xhttp.send();
                    /* Exit the function */
                    return;
                }
            }
        }


console.log("end loading JSFunctions");