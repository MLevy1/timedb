<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/password_protect.php");
include("../function/Functions.php");

formid();
?>
<html>
<head>
<title>Dynamic</title>
<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<body>
<h1>Dynamic 2</h1>
<?php include("../view/LinkTable.php"); ?>

<form method='get' action='../add/AddEvent.php'>

<input type="hidden" name="form" value="<?php echo $form; ?>">

<?php
include("../view/btnSetDyn.php");
?>

</form>
<?php include("../view/FooterEventQueries.php"); ?>
</body>
</html>