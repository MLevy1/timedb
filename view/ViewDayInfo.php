<?php header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');

//9/22/16 first day

pconn();

formid();

setQTime();

//Setup query containing all dates

$qryDates = "SELECT DISTINCT DATE( STime ) AS D, WEEKDAY( DATE( STime ) ) AS WD, 
Type 
FROM tblEvents
LEFT JOIN tblDateInfo ON DATE( tblEvents.STime ) = tblDateInfo.Date1
WHERE DATE( STime ) >= CAST(  '2016-09-22' AS DATE ) 
AND STime IS NOT NULL 
ORDER BY STime DESC";

//Setup query contains all dates where a commute happened

$qryCmt = "SELECT DISTINCT DATE(STime) AS D FROM tblEvents WHERE (ProID='TRANS.1' OR ProID='TRANS.2' OR ProID='TRANS.3' OR ProID='TRANS.4' OR ProID='TRANS.5') AND DATE(STime)>=CAST('2016-09-22' AS DATE) AND STime is not Null";

//Setup query containing all dates when work was completed or a meeting occured

$qryWork = "SELECT DISTINCT DATE(STime) AS D, tblAct.UCode 
FROM tblEvents 
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID) 
WHERE (tblAct.UCode='W' OR tblAct.UCode='M') AND DATE(STime)>=CAST('2016-09-22' AS DATE)";

//setup query containing all specially designated dates

$qrySDays = "SELECT * FROM tblDateInfo";

//set result variable to hold contents of sql query
    //Run above queries

	$resDates = mysqli_query($conn, $qryDates);

	$resCmt = mysqli_query($conn, $qryCmt);
	
	$resWork = mysqli_query($conn, $qryWork);
	
	$resSDays = mysqli_query($conn, $qrySDays);

//Setup result arrays

    	$arrDates = array();
    	$arrCmt = array();
    	$arrWork = array();
    	$arrSDays = array();
    	$arrTest = array();

//Fill results arrays
    while ($row = mysqli_fetch_array($resDates)) {
        $arrDates[0][] = $row['D'];
        $arrDates[1][] = $row['WD'];
        $arrDates[2][] = $row['Type'];
    }

   
    //count rows in results arrays
    $cnt = count ($arrDates[0]);
   	
    while ($row = mysqli_fetch_array($resCmt)) {
        $arrCmt[] = $row['D'];
    }

	while ($row = mysqli_fetch_array($resWork)) {
        $arrWork[] = $row['D'];
    }

	while ($row = mysqli_fetch_array($resSDays)) {
        $arrSDays[0][] = $row['Date1'];
        $arrSDays[1][] = $row['Type'];
    }

//Free result variables

mysqli_free_result($resDates);
mysqli_free_result($resCmt);
mysqli_free_result($resWork);
mysqli_free_result($resSDates);
?>

<table width=100%>
	<th>Date</th>
	<th>WKDay No Cmt</th>
	<th>Wk Proj</th>
	<th>Code</th>
	
<?php
	
	for($x = 0; $x < ($cnt); $x++) {
		
		echo "<tr><td width=30% align='center'>";
		
		echo date_format(date_create($arrDates[0][$x]),"D m-d-y");
		$arrTest[0][]=$arrDates[0][$x];
		
		echo "</td><td align='center'>";
		
		if($arrDates[1][$x]>4){
			echo "0";
			$arrTest[1][]=0;
		}
		
		elseif($arrDates[2][$x]==="O"){
			echo "0";
			$arrTest[1][]=0;
		}
	
		else
		{
			
			echo "1";
			$arrTest[1][]=1;
		}
		
		echo "</td><td align='center'>";
		
		if (in_array($arrDates[0][$x], $arrWork))
  		{
  			echo "1";
  			$arrTest[3][]=1;
		}
		else
		{
		echo "0";
		$arrTest[3][]=0;
		}
		
		echo "</td><td align='center'>";

		//Day Type
		
		if (in_array($arrDates[0][$x], $arrSDays[0]))
  		{
  			echo $arrDates[2][$x];
  			//$arrTest[3][]=1;
		}
		else
		{
		//echo "N";
		//$arrTest[3][]=0;
		}
		
		echo "</td><td>";

		//Details Button
		
		$page = "../view/ViewDailyEvents.php?selQDate=". $arrDates[0][$x];

		echo ("<input type=\"button\" class=\"link\" onclick=\"location.href='$page';\" value=\"Det\" </input>");

		echo "</td><td>";

		//Vacation Button
		
		echo ("<input type=\"button\" class=\"link\" onclick=\"btnJQDate('{$arrDates[0][$x]}','O') 
       \" value=\"PTO\"</input>");
      

		echo "</td><td>";

		//WFH Button
		
		echo ("<input type=\"button\" class=\"link\" onclick=\"btnJQDate('{$arrDates[0][$x]}','H') 
       \" value=\"WFH\"</input>");

		echo "</tr>";
		
}

mysqli_close($conn);
?>
</table>
<?php 
echo "Total Work Days: ";
echo array_sum($arrTest[1]);
?>