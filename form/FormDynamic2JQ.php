<html>
<head>
<link href="../../styles.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../function/JSFunctions.js"></script>


<?php
include("../function/phpHeader.php");
?>

</head>
<body>
<h1>JQDynamic2</h1>
<?php include('../view/LinkTable.php'); ?>

<div id = "qurey">
<?php
include('qryDynamic2JQ.php');
?>
</div>

<div id ="buttons">

<?php 

include ('../view/btnSetJDyn.php'); 

?>

</div>

<a href="javascript:UpdateEvents();">Update Events</a>

<div id="vtest">
<?php include ('../view/FooterEventQueries.php'); ?>
</div>
</body>
</html>