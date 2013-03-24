<?php 
require_once("dbConnExec.php");
require_once('headerFunctions.php');


if (is_null($projectId) || empty($projectId)) {
    $projectId = $_GET["id"];
}

$errorMessages = '';
    
if(! empty($_GET)) {
    if(empty($projectId)) {
        $errorMessages .= "<li>Project Id is a required field.</li>";
    }



    if(empty($errorMessages)) {
        // make sure that the user name is not already being used
        $conn = dbConnect();

        $query = $conn->prepare('delete from projectMaterial where projectId = :projectId');
        $query->bindParam(':projectId', trim($projectId));
        $query->execute();
        
        $query = $conn->prepare('delete from projectLaborItem where projectId = :projectId');
        $query->bindParam(':projectId', trim($projectId));
        $query->execute();
        
        $query = $conn->prepare('delete from project where projectId = :projectId');
        $query->bindParam(':projectId', trim($projectId));
        $query->execute();


        $query->execute();
        dbDisconnect($conn);
        
        redirect('home.php');
    }        
}

if (!empty($errorMessages)) {
    echo('<ul class="errorMessage">');
    echo($errorMessages);
    echo('</ul><br/>');
}

?>


