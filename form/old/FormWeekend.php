<?php
include("../function/password_protect.php");
include("../function/sqlSelect.php");
?>
<html>
<head>
	<title>Mobile Entry Form - Weekend</title>
	<link rel="stylesheet" href="../../styles.css" />
</head>
<h1>Weekend</h1>
<?php include("../view/LinkTable.php"); ?>
<form method="get" action="../add/AddMobileEvent.php">
<table width=100%>
<tr>
    <td><?php eventbtn('B01 PERSONAL.2', 'BR'); ?></td>
    <td><?php eventbtn('P09 PERSONAL.2', 'Brush Teeth'); ?></td>
    <td><?php eventbtn('P20 PERSONAL.2', 'Get Dressed'); ?></td>
    <td><?php eventbtn('P29 PERSONAL.2', 'Shower'); ?></td>
</tr><tr>
    <td><?php eventbtn('N02 AD', 'Drive (AD)'); ?></td>
    <td><?php eventbtn('N04 NA', 'Bed'); ?></td>
    <td><?php eventbtn('N03 AD', 'TV (AD)'); ?></td>
    <td><?php eventbtn('P30 AD', 'Walk (AD)'); ?></td>
</tr><tr>
    <td><?php eventbtn('SO5 AD', 'Breakfast (AD)'); ?></td>
    <td><?php eventbtn('S03 AD', 'Lunch (AD)'); ?></td>
    <td><?php eventbtn('S07 AD', 'Dinner (AD)'); ?></td>
    <td><?php eventbtn('S09 AD', 'Events (AD)'); ?></td>
</tr><tr>
    <td><?php eventbtn('S01 AD', 'Social (AD)'); ?></td>
    <td><?php eventbtn('S11 AD', 'Pool (AD)'); ?></td>
    <td><?php eventbtn('S12 AD', 'Beach (AD)'); ?></td>
    <td><?php eventbtn('S10 AD', 'Shopping (AD)'); ?></td>
</tr><tr>
    <td><?php eventbtn('P30 Dog', 'Walk (Dog)'); ?></td>
    <td><?php eventbtn('P42 Dog', 'Run'); ?></td>
    <td><?php eventbtn('P32 PERSONAL.2', 'Pack'); ?></td>
    <td><?php eventbtn('P40 PERSONAL.2', 'Gas'); ?></td>
</tr><tr>
    <td><?php eventbtn('L14 PROG.3', 'Web Development'); ?></td>
    <td><?php eventbtn('P01 TIMEDB.0', 'Database'); ?></td>
    <td><?php eventbtn('L15 News', 'News'); ?></td>
    <td><?php eventbtn('B06 BREAK', 'Coffee / Water / Tea'); ?></td></tr>
</table>
<input type="hidden" name="formcode" value="5">
</form>
<?php include("../view/FooterEventQueries.php"); ?>
</body>
</html>
