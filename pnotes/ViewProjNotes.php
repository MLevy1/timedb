<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");

pconn();

$data = array();

$varSQL = $_GET["selSQL"];

if($selProj==NULL){

//START

	if ($varSQL == NULL) {

		$varSQL = "SELECT * FROM tblProjNotes INNER JOIN tblCont ON tblProjNotes.ContID=tblCont.ContID WHERE Open != 'N'";

	}else
	{

		switch ($varSQL) {

	    //Query containing all events (#1)

	        case "A":

				$varSQL = "SELECT * FROM tblProjNotes INNER JOIN tblCont ON tblProjNotes.ContID=tblCont.ContID WHERE Open != 'N'";

	            break;

	    //Query containing all events with selected ContID (#2)

	        case "I":
	            
	            $varSQL = "SELECT * FROM tblProjNotes INNER JOIN tblCont ON tblProjNotes.ContID=tblCont.ContID WHERE Open = 'N'";

	            break;

	    //Query containing all events with selected ContID (#3)

	        case "All":
	            
	            $varSQL = "SELECT * FROM tblProjNotes INNER JOIN tblCont ON tblProjNotes.ContID=tblCont.ContID";

	            break;     
		}
	}
}

else{

$varSQL = "SELECT * FROM tblProjNotes 
INNER JOIN tblCont ON tblProjNotes.ContID=tblCont.ContID
WHERE tblCont.ProjID = 'selProj'";

}

$result = mysqli_query($conn, $varSQL);

while($row = mysqli_fetch_assoc($result)) {

    	$data[0][]=$row["NoteID"];
    	$data[1][]=$row["NoteTime"];
    	$data[2][]=$row["Note"];
    	$data[3][]=$row["ContDesc"];
    	$data[4][]=date_create($row["NoteTime"]);

}

$cnt=count($data[0]);
?>


<table width=100%>
<th>Time</th>
<th>Cont</th>
<th>Note</th>

<?php
for($x = 0; $x < ($cnt); $x++) {

       echo "<tr><td width=25% style='text-align:center'>";
       echo date_format($data[4][$x],"Y-m-d h:i A");
       echo "</td><td width=20% style='text-align:center'>";
       echo $data[3][$x];
       echo "</td><td width=45%>";
       echo $data[2][$x];
	echo "</td><td width=5%>";
       echo ("<input type=\"button\" class=\"link\" onclick=\"location.href='../pnotes/FormUpdateProjNote.php?selNote={$data[0][$x]}'\" value=\"U\"</input>");
       echo "</td><td width=5%>";
       echo ("<input type=\"button\" class=\"link\" onclick=\"location.href='../pnotes/FormProjNoteDetails.php?selNote={$data[0][$x]}'\" value=\"S\"</input>");
       echo "</td></tr>";
}

echo "</table>";

?>