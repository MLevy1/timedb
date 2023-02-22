<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');
include('../function/SqlList.php');


if (!function_exists('EventList')) {
    function EventList() {
    
        //Declare Global variables.
        global $QTime;
        global $NowTime;
        global $data;
        global $conn;
        global $sqlAllEvents;
        global $cnt;

        pconn();

        formid();

        setQTime();

        //set result variable to hold contents of sql query
        $result = mysqli_query($conn, $sqlAllEvents);

        $arrEvent = array();

        //fill STime, Act, and Cont arrays
        while ($row = mysqli_fetch_array($result)) {
            $arrEvent[0][] = $row['STime'];
            $arrEvent[1][] = date_create($row['STime']);
            $arrEvent[2][] = $row['ActDesc'];
            $arrEvent[3][] = $row['ContID'];
            $arrEvent[4][] = $row['ContDesc'];
        }

        //count rows in results arrays
        $cnt = ((count ($arrEvent, COUNT_RECURSIVE))/count($arrEvent))-1;

	$arrEvent[0][] = $NowTime;
	$arrEvent[1][] = date_create($NowTime);


        //fill Dur, Hrs, and Mins arrays
        for($x = 0; $x < ($cnt); $x++) {
            $arrEvent[5][] = getmins($arrEvent[0][$x], $arrEvent[0][$x+1]);
        }
        return $arrEvent;
    }
}

if (!function_exists('Actarr')) {
	function Actarr(){
		global $conn;
		
		pconn();
		
		$sql = "SELECT * FROM tblAct WHERE Status!='Inactive' ORDER BY ActID";
		
		$result = mysqli_query($conn, $sql);

        	$arrAct = array();
        	
        	while ($row = mysqli_fetch_array($result)) {
            $arrAct[0][] = $row['ActID'];
            $arrAct[1][] = $row['ActDesc'];
        }
        	return $arrAct;
	}
}

if (!function_exists('Contarr')) {
	function Contarr(){
		global $conn;
		
		pconn();
		
		$sql = "SELECT * FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE tblProj.ProjStatus!='Closed' AND tblCont.Active!='N' ORDER BY tblCont.ProjID, tblCont.ContID";
		
		$result = mysqli_query($conn, $sql);

        	$arrCont = array();
        	
        	while ($row = mysqli_fetch_array($result)) {
            $arrCont[0][] = $row['ProjID'];
            $arrCont[1][] = $row['ProjDesc'];
            $arrCont[2][] = $row['ContID'];
            $arrCont[3][] = $row['ContDesc'];
        }
        	return $arrCont;
	}
}


if (!function_exists('Acttbl')) {
	function Acttbl($Act, $Event){
	
		global $conn;
		global $cnt;
		
		pconn();
		
		$arrAct = array();
		$arrEvent = array();
		
		$arrAct = $Act;
		$arrEvent = $Event;
		
		foreach ($arrAct[1] as $A){
			$ATime = 0;
			for($x = 0; $x < ($cnt); $x++) {
				if ($A == $arrEvent[2][$x]) {
					$ATime = $ATime + $arrEvent[5][$x];
			}
			}
			echo "<tr><td>";
			echo $A;
			echo "</td><td>";
			echo $ATime;
			echo "</td></tr>";
		}
	}
}


if (!function_exists('Conttbl')) {
	function Conttbl($Cont, $Event){
	
		global $conn;
		global $cnt;
		
		pconn();
		
		$arrCont = array();
		$arrEvent = array();
		
		$arrCont = $Cont;
		$arrEvent = $Event;
		
		foreach ($arrCont[2] as $C){
			$CTime = 0;
			for($x = 0; $x < ($cnt); $x++) {
				if ($C == $arrEvent[3][$x]) {
					$CTime = $CTime + $arrEvent[5][$x];
			}
			}
			echo "<tr><td>";
			echo $C;
			echo "</td><td>";
			echo $CTime;
			echo "</td></tr>";
		}
	}
}

echo "<pre>";
//print_r (Contarr());
echo "</pre>";

echo "<table>";
Conttbl (Contarr(), EventList());
echo "</table>";

echo "end";
?>