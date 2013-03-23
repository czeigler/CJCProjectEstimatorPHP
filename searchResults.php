<?php
require_once 'header.php'; 
?>
<div class="fieldset">
<?php
$projects = getProjectsForUser(getCurrentUserId(), $_POST['projectName']);
$output .= "<table class='results'><tr><th class='legend'>Project Name</th></tr><tbody>";   
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

?>

</div>
<?php

require_once 'footer.php'; 
?>