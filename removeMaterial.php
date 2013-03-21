<?php 
require_once("dbConnExec.php");
require_once('headerFunctions.php');


if (is_null($projectId) || empty($projectId)) {
    $projectId = $_POST["id"];
}
$materialId = $_POST["materialId"];

$errorMessages = '';
    
if(! empty($_POST)) {
    if(empty($projectId)) {
        $errorMessages .= "<li>Project Id is a required field.</li>";
    }

    if(empty($materialId)) {
        $errorMessages .= "<li>Material Id is a required field.</li>";
    }


    if(empty($errorMessages)) {
        $conn = dbConnect();

        $query = $conn->prepare('delete from projectMaterial where projectId = :projectId and MaterialId = :materialId');
        $query->bindParam(':projectId', trim($projectId));
        $query->bindParam(':materialId', trim($materialId));

        $query->execute();
        dbDisconnect($conn);
        unset($materialId);
        unset($materialCost);
        unset($materialQuantity);        
    }        
}

require_once('project.php');


?>


