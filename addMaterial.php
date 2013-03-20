<?php 
require_once("dbConnExec.php");
require_once('headerFunctions.php');


if (is_null($projectId) || empty($projectId)) {
    $projectId = $_POST["id"];
}

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

    if(preg_match("/[^0-9\.]/", $materialQuantity) > 0) {
        $errorMessages .= "<li>Material Quantity should only be digits and a decimal.</li>";
    }

    if(preg_match("/[^0-9\.]/", $materialCost) > 0) {
        $errorMessages .= "<li>Material Cost should only be digits and a decimal.</li>";
    }
    

    if(empty($errorMessages)) {
        // make sure that the user name is not already being used
        $conn = dbConnect();

        $query = $conn->prepare('select projectId, materialId from projectMaterial where projectId = :projectId and materialId = :materialId');
        $query->bindParam(':projectId', trim($projectId));
        $query->bindParam(':materialId', trim($materialId));

        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array

        if(count($results) > 0) {
            $errorMessages .= "<li>That Material is already being used. Please choose another.</li>";
        } else {
        
            $query = $conn->prepare('insert into projectMaterial (projectId, materialId, number, cost) values (:projectId, :materialId, :materialQuantity, :cost)');
            $query->bindParam(':projectId', trim($projectId));
            $query->bindParam(':materialId', trim($materialId));
            $query->bindParam(':materialQuantity', trim($materialQuantity));
            $query->bindParam(':cost', trim($materialCost));

            $query->execute();
            
            // clear variables because we saved and we want the form to be blank again
            unset($materialId);
            unset($materialCost);
            unset($materialQuantity);
            
        }
        dbDisconnect($conn);

        
    }        
    

}

require_once("project.php");


?>


