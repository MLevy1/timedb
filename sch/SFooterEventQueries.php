<hr />
<?php

$selDate = $_REQUEST["selDate"];

if($selDate==null){
$selDate = date('Y-m-d');
}

include("../sch/ViewHTUSch.php"); 
?>

<?php  include("../sch/ViewSchedEvents.php"); ?>
<hr />
<table>
    <tr><td>
    <?php include("../sch/ViewSActDur.php"); ?>
    </td><td>
    <?php 
    include("../sch/ViewSContDur.php"); 
    include("../sch/ViewCompPCodes.php");
    ?>
    </td><td>
    <?php 
    include("../sch/ViewSProjDur.php"); 
    include("../sch/ViewSPCodes.php"); 
   
    ?>
    
    </td></tr>
</table>
<hr />