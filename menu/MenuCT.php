<?php
include("../function/Functions.php");
?>
<link rel="stylesheet" href="../../styles.css" />

<?php
$dir    = '../ct';
$files1 = scandir($dir);
$files2 = scandir($dir, 1);

$rowcount=count($files1);

$rowcounter = 2;
?>

<ul>
<?php
while ($rowcounter<=$rowcount){
	echo "<li>";
	echo '<a href="../ct/'.$files1[$rowcounter].'">'.$files1[$rowcounter].'</a>';
	echo "</li>";
 	$rowcounter++;
}
?>
</ul>