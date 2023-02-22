<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/password_protect.php");
include("../function/Functions.php");

formid();
?>
<html>
<head>
	<title>Mobile Entry Form</title>
	<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<h1>Mobile</h1>

<?php include("../view/LinkTable.php"); ?>

<form action="../add/AddEvent.php" method="get">

<?php include ("../view/btnSet.php"); ?>

<input type="hidden" name="form" value="<?php echo $form; ?>">

</form>

<?php include("../view/FooterEventQueries.php"); ?>

</body>
</html>
