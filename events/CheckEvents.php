<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');
?>

<script src='../function/JSFunctions1.js'></script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<?php
pconn();

setQTime();

$sql = "SELECT StartTime FROM tblEvents ORDER BY StartTime DESC";

$sql1 = "SELECT MoodDT FROM tblMood ORDER BY MoodDT DESC";

$result = mysqli_query($conn, $sql);

$data = array();
$mdata = array();

while ($row = mysqli_fetch_array($result)) {

	$data[] = substr($row['StartTime'], 0, 10)."T".substr($row['StartTime'], 11);
	
}

$result = mysqli_query($conn, $sql1);

while ($row = mysqli_fetch_array($result)) {

	$mdata[] = substr($row['MoodDT'], 0, 10)."T".substr($row['MoodDT'], 11);
}

mysqli_close($conn);
?>
<div style="width: 25%; float: left;">

<table>
	<th><b>Time</th>
<?php
foreach($mdata as $i) {
	echo "<tr><td>";
	
		echo $i;
	
	echo "</td></tr>";
}
?>
</table>
</div>
    <div style="width: 75%; float: right;"> 
<input type="button" class = "link" onclick="displayLEList()" value="Check" />
<select id="selData">
	<option value="E">Events</option>
	<option value="M">Moods</option>
</select>
<div id="demo"></div>
</div>
<script>
var data = <?php echo json_encode( $data ) ?>;

var mdata = <?php echo json_encode( $mdata ) ?>;

var LEList = JSON.parse(localStorage.getItem("LSEvents"));

var LMList = JSON.parse(localStorage.getItem("LSMoods"));

var ListLen = LEList.length;

var MListLen = LMList.length;

var cols =LEList[0].length;

var mcols =LMList[0].length;

var DLen = data.length;

var MDLen = mdata.length;

alert("Server: "+DLen+" Local: "+ListLen);

var text, i, b;

function displayLEList()
{
	var e = document.getElementById("selData");
	
var vdata = e.options[e.selectedIndex].value;
	
	text = "<table>";
	
	if(vdata=="M"){
	
		alert("Mood");
	
		for (i = 0; i < MListLen; i++) {
		
			if(mdata.includes(LMList[i][0]) == true){
		
			}else{
				text += "<tr>";
		
				text += "<td>";
	
				text += "N";
	
				text += "</td>";
		
				for(b=0; b<mcols; b++){
		
					text += "<td>" + LMList[i][b] + "</td>";
				}
				
				text += "<td>";
				
				text += 
		"<input type=button  value=+ class=slnk onclick=MPost('"+ LMList[i][1] + "','" + LMList[i][0] + "','" + i+"') + />";
		+ "</td><td>" ;
				
				text += "</td>";
			}
	
			text += "</tr>";
	
		}
	
	}else{
	
	for (i = 0; i < ListLen; i++) {
		
			if(data.includes(LEList[i][0]) == true){
		
			}else{
				text += "<tr>";
		
				text += "<td>";
	
				text += "N";
	
				text += "</td>"
		
				for(b=0; b<cols; b++){
		
					text += "<td>" + LEList[i][b] + "</td>";
				}
				
					text+= "<td><input type=button  value=+ class=slnk onclick='JQPost(`"+ LEList[i][1] + "`,`" + LEList[i][2] + "`,`" + LEList[i][0] + "`,`" + i+"`)'/></td>";
					
					
			}
	
			text += "</tr>";
	
		}
	
	}
	
	text += "</table>";
	
document.getElementById("demo").innerHTML = text;

alert("done");

}


function MPost(mood, dtime, i){

    $.post("../add/AddJQ.php",
    {
        v1: dtime,
        v2: mood,
        selTbl: 'tblMood'
    });
    
    alert("Mood added: "+ dtime);
    
}

function JQPost(act, cont, dtime, i){

    $.post("../add/AddJQ.php",
    {
        v1: act,
        v2: cont,
        v3: dtime,
        SD: 'L',
        selTbl: 'tblEvents'
	});
    
    alert("Event added: "+ dtime);
    
    LEList[i][4] = "Y";
    
    displayLEList();
}
</script>