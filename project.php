<?php

    require_once 'header.php';
    
    if (is_null($projectId) || empty($projectId)) {
        $projectId = $_GET["id"];
    }

    $conn = dbConnect();

    $stmt = $conn->prepare('select * from project where projectId = :id');
    $stmt->bindParam(':id', $projectId);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array

    foreach ($results as $project)
    {
        $projectName = $project['Name'];        
    }

    dbDisconnect($conn);


    require_once 'projectEditInclude.php';
    require_once 'footer.php'; 
?>