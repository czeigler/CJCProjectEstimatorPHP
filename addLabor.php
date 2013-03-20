<?php 
require_once("dbConnExec.php");
require_once('headerFunctions.php');


if (is_null($projectId) || empty($projectId)) {
    $projectId = $_POST["id"];
}

$laborRate = $_POST["rate"];
$laborHours = $_POST["hours"];
$laborDescription = $_POST["laborDescription"];

$errorMessages = '';
    
if(! empty($_POST)) {
    if(empty($projectId)) {
        $errorMessages .= "<li>Project Id is a required field.</li>";
    }

    if(empty($laborRate)) {
        $errorMessages .= "<li>Labor Rate is a required field.</li>";
    }

    if(empty($laborHours)) {
        $errorMessages .= "<li>Labor Hours is a required field.</li>";
    }

    if(preg_match("/[^0-9\.]/", $laborHours) > 0) {
        $errorMessages .= "<li>Labor Hours should only be digits and a decimal.</li>";
    }

    if(preg_match("/[^0-9\.]/", $laborRate) > 0) {
        $errorMessages .= "<li>Labor Rate should only be digits and a decimal.</li>";
    }
    

    if(empty($errorMessages)) {
        // make sure that the user name is not already being used
        $conn = dbConnect();

        $query = $conn->prepare('select projectId, description from projectLaborItem where projectId = :projectId and rtrim(description) = :description');
        $query->bindParam(':projectId', trim($projectId));
        $query->bindParam(':description', trim($laborDescription));

        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array

        if(count($results) > 0) {
            $errorMessages .= "<li>That labor description is already being used. Please enter another.</li>";
        } else {
        
            $query = $conn->prepare('insert into projectLaborItem (projectId, description, hours, costperhour) values (:projectId, :description, :hours, :costPerHour)');
            $query->bindParam(':projectId', $projectId);
            $query->bindParam(':description', trim($laborDescription));
            $query->bindParam(':hours', $laborHours);
            $query->bindParam(':costPerHour', $laborRate);

            $query->execute();
            
            // clear variables because we saved and we want the form to be blank again
            unset($laborRate);
            unset($laborHours);
            unset($laborDescription);
        }
        dbDisconnect($conn);

    }        
    

}

require_once('project.php');


?>


