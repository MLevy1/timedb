<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

date_default_timezone_set('America/New_York');

$tbl = 'tblEvents';

if (!function_exists('eventbtnjqs')) {
function eventbtnjqs($act, $cont, $btnname, $tbl){
    
    $btnid0 = $act.$cont.'B';
    
    $btnid = preg_replace("/[^a-zA-Z0-9]/", "", $btnid0);
    
    echo "<button id='$btnid' onclick=\"btnJQs('$act', '$cont', '$btnid', '$tbl', '$dtime')\">$btnname</button>";
}
}

?>

<table width=100%>
<tr>
    <td><?php eventbtnjqs('B01', 'PERSONAL.2', 'BR', $tbl); ?></td>
    <td><?php eventbtnjqs('P09', 'PERSONAL.2', 'Brush Teeth', $tbl); ?></td>
    <td><?php eventbtnjqs('P20', 'PERSONAL.2', 'Dress', $tbl); ?></td>
    <td><?php eventbtnjqs('P29', 'PERSONAL.2', 'Shower', $tbl); ?></td>
    
</tr><tr>

    <td><?php eventbtnjqs('N04', 'NA', 'Bed', $tbl); ?></td>
    <td><?php eventbtnjqs('P16', 'Dog', 'Dog', $tbl); ?></td>
    <td><?php eventbtnjqs('P33', 'PERSONAL.2', 'Shave & Hair', $tbl); ?></td>
    <td><?php eventbtnjqs('P32', 'PERSONAL.2', 'Pack', $tbl); ?></td>
    
</tr><tr>

    <td><?php eventbtnjqs('B02', 'PERSONAL.8', 'Breakfast', $tbl); ?></td>
    <td><?php eventbtnjqs('B02', 'BREAK', 'Breakfast (B)', $tbl); ?></td>
    <td><?php eventbtnjqs('B04', 'BREAK', 'Lunch (B)', $tbl); ?> </td>
    <td><?php eventbtnjqs('P14', 'PERSONAL.8', 'Dinner', $tbl); ?></td>
    
</tr><tr>

    <td><?php eventbtnjqs('N02', 'AD', 'Drive(A)', $tbl); ?></td>
    <td><?php eventbtnjqs('N02', 'TRANS.1', 'Drive(C)', $tbl); ?></td>
    <td><?php eventbtnjqs('P30', 'TRANS.1', 'Walk(C)', $tbl); ?></td>
    <td><?php eventbtnjqs('N02', 'PERSONAL.5', 'Drive', $tbl); ?></td>
    
</tr><tr>

    <td><?php eventbtnjqs('P30', 'PERSONAL.4', 'Walk', $tbl); ?></td>
    <td><?php eventbtnjqs('N02', 'DOG', 'Drive (D)', $tbl); ?></td>
    <td><?php eventbtnjqs('P30', 'Dog', 'Walk (D)', $tbl); ?></td>
    <td><?php eventbtnjqs('P42', 'Dog', 'Run', $tbl); ?></td>
    
</tr><tr>

    <td><?php eventbtnjqs('B01', 'BREAK', 'BR(B)', $tbl); ?></td>
    <td><?php eventbtnjqs('A02', 'ADMIN', 'Inbox', $tbl); ?></td>
    <td><?php eventbtnjqs('P49', 'PERSONAL.9', 'Air Travel', $tbl); ?></td>
    <td><?php eventbtnjqs('N01', 'NA', 'Untracked', $tbl); ?></td>

</tr><tr>

    <td><?php eventbtnjqs('P01', 'TIMEDB.0', 'Database', $tbl); ?></td>
    <td><?php eventbtnjqs('P05', 'PERSONAL.A', 'Personal Admin', $tbl); ?></td>
    <td><?php eventbtnjqs('L16', 'News', 'News', $tbl); ?></td>
    <td><?php eventbtnjqs('P47', 'PERSONAL.7', 'Online Shopping', $tbl); ?></td>
    
</tr><tr>

    <td><?php eventbtnjqs('B06', 'BREAK', 'Beverage', $tbl); ?></td>
    <td><?php eventbtnjqs('D07', 'PCD.6', 'Daily Review', $tbl); ?></td>
    <td><?php eventbtnjqs('P04', 'PFIN.00', 'Finances', $tbl); ?></td>
    <td><?php eventbtnjqs('P26', 'PERSONAL.1', 'JO', $tbl); ?></td>
    
</tr><tr>

    <td><?php eventbtnjqs('N03', 'AD', 'TV (A)', $tbl); ?></td>
    <td><?php eventbtnjqs('P40', 'PERSONAL.2', 'Gas', $tbl); ?></td>
    <td><?php eventbtnjqs('P36', 'PERSONAL.7', 'Groceries', $tbl); ?></td>
    <td><?php eventbtnjqs('P37', 'PERSONAL.3', 'Lawn & Garden', $tbl); ?></td>
    
</tr><tr>

    <td><?php eventbtnjqs('P35', 'PERSONAL.3', 'Dishes', $tbl); ?></td>
    <td><?php eventbtnjqs('P34', 'PERSONAL.3', 'Laundry', $tbl); ?></td>
    <td><?php eventbtnjqs('P41', 'PERSONAL.3', 'Trash', $tbl); ?></td>
    <td><?php eventbtnjqs('P11', 'PERSONAL.3', 'Clean House', $tbl); ?></td>

</tr><tr>

    <td><?php eventbtnjqs('S01', 'AD', 'Social (A)', $tbl); ?></td>
    <td><?php eventbtnjqs('S05', 'AD', 'Breakfast (A)', $tbl); ?></td>
    <td><?php eventbtnjqs('S03', 'AD', 'Lunch (A)', $tbl); ?></td>
    <td><?php eventbtnjqs('S07', 'AD', 'Dinner (A)', $tbl); ?></td>
    
</tr><tr>

    <td><?php eventbtnjqs('S10', 'AD', 'Shopping(A)', 'ShoppingA'); ?></td>
    <td><?php eventbtnjqs('S11', 'AD', 'Pool (A)', $tbl); ?></td>
    <td><?php eventbtnjqs('S12', 'AD', 'Beach (A)', $tbl); ?></td>
    <td><?php eventbtnjqs('S09', 'AD', 'Events (A)', $tbl); ?></td>
</tr>
</table>

<?php
mysqli_close($conn);
?>