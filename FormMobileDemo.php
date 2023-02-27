<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="styles.css" />
	</head>
	<body>
		<h1>Event Entry</h1>
		<form action="./add/AddEvent.php" method="get">
			<table>
			<tr>
				<td>
					<button name='btn_submit' value='B01 PERSONAL.2' type='submit'>BR</button>
				</td><td>
					<button name='btn_submit' value='P09 PERSONAL.2' type='submit'>Brush Teeth</button>
				</td><td>
					<button name='btn_submit' value='P20 PERSONAL.2' type='submit'>Dress</button>
				</td><td>
					<button name='btn_submit' value='P29 PERSONAL.2' type='submit'>Shower</button>
				</td>
			</tr>
		</table>
	</form>

	<?php
	$conn = mysqli_connect('localhost', 'root', '1234567a', 'tdb');

	date_default_timezone_set('America/New_York');

	$QTime = date('Y-m-d');
	$NowTime = date("Y-m-d H:i:s");

	$QT1 = date( "Y-m-d", strtotime( "$QTime -1 day" ) );

	$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.ActID, tblEvents.ProID, tblAct.ActDesc, tblCont.ContDesc FROM tblEvents
	INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE date(tblEvents.STime) >='$QT1' ORDER BY Stime DESC";

	$result = mysqli_query($conn, $sql);

	$data = array();

	$data[0][] = $NowTime;
	$data[1][] = date_create($NowTime);

	while ($row = mysqli_fetch_array($result)) {

		$data[0][] = $row['STime'];
		$data[1][] = date_create($row['STime']);
		$data[2][] = $row['ActDesc'];
		$data[3][] = $row['ContDesc'];
		$data[4][] = $row['StartTime'];

	}

	mysqli_close($conn);

	$cnt= count ($data[4]);

	?>
	<table>
		<th>Start</th>
		<th>Act</th>
		<th>Cont</th>
		<th>Time</th>
		<?php
			for($x = 0; $x < ($cnt); $x++) {
				echo "<tr><td>".
				date_format($data[1][$x+1], 'h:i A').
				"</td><td>".
				$data[2][$x].
				"</td><td>".
				$data[3][$x].
				"</td><td>".
				$data[1][$x]->diff($data[1][$x+1])->format('%i minutes').
				"</td></tr>";
			}
		?>
		</table>
	</body>
</html>