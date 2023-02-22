<html>
<head>
	<title>Morning Schedule</title>
</head>
<body>
<h1>Morning Schedule</h1>
<?php include('LinkTable.php'); ?>
<?php include('sqlSelect.php'); ?>
<table>
<tr><td>
Date:
</td><td>
<input name="selDate" type="date">
</td></tr><tr><td>
6:00-6:14
</td><td>
<?php addsel('sela01', 'ActDesc', 'tblAct'); ?>
</td><td>
<?php addsel('selp01', 'ProjDesc', 'tblProj'); ?>
</td></tr><tr><td>
6:15-6:29
</td><td>
<?php addsel('sela02', 'ActDesc', 'tblAct'); ?>
</td><td>
<?php addsel('selp02', 'ProjDesc', 'tblProj'); ?></td></tr><tr><td>
6:30-6:44
</td><td>
<?php addsel('sela03', 'ActDesc', 'tblAct'); ?></td><td>
<?php addsel('selp03', 'ProjDesc', 'tblProj'); ?>
</td></tr><tr><td>
6:45-7:59
</td><td>
<?php addsel('sela04', 'ActDesc', 'tblAct'); ?></td><td>
<?php addsel('selp04', 'ProjDesc', 'tblProj'); ?>
</td></tr><tr><td>
8:00-8:14
</td><td>
<?php addsel('sela05', 'ActDesc', 'tblAct'); ?></td><td>
<?php addsel('selp05', 'ProjDesc', 'tblProj'); ?>
</td></tr><tr><td>
8:15-8:29
</td><td>
<?php addsel('sela06', 'ActDesc', 'tblAct'); ?></td><td>
<?php addsel('selp06', 'ProjDesc', 'tblProj'); ?>
</td></tr><tr><td>
8:30-8:44
</td><td>
<?php addsel('sela07', 'ActDesc', 'tblAct'); ?></td><td>
<?php addsel('selp07', 'ProjDesc', 'tblProj'); ?>
</td></tr><tr><td>
8:45-8:59
</td><td>
<?php addsel('sela08', 'ActDesc', 'tblAct'); ?></td><td>
<?php addsel('selap08', 'ProjDesc', 'tblProj'); ?>
</td></tr><tr><td>
9:00-9:14
</td><td>
<?php addsel('sela09', 'ActDesc', 'tblAct'); ?></td><td>
<?php addsel('selap09', 'ProjDesc', 'tblProj'); ?>
</td></tr><tr><td>
9:15-9:29
</td><td>
<?php addsel('sela10', 'ActDesc', 'tblAct'); ?></td><td>
<?php addsel('selp10', 'ProjDesc', 'tblProj'); ?>
</td></tr><tr><td>
9:30-9:44
</td><td>
<?php addsel('sela11', 'ActDesc', 'tblAct'); ?></td><td>
<?php addsel('selp11', 'ProjDesc', 'tblProj'); ?>
</td></tr><tr><td>
9:45-9:59
</td><td>
<?php addsel('sela12', 'ActDesc', 'tblAct'); ?></td><td>
<?php addsel('selp12', 'ProjDesc', 'tblProj'); ?>
</td></tr>
</table>	
</body>
</html>