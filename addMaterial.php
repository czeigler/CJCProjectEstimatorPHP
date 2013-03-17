<?php 
require_once("dbConnExec.php");
require_once('headerFunctions.php');


$projectId = $_POST["projectId"];
$materialId = $_POST["materialId"];
$materialCost = $_POST["cost"];
$materialQuantity = $_POST["quantity"];

$errorMessages = '';
    
if(! empty($_POST)) {
    if(empty($projectId)) {
        $errorMessages .= "<li>Project Id is a required field.</li>";
    }

    if(empty($materialId)) {
        $errorMessages .= "<li>Material is a required field.</li>";
    }

    if(empty($materialCost)) {
        $errorMessages .= "<li>Material Cost is a required field.</li>";
    }

    if(empty($materialQuantity)) {
        $errorMessages .= "<li>Material Quantity is a required field.</li>";
    }

    echo($errorMessages);

    if(empty($errorMessages)) {
        // make sure that the user name is not already being used
        $conn = dbConnect();

        $query = $conn->prepare('insert into projectMaterial (projectId, materialId, number, cost) values (:projectId, :materialId, :materialQuantity, :cost)');
        $query->bindParam(':projectId', trim($projectId));
        $query->bindParam(':materialId', trim($materialId));
        $query->bindParam(':materialQuantity', trim($materialQuantity));
        $query->bindParam(':cost', trim($materialCost));

        $query->execute();

        dbDisconnect($conn);

    }        
}




?>


