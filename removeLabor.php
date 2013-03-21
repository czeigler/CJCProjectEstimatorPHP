<?php 
require_once("dbConnExec.php");
require_once('headerFunctions.php');


if (is_null($projectId) || empty($projectId)) {
    $projectId = $_POST["id"];
}
$projectLaborItemId = $_POST["projectLaborItemId"];

$errorMessages = '';
    
if(! empty($_POST)) {
    if(empty($projectId)) {
        $errorMessages .= "<li>Project Id is a required field.</li>";
    }

    if(empty($projectLaborItemId)) {
        $errorMessages .= "<li>Labor Item Id is a required field.</li>";
    }


    if(empty($errorMessages)) {
        // make sure that the user name is not already being used
        $conn = dbConnect();

        $query = $conn->prepare('delete from projectLaborItem where projectId = :projectId and ProjectLaborItemId = :projectLaborItemId');
        $query->bindParam(':projectId', trim($projectId));
        $query->bindParam(':projectLaborItemId', trim($projectLaborItemId));

        $query->execute();
        dbDisconnect($conn);
    }        
}

require_once('project.php');


?>


