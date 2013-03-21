<?php

require_once 'header.php';

$projectName = $_POST["projectName"];
$errorMessages = '';
    
    if(! empty($_POST)) {
        if(empty($projectName)) {
            $errorMessages .= "<li>Project Name is a required field.</li>";
        }
        if(empty($errorMessages)) {
            // make sure that the user name is not already being used
            $conn = dbConnect();

            $stmt = $conn->prepare('select name from Project where name = :projectName');
            $stmt->bindParam(':projectName', $projectName, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array

            if(count($results) > 0) {
                $errorMessages .= "<li>That Project Name is already being used. Please choose another.</li>";
            } else {
                
                $userId = getCurrentUserId();
               
                $query = $conn->prepare('insert into project (name, id) values (:name, :userId)');
                $query->bindParam(':name', trim($projectName));
                $query->bindParam(':userId', trim($userId));
         
                $query->execute();
                $projectId = $conn->lastInsertId();
            }
            
            dbDisconnect($conn);
            echo($errorMessages);
        }        
    }
    
require_once 'projectEditInclude.php';

require_once 'footer.php'; 
?>