<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../MobileStyle.css" />
<?php include ('../function/Functions.php');
include('../function/SqlList.php');

function ActDur($a, $daily, $start, $end){

    global $QTime;
    global $conn;
    global $NowTime;
    global $sqlDailyEvents;
    global $SDate;
    global $EDate;
    global $EDate2;
    global $sqlBetStartEnd;
    global $sqlFirstofNext;
    global $A;

    pconn();
    setQTime();
    
    if ($daily == "y"){  	    	
    	$result = mysqli_query($conn, $sqlDailyEvents);
    	$A = "y";
    }
    
    if ($daily == "n"){
    
    $SDate1 = date_create($start);
    $EDate1 = date_create($end);
    $EDate2A = date_create($end);
    
    $EDate = date_format($EDate1,"Y-m-d");
    $SDate = date_format($SDate1,"Y-m-d");
    //$EDate2 = date_format($EDate2A,"Y-m-d");
   
   if ($EDate != $QTime){
   date_add($EDate2A, date_interval_create_from_date_string("1 day"));
	$EDate2 = date_format($EDate2A,"Y-m-d");
	sqlFirstofNext($EDate2);
	$result2 = mysqli_query($conn, $sqlFirstofNext);
    }
    else
    {
    $A = "y";
    }
    sqlBetStartEnd($SDate, $EDate);
    
    $result = mysqli_query($conn, $sqlBetStartEnd);
    }
    
    if ($daily == "a"){
    
    $SDate1 = "2016-05-25";
    $SDate = date_format($SDate1,"Y-m-d");
    
    $EDate = date('Y-m-d');
    
    sqlBetStartEnd($SDate, $EDate);
    
    $result = mysqli_query($conn, $sqlBetStartEnd);
    }
    
    //Define first table array variables as arrays.
    $data = array();

    //Fills Stime, Act and Cont arrays with the results from the above query.
    while ($row = mysqli_fetch_array($result)) {
	$data[0][] = $row['STime'];
       $data[1][] = $row['ActDesc'];
       $data[2][] = $row['ProID'];
    }

    //Set array row counter variable to the number of rows in the query result.
    $cnt=((count ($data, COUNT_RECURSIVE))/count($data))-1;

if ($A == "y"){
    $data[0][] = $NowTime;
}

if ($daily == "n"){
    while ($row = mysqli_fetch_array($result2)) {
	$data[0][] = $row['STime'];
    }
}

    //Sets Dur array to the duration of each event in the query result.
    for($x = 0; $x < ($cnt); $x++) {
       $data[3][] = getmins($data[0][$x], $data[0][$x+1]);
    }
	//print_r ($data);
	//echo $A;
	//print_r ($result2);
	//echo $EDate2;
    $arrTest = array();

    //Sets the variable used to hold the sql statement to truncate the table.
    $clear = 'TRUNCATE TABLE tblTestA';

    //Clears tblTest (table used to render query results)
    mysqli_query($conn, $clear);

    //Set query variable to the first half of the insert query statement.
    $query = "INSERT INTO tblTestA (`col1`, `col2`) VALUES ";

    //Create the contents of the second half of the insert query statement using the arrTest array.
    for($x=0; $x<($cnt); $x++){
        $arrTest[] = "('" . $data[1][$x] . "', '" .  $data[3][$x] . "')";
    }

    //Create the insert query statement by implding the first and second halves (as created in the above sections).
    $sql = $query .= implode(',', $arrTest);

    mysqli_query($conn, $sql);

    $b = $a;

    $sumq = "SELECT col1, SUM(col2) AS scol FROM tblTestA WHERE col1='$b' GROUP BY col1 ORDER BY scol DESC";

    $data2 = array();

    $result = mysqli_query($conn, $sumq);

    mysqli_close($conn);

    while ($row = mysqli_fetch_array($result)) {
        $data2[0][] = $row['col1'];
        $data2[1][] = $row['scol'];
    }

    $c = $data2[1][0];
    
	if(isset($c)){
		return $c;
	}
	else {
		return 0;
	}
}
?>