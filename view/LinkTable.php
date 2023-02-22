<html>
	<head>
		<?php $page="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
		include("../function/Functions.php");
?>
<script src='../function/JSFunctions.js'></script>
	</head>
	<hr />
	<table>
		<tr><td width="17%">

		<input type="button" class="link" onclick="location.href='../index.html';" value="Main" />

		</td><td width="17%">

		<input type="button" class="link"  onclick="location.href='../form/FormAll.php';" value="All" />

		</td><td width="17%">

<input type="button" class="link"  onclick="location.href='../menu/MenuMod.htm';" value="Modify" />

		</td>
		
		<!--
		
		<td width="17%">

		<input type="button" class="link"  onclick="location.href='../events/FormMorningJS.php';" value="Morning" />

		</td><td width="17%">

		<input type="button" class="link"  onclick="location.href='../events/FormEveningJS.php';" value="Evening" />

		</td><td width="16%">		
		
		<input type="button" class="link"  onclick="location.href='../view/ViewSpecDays.php';" value="Day" />
		
		</td><td width="16%">

		<input type="button" class="link" onclick="location.href='../past/FormJQPast.php';" value="Past" />
		
		</td></tr><tr><td width="17%">

				<input type="button" class="link"  onclick="location.href='../view/ViewTimeUseChart.php';" value="Time Use"/>

		</td><td width="17%">

		<input type="button" class="link"  onclick="location.href='../view/ViewCFA.php';" value="CFA" />

		</td><td width="17%">

		<input type="button" class="link"  onclick="location.href='../mood/JQMoodEntry.php';" value="Mood" />

		</td><td width="17%">

		<input type="button" class="link"  onclick="location.href='../weight/JQWeightEntry.php';" value="Weight" />

		</td><td width="16%">
				
		<input type="button" class="link"  onclick="location.href='../food/JQFoodEvents.php';" value="Food" />
		
		</td><td width="16%">

		<input type="button" class="link" onclick="location.href='../add/AddPrior.php?form=<?php echo $page; ?>';" value="Prior Event" />

		</td></tr><tr><td width="16%">

		<input type="button" class="link"  onclick="location.href='../events/JQEvent.php';" value="Event" />

		</td><td width="17%">

		<input type="button" class="link"  onclick="location.href='../events/FormSocialJQ.php';" value="Social" />

		</td><td width="17%">

		<input type="button" class="link"  onclick="location.href='../events/FormDynamicJQ.php';" value="Dynamic" />

		</td><td width="17%">

				<input type="button" class="link"  onclick="location.href='../menu/MenuMod.htm';" value="Modify" />

		</td><td width="16%">

		<input type="button" class="link"  onclick="location.href='../view/Sleep.php';" value="Sleep" />

		</td><td width="16%">

		<input type="button" class="link"  onclick="location.href='../events/FormLocalEvent.php';" value="Local" />

		</td>
		
		-->
		
		</tr>
	</table>
	
<hr />
	
</html>
