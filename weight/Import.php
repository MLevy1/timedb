<?php
// Load the database configuration file
include('../function/Functions.php');
pconn();

if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){

            // Open uploaded CSV file with read-only mode
            
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
       	     while(($line = fgetcsv($csvFile)) !== FALSE){
            
                // Get row data
                $dtime   = $line[0];
                $weight  = $line[1];

                // Check whether record already exists in the database with the same dt
                
                $prevQuery = "SELECT wDateTime FROM tblWeight WHERE wDateTime = '".$line[0]."'";
                
                $prevResult = $conn->query($prevQuery);
                
                if($prevResult->num_rows > 0){
             
                    // Update member data in the database
                    //$conn->query("UPDATE members SET name = '".$name."', phone = '".$phone."', status = '".$status."', modified = NOW() WHERE email = '".$email."'");
                    

                }else{
                    //Insert data in the database
                    $conn->query("INSERT INTO tblWeight (wDateTime, Weight) VALUES ('".$dtime."', '".$weight."')");
                }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
            
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: ImportExport.php".$qstring);
?>