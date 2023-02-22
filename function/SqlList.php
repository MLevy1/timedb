<?php
include('../function/Functions.php');

setQTime();

//set sql query to list all events ordered by STime
$sqlAllEvents = "SELECT * FROM tblEvents
    INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID ORDER BY Stime";

//Query containing all events with selected Cont
$sqlselCont = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc, tblTest.col2 FROM tblEvents INNER JOIN tblTest ON tblEvents.StartTime = tblTest.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblEvents.ProID = '$selCont'";

//Query containing all events with selected Act
$sqlselAct = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc, tblTest.col2 FROM tblEvents INNER JOIN tblTest ON tblEvents.StartTime = tblTest.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblEvents.ActID = '$selAct'";

//Query containing all events with selected ContID and selected ActID
$sqlselActCont = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc, tblTest.col2 FROM tblEvents INNER JOIN tblTest ON tblEvents.StartTime = tblTest.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblEvents.ActID = '$selAct' AND tblEvents.ProID = '$selCont'";

//Lists all events on the a given day
$sqlDailyEvents = "SELECT * FROM tblEvents INNER JOIN tblCont ON (tblEvents.ProID=tblCont.ContID) INNER JOIN tblAct ON (tblEvents.ActID=tblAct.ActID) INNER JOIN tblProj ON (tblCont.ProjID = tblProj.ProjID) WHERE date(tblEvents.STime) ='$QTime' ORDER BY tblEvents.STime";

$sqlWeekPick = "SELECT DISTINCT DATE(STime) AS QDate FROM tblEvents WHERE WEEKDAY(tblEvents.STime)=0 ORDER BY STime DESC";

$sqlThisWeek = "SELECT DISTINCT DATE(STime) AS QDate FROM tblEvents WHERE WEEKDAY(tblEvents.STime)=0 ORDER BY STime DESC LIMIT 1";

$sqlDayPick = "SELECT DISTINCT DATE(STime) AS QDate FROM tblEvents WHERE DATE(STime) is not null ORDER BY STime";

$sqlCol1Totals = "SELECT col1, SUM(col2) AS scol FROM tblTest GROUP BY col1 ORDER BY scol DESC";

if (!function_exists('sqlBetStartEnd')){
    function sqlBetStartEnd($SDate, $EDate){

        global $sqlBetStartEnd;

        $sqlBetStartEnd = "SELECT * FROM tblEvents INNER JOIN tblAct ON (tblEvents.ActID = tblAct.ActID) INNER JOIN tblCont ON (tblEvents.ProID = tblCont.ContID) INNER JOIN tblProj ON (tblCont.ProjID = tblProj.ProjID) WHERE date(tblEvents.STime) BETWEEN '$SDate' AND '$EDate' ORDER BY tblEvents.STime";
    }
}

if (!function_exists('sqlFirstofNext')){
    function sqlFirstofNext($EDate){

        global $sqlFirstofNext;

        $sqlFirstofNext = "SELECT * FROM tblEvents INNER JOIN tblAct ON (tblEvents.ActID=tblAct.ActID) INNER JOIN tblCont ON (tblEvents.ProID = tblCont.ContID) INNER JOIN tblProj ON (tblCont.ProjID = tblProj.ProjID) WHERE date(tblEvents.STime) ='$EDate' ORDER BY tblEvents.STime LIMIT 1";
    }
}

if (!function_exists('cleartbl')) {
    function cleartbl($tbl) {
        $clear = 'TRUNCATE TABLE '.$tbl;
    }
}

$sqlAllConvoCnt = "SELECT DISTINCT(CONCAT(tblCont.ContID, tblCTTopic.CTTOP)) as C1, tblCont.ContDesc, tblCTTopic.CTTopic, COUNT(*) AS CNT FROM `tblConvos` INNER JOIN `tblCTTopic` ON tblConvos.CTTopic = tblCTTopic.CTTOP INNER JOIN tblCont ON tblConvos.ContID = tblCont.ContID GROUP BY C1 ORDER BY CNT DESC";

if (!function_exists('sqlDGBetStartEnd')){
    function sqlDGBetStartEnd($SDate, $EDate){

        global $sqlDGBetStartEnd;

        $sqlDGBetStartEnd = "SELECT * FROM tblNewDailyGoals INNER JOIN tblGoalOptions ON (tblNewDailyGoals.Goal = tblGoalOptions.GoalID) INNER JOIN tblCont ON (tblNewDailyGoals.ContID = tblCont.ContID) INNER JOIN tblProj ON (tblCont.ProjID = tblProj.ProjID) WHERE date(tblNewDailyGoals.GDate) BETWEEN '$SDate' AND '$EDate' ORDER BY tblNewDailyGoals.Goal, tblNewDailyGoals.Result";
    }
}

?>