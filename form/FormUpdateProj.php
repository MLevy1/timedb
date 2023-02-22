<?php
header("Cache-Control: no-cache, must-revalidate");

include ("../function/Functions.php");

pconn();
?>
<html>
<head>
    <title>Update Project</title>
    <link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<body>
<h1>Update Project</h1>
<?php
include("../view/LinkTable.php");

$selProj = $_REQUEST["selProj"];

$sql = "SELECT * FROM tblProj WHERE ProjID='$selProj'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) { 
	$defProjID = $row['ProjID'];
	$defProjDesc = $row['ProjDesc'];
	$defPCode = $row['PCode'];
	$defStatus = $row['ProjStatus'];
}
$conn->close();
?>
<form method="post" action="../update/UpdateProj.php">
<table width=100%>
<tr>
    <td style="vertical-align:middle"><b>
        Project ID:
    </td><td style="vertical-align:middle">
               <b><?php echo $defProjID; ?>
               <input type="hidden" name="selProjID" value='<?php echo $defProjID; ?>' ></input>
    </td>
    <td style="vertical-align:middle"><b>
        Project Desc:
    </td><td>
        <input name="newProjDesc" value= '<?php echo $defProjDesc; ?>' ></input>
    </td>
</tr><tr>
    <td style="vertical-align:middle"><b>
        Profile Code:
    </td><td>
        <input size='5' name="newPCode" value= '<?php echo $defPCode; ?>' ></input>
    </td>
    <td style="vertical-align:middle"><b>
        Project Staus:
    </td><td>
        <input name="newStatus" value= '<?php echo $defStatus; ?>' ></input>
    </td>
</tr><tr>
    <td>
    
      <input type="button" class="link" onclick="location.href='../form/FormProj.php';" value="Back" />
       
    </td><td>
    
	<input type="submit">
    
    </td>
</tr>
</form>
</table>
<hr />
<div id='VC'>
<?php include("../view/ViewContP.php"); ?>
</div>
<hr />
<div id='VN'>
<?php include("../view/ViewProjNotes.php"); ?>
</div>
</body>
</html>