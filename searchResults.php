<?php
require_once 'header.php'; 
?>
<div class="fieldset">
<?php
$projects = getProjectsForUser(getCurrentUserId(), $_POST['projectName']);
$output .= "<table class='results'><tr><th class='legend'>Project Name</th><th></th></tr><tbody>";   
foreach ($projects as $project)
    {
        extract($project);

        $output .= <<<ABC
        <tr>
            <td><a href="project.php?id=$projectId">$name</a></td>
            <td><a id="removeProject" href="removeProject.php?id=$projectId">[Remove]</a></td>
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

<script>
    $(document).ready(function() {
        $('#removeProject').click(function() {
            if(confirm("Are you sure you want to delete this Project?")) {
               return true;
            }
             return false;
        });
       
    });
    
</script>