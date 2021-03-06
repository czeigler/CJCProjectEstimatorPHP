<?php

$publicPages = array(
    'index.php' => true,
    'login.php' => true,
    'logout.php' => true,    
    'signup.php' => true,
    'about.php' => true);



    function loggedIn() {
        return strlen($_COOKIE['auth']) > 0;
    }

    function redirect($page) {
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        
        header("Location: http://$host$uri/$page");
        exit;
    }

    function getCurrentUserId() {
        if(loggedIn()) {   
            $conn = dbConnect();
            $passwordHash = $_COOKIE['auth'];
            $stmt = $conn->prepare('select id from appusers where passwordHash = :passwordHash');
            $stmt->bindParam(':passwordHash', $passwordHash, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array
            dbDisconnect($conn);   
            foreach ($results as $user) {
                extract($user);
            }
            return $id;
        }
    }
    
function getProjectsForUser($userId, $searchString)
{
    $searchString = "%" . $searchString . "%";
    $query = <<<STR
Select name, projectId
From project
Where id = $userId
and name like '$searchString'
order by lower(name)
STR;

    return executeQuery($query);
}        
        
function money_format($value) {
    return "$ " . number_format($value, 2);
}
    
    
// check and see if we are on a public page
$currentPage = rtrim(basename($_SERVER['PHP_SELF']));
if(! loggedIn()) {
    if(! array_key_exists($currentPage, $publicPages)) {
        redirect('login.php');
    }
}




    
?>
