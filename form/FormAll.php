<?php
include("../function/Functions.php");
formid();
$link=1;
?>

<html>
	<head>
	
		<?php $page="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
		include("../function/Functions.php");
?>

<link rel="stylesheet" href="../../styles.css" />

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script src="../function/JSFunctions1.js" ></script>

<script defer>

function AddMood1(a)
{
	
	$.post("../add/AddJQ.php",
	{
	
		v2: a,
		
		selTbl: 'tblMood'
		
	});
	
	$( "#dm" ).html(a);
	
}

function newEdit(a)
{

$( "#chg" ).html(a);

alert(a);

}

function ogset()
{
var oset = `<div id="linktbl"><table width="100%">
<tr><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../index.html')" value="Main" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../events/FormMobileJQ.php?link=1')" value="Mobile" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../events/JQEvent.php?link=1')" value="Event" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../events/FormDynamicJS.php?link=1')" value="Dynamic" />

</td><td width="20%">		
		
<input type="button" class = "link" onclick="LoadDiv('form', '../past/FormJQPast.php?link=1')" value="Past" />
		
</td></tr><tr><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../events/FormLocalEvent.php?link=1')" value="Local" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../events/FormMorningJS.php?link=1')" value="Morning" />
		
</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../events/FormEveningJS.php?link=1')" value="Evening" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../events/FormSocialJQ.php?link=1')" value="Social" />

</td><td width="20%">
		
<input type="button" class="link" onclick="location.href='../add/AddPrior.php?form=http://mltimedb.x10host.com/form/FormAll.php'" value="Prior Event" />
		
</td></tr><tr><td width="20%">
		
<input type="button" class = "link" onclick="moreBtn()" value="More" />

</td><td width="20%">	
		
<input type="button" class = "link" onclick="LoadDiv('form', '../mood/JQMoodEntry.php?link=1&I=90')" value="Mood" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../weight/JQWeightEntry.php?link=1')" value="Weight" />

</td><td width="20%">
		
<input type="button" class = "link" onclick="LoadDiv('form', '../food/JSFoodEvents.php?link=1')" value="Food" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../events/FormMultiUpdate.php?link=1')" value="Multi" />

</td> </tr></table></div>`;
	
$( "#linktbl" ).replaceWith(oset);
	
}

function moreBtn()
{
var newset = `<div id="linktbl"><table width="100%">
<tr><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../index.html')" value="Main" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../view/ViewSpecDays.php?link=1')" value="Day" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../time/FormTimeUse.php?link=1')" value="Time Use" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../view/ViewLifeClock.php?link=1')" value="Clock" />

</td><td width="20%">		

<input type="button" class = "link" onclick="LoadDiv('form', '../goals/FormDailyGoalsJQ.php?link=1')" value="Goals" />

</td></tr><tr><td width="20%">

<input type="button" class = "link" onclick="ogset()" value="Back" />

</td><td width="20%">
		
<input type="button" class = "link" onclick="LoadDiv('form', '../menu/MenuMod.htm')" value="Modify" />
		
</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../events/FormEventInfo.php?link=1')" value="Events" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../sch/FormJQSch.php?link=1')" value="Sched" />

</td><td width="20%">

<input type="button" class = "link" onclick="LoadDiv('form', '../ct/FormCTSocial.php?link=1')" value="Convo" />

</td></tr></table></div> `;

$( "#linktbl" ).replaceWith(newset);

}

</script>

	</head>
	<body>
	<div id="linktbl">
	</div>

<hr />
<div id='mood' style="width: 35%; height: 50px; float:left">
<table width=100%>
	<tr>
		<td>
			<input type="button" class = "link" onclick="AddMood1(-1)" value="-1" />
		</td> <td>
			<input type="button" class = "link" onclick="AddMood1(-0.5)" value="-0.5" />
		</td> <td>
			<input type="button" class = "link" onclick="AddMood1(0)" value="0" />
		</td> <td>
			<input type="button" class = "link" onclick="AddMood1(0.5)" value="0.5" />
		</td> <td>
			<input type="button" class = "link" onclick="AddMood1(1)" value="1" />
		</td>
		<td><div id="dm"></div></td>
	</tr>
</table>
<p id="chg"></p>
</div>
<div id='CSE' style="width: 64%; position: relative; float:left; height:100px">
<?php
//view current sched event
include("../sch/ViewCurSchEvent.php");
?>
</div>
<div id="form" style="width: 100%"></div>
<script defer>
$( document ).ready(function() {

	LoadDiv('form', '../events/FormMobileJQ.php?link=1');
	
	ogset();
	
});

</script>
</body>
</html>