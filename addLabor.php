<?php 
require_once("dbConnExec.php");
require_once('headerFunctions.php');


$projectId = $_POST["projectId"];
$laborCost = $_POST["cost"];
$laborHours = $_POST["quantity"];

$errorMessages = '';
    
if(! empty($_POST)) {
    if(empty($projectId)) {
        $errorMessages .= "<li>Project Id is a required field.</li>";
    }

    if(empty($laborCost)) {
        $errorMessages .= "<li>Labor Cost is a required field.</li>";
    }

    if(empty($laborHours)) {
        $errorMessages .= "<li>Labor Hours is a required field.</li>";
    }

    if(preg_match("/[^0-9\.]/", $laborHours) > 0) {
        $errorMessages .= "<li>Labor Hours should only be digits and a decimal.</li>";
    }

    if(preg_match("/[^0-9\.]/", $laborCost) > 0) {
        $errorMessages .= "<li>Labor Cost should only be digits and a decimal.</li>";
    }
    

    if(empty($errorMessages)) {
        // make sure that the user name is not already being used
        $conn = dbConnect();

        $query = $conn->prepare('select projectId, materialId from projectLabor where projectId = :projectId and materialId = :materialId');
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
            $query->bindParam(':materialQuantity', trim($laborHours));
            $query->bindParam(':cost', trim($laborCost));

            $query->execute();
        }
        dbDisconnect($conn);

    }        
    

}

require_once('projectEditInclude.php');


?>


