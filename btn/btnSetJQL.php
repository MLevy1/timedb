<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");
?>

<table width=100%>
<tr>
    <td><?php eventbtnjql('B01', 'PERSONAL.2', 'Bathroom'); ?></td>
    <td><?php eventbtnjql('P09', 'PERSONAL.2', 'Brush Teeth'); ?></td>
    <td><?php eventbtnjql('P33', 'PERSONAL.2', 'Shave & Hair'); ?></td>   
    <td><?php eventbtnjql('P20', 'PERSONAL.2', 'Dress'); ?></td>
        
   </tr><tr>

    	<td><?php eventbtnjql('N04', 'NA', 'Bed'); ?></td>
    	<td><?php eventbtnjql('P16', 'Dog', 'Dog'); ?></td>
    	<td><?php eventbtnjql('P29', 'PERSONAL.2', 'Shower'); ?></td>
    	<td><?php eventbtnjql('P32', 'PERSONAL.2', 'Pack'); ?></td>
    
</tr><tr>

    	<td><?php eventbtnjql('W39', 'BPRM.01', 'Process Maps'); ?></td>
      	<td><?php eventbtnjql('W04', 'REP.02','Monthly Forum'); ?></td>
    	<td><?php eventbtnjql('W04', 'REP.01', 'Qtrly Report'); ?></td>
    	<td><?php eventbtnjql('W15', 'ISSUE.00', 'Issue Memo'); ?></td>
     
    </tr><tr>

   	<td><?php eventbtnjql('S01', 'ME', 'Social (M)'); ?></td>
      <td><?php eventbtnjql('S04', 'ME','Coffee (M)'); ?></td>
    	<td><?php eventbtnjql('S03', 'ME', 'Lunch (M)'); ?></td>
    	<td><?php eventbtnjql('P30', 'ME', 'Walk (M)'); ?></td>
    
</tr><tr>

	<td><?php eventbtnjql('P42', 'Dog', 'Run'); ?></td>
    	<td><?php eventbtnjql('B02', 'PERSONAL.8', 'Breakfast'); ?></td>
    	<td><?php eventbtnjql('B04', 'BREAK', 'Lunch (B)'); ?> </td>
    	<td><?php eventbtnjql('P14', 'PERSONAL.8', 'Dinner'); ?></td>
    
</tr><tr>

    <td><?php eventbtnjql('N02', 'Family.6', 'Drive(A&D)'); ?></td>
    <td><?php eventbtnjql('N02', 'TRANS.4', 'Drive(C)'); ?></td>
   <td><?php eventbtnjql('N02', 'DOG', 'Drive (D)'); ?></td>
    <td><?php eventbtnjql('N02', 'PERSONAL.5', 'Drive'); ?></td>
    
</tr><tr>

       <td><?php eventbtnjql('P30', 'Family.6', 'Walk (A&D)'); ?></td>
    <td><?php eventbtnjql('P30', 'TRANS.4', 'Walk(C)'); ?></td>
    <td><?php eventbtnjql('P30', 'Dog', 'Walk (D)'); ?></td>
     <td><?php eventbtnjql('P30', 'PERSONAL.4', 'Walk'); ?></td>


</tr><tr>
    
   	<td><?php eventbtnjql('P56', 'Family.6', 'Hiking(A&D)'); ?></td>
    	<td><?php eventbtnjql('P56', 'Family.3', 'Hiking(F)'); ?></td>
	<td><?php eventbtnjql('N02', 'Family.3', 'Drive (F)'); ?></td>
      <td><?php eventbtnjql('S05', 'Family.3', 'Breakfast(F)'); ?></td>
      
</tr><tr>

<td><?php eventbtnjql('S03', 'Family.3', 'Lunch (F)'); ?></td>
    <td><?php eventbtnjql('S07', 'Family.3', 'Dinner (F)'); ?></td>
    <td><?php eventbtnjql('B01', 'BREAK', 'BR(B)'); ?></td>
    <td><?php eventbtnjql('A02', 'ADMIN', 'Inbox'); ?></td>   
    
</tr><tr>

    <td><?php eventbtnjql('P01', 'TIMEDB.0', 'Database'); ?></td>
    <td><?php eventbtnjql('P05', 'PERSONAL.A', 'Personal Admin'); ?></td>
    <td><?php eventbtnjql('L16', 'News', 'News'); ?></td>
    <td><?php eventbtnjql('P31', 'PERSONAL.4', 'Gym'); ?></td>
    
</tr><tr>

    <td><?php eventbtnjql('B06', 'BREAK', 'Beverage'); ?></td>
    <td><?php eventbtnjql('S13', 'Family.3', 'Bar (Family)'); ?></td>
    <td><?php eventbtnjql('P04', 'PFIN.00', 'Finances'); ?></td>
    <td><?php eventbtnjql('P26', 'PERSONAL.1', 'JO'); ?></td>
    
</tr><tr>

    <td><?php eventbtnjql('P35', 'PERSONAL.3', 'Dishes'); ?></td>
    <td><?php eventbtnjql('P34', 'PERSONAL.3', 'Laundry'); ?></td>
    <td><?php eventbtnjql('P41', 'PERSONAL.3', 'Trash'); ?></td>
    <td><?php eventbtnjql('P11', 'PERSONAL.3', 'Clean House'); ?></td>

</tr><tr>


<td><?php eventbtnjql('S10', 'AD', 'Shopping(A)'); ?></td>
    <td><?php eventbtnjql('P40', 'PERSONAL.2', 'Gas'); ?></td>
    <td><?php eventbtnjql('P36', 'PERSONAL.7', 'Groceries'); ?></td>
    <td><?php eventbtnjql('P37', 'PERSONAL.3', 'Lawn & Garden'); ?></td>

</tr><tr>

    <td><?php eventbtnjql('P56', 'AD', 'Hiking(A)'); ?></td>
    <td><?php eventbtnjql('P50', 'AD', 'Public Trans(A)'); ?></td>
    <td><?php eventbtnjql('P51', 'AD', 'Airport(A)'); ?></td>
    <td><?php eventbtnjql('P49', 'AD', 'Air Travel(A)'); ?></td>

</tr><tr>


	<td><?php eventbtnjql('N02', 'AD','Drive (A)'); ?></td>
    	<td><?php eventbtnjql('S01', 'AD', 'Social (A)'); ?></td>
    	<td><?php eventbtnjql('S03', 'AD', 'Lunch (A)'); ?></td>
    	<td><?php eventbtnjql('S07', 'AD', 'Dinner (A)'); ?></td>
    
</tr><tr>
    
        <td><?php eventbtnjql('N03', 'AD', 'TV (A)'); ?></td>    
    <td><?php eventbtnjql('S11', 'AD', 'Pool (A)'); ?></td>
    <td><?php eventbtnjql('S12', 'AD', 'Beach (A)'); ?></td>
    <td><?php eventbtnjql('S09', 'AD', 'Events (A)'); ?></td>
</tr>
</table>