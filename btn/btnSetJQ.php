


<?php

header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

date_default_timezone_set('America/New_York');

?>



<table width=100%>
<tr>
    <td><?php eventbtnjq('B01', 'PERSONAL.2', 'BR', 'n', null); ?></td>
    <td><?php eventbtnjq('P09', 'PERSONAL.2', 'Brush Teeth', 'n', null); ?></td>
    <td><?php eventbtnjq('P33', 'PERSONAL.2', 'Shave & Hair', 'n', null); ?></td>   
    <td><?php eventbtnjq('P20', 'PERSONAL.2', 'Dress', 'n', null); ?></td>

</tr><tr>

    <td><?php eventbtnjq('N04', 'NA', 'Bed', 'n', null); ?></td>
    <td><?php eventbtnjq('P16', 'Dog', 'Dog', 'n', null); ?></td>
    <td><?php eventbtnjq('P29', 'PERSONAL.2', 'Shower', 'n', null); ?></td>
    <td><?php eventbtnjq('P32', 'PERSONAL.2', 'Pack', 'n', null); ?></td>
    
</tr><tr>

    <td><?php eventbtnjq('B07', 'PERSONAL.2', 'BR2', 'n', null); ?></td>
    <td><?php eventbtnjq('P60', 'PERSONAL.2', 'Floss', 'n', null); ?></td>
    <td><?php eventbtnjq('B06', 'BREAK', 'Beverage', 'n', null); ?></td>
    <td><?php eventbtnjq('P26', 'PERSONAL.1', 'JO', 'n', null); ?></td>
    
</tr><tr>

    <td><?php eventbtnjq('C06', 'CHC.R','Crying', 'n', null); ?></td>
    <td><?php eventbtnjq('C01', 'CHC.R','Diaper 1', 'n', null); ?></td>
    <td><?php eventbtnjq('C02', 'CHC.R','Diaper 2', 'n', null); ?></td>
    <td><?php eventbtnjq('C03', 'CHC.R','Feeding', 'n', null); ?></td>
    
</tr><tr>

    <td> <?php eventbtnjq('S07', 'AD', 'Meal (A)', 'n', null); ?> </td>
    <td><?php eventbtnjq('B02', 'PERSONAL.8', 'Eat', 'n', null); ?></td>
    <td> <?php eventbtnjq('P42', 'PERSONAL.4', 'Run', 'n', null); ?> </td>
    <td> <?php eventbtnjq('P63', 'PERSONAL.4', 'Meditate', 'n', null); ?> </td> </td>
    
</tr><tr>

    <td><?php eventbtnjq('N02', 'AD', 'Drive(A)', 'n', null); ?></td>
    <td><?php eventbtnjq('N02', 'TRANS.4', 'Drive(C)', 'n', null); ?></td>
   <td><?php eventbtnjq('N02', 'Dog', 'Drive (D)', 'n', null); ?></td>
    <td><?php eventbtnjq('N02', 'PERSONAL.5', 'Drive', 'n', null); ?></td>
    
</tr><tr>

    <td><?php eventbtnjq('P30', 'Family.6', 'Walk (A&D)', 'n', null); ?></td>
    <td><?php eventbtnjq('P30', 'TRANS.4', 'Walk(C)', 'n', null); ?></td>
    <td><?php eventbtnjq('P30', 'Dog', 'Walk (D)', 'n', null); ?></td>
    <td><?php eventbtnjq('P30', 'PERSONAL.4', 'Walk', 'n', null); ?></td>
    
</tr><tr>

    <td><?php eventbtnjq('P22', 'PERSONAL.3', 'Haircut', 'n', null); ?></td>
    <td><?php eventbtnjq('A02', 'ADMIN', 'Inbox', 'n', null); ?></td>
    <td><?php eventbtnjq('P43', 'PERSONAL.3', 'Home Repairs', 'n', null); ?></td>
    <td> <?php eventbtnjq('P48', 'PERSONAL.3', 'Clean Car', 'n', null); ?></td>
    
</tr><tr>

    <td><?php eventbtnjq('P01', 'TIMEDB.0', 'Database', 'n', null); ?></td>
    <td><?php eventbtnjq('P05', 'PERSONAL.A', 'Personal Admin', 'n', null); ?></td>
    <td><?php eventbtnjq('L16', 'News', 'News', 'n', null); ?></td>
    <td><?php eventbtnjq('P31', 'PERSONAL.4', 'Gym', 'n', null); ?></td>
    
</tr><tr>

    <td><?php eventbtnjq('N03', 'AD', 'TV (A)', 'n', null); ?></td>
    <td><?php eventbtnjq('S01', 'AD', 'Social (A)', 'n', null); ?></td>
    <td><?php eventbtnjq('P40', 'PERSONAL.5', 'Gas', 'n', null); ?></td>
    <td><?php eventbtnjq('P36', 'PERSONAL.7', 'Groceries', 'n', null); ?></td>
    
</tr><tr>

    <td><?php eventbtnjq('P35', 'PERSONAL.3', 'Dishes', 'n', null); ?></td>
    <td><?php eventbtnjq('P34', 'PERSONAL.3', 'Laundry', 'n', null); ?></td>
    <td><?php eventbtnjq('P41', 'PERSONAL.3', 'Trash', 'n', null); ?></td>
    <td><?php eventbtnjq('P11', 'PERSONAL.3', 'Clean House', 'n', null); ?></td>

</tr><tr>

    <td><?php eventbtnjq('S10', 'AD', 'Shopping(A)', 'n', null); ?></td>
    <td><?php eventbtnjq('S11', 'AD', 'Pool (A)', 'n', null); ?></td>
    <td><?php eventbtnjq('S12', 'AD', 'Beach (A)', 'n', null); ?></td>
    <td><?php eventbtnjq('S09', 'AD', 'Events (A)', 'n', null); ?></td>
</tr>
</table>

<?php

mysqli_close($conn);

?>