<?php $page="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
?>
<table style='text-align:center' width='100%'>
<tr>
	<td width="33.3%">
		<input type="button" class="link" onclick="location.href='../form/FormPastEventMobile.php?form=<?php echo $page; ?>';" value="Past" />
	</td>
	<td width="33.3%">	
		<input type="button" class="link" onclick="location.href='../add/AddPrior.php?form=<?php echo $page; ?>';" value="Prior Event" />
	</td>
	<td width="33.4%">
		<input type="button" class="link" onclick="location.href='../form/FormUpdateEvent0.php?form=<?php echo $page; ?>';" value="Update" />
	</td>
</tr>
</table>