<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");
?>
<link rel="stylesheet" href="../css/main.css" />
<h1>All Views Menu</h1>

<?php
$dir    = '../pnotes';
$files1 = scandir($dir);
$files2 = scandir($dir, 1);

$rowcount=count($files1);

$rowcounter = 2;
?>

<table>
<tr><td>
<?php
echo '<a href="../pnotes/'.$files1[1].'">Main Menu</a>';
?>
</td></tr>

<?php
while ($rowcounter<=$rowcount){
	echo "<tr><td>";
	echo '<a href="../pnotes/'.$files1[$rowcounter].'">'.$files1[$rowcounter].'</a>';
	echo "</td></tr>";
 	$rowcounter++;
}
?>
</table>