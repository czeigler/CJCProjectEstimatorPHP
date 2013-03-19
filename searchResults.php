<?php
require_once 'header.php'; 

$projects = getProjectsForUser(getCurrentUserId());
$output .= "<table class='results'><tr><th>Project Name</th></tr><tbody>";   
foreach ($projects as $project)
    {
        extract($project);

        $output .= <<<ABC
        <tr>
            <td><a href="project.php?id=$projectId">$name</a></td>
        </tr>

ABC;
    }
    
    $output .= "<tbody></table>";



echo($output);





require_once 'footer.php'; 
?>