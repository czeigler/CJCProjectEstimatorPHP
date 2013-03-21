<?php
require_once 'header.php'; 
?>

    <?php
    if(! empty($errorMessages)) {
        echo('<br />');
        echo('<ul class="errorMessage">');
        echo($errorMessages); 
        echo('</ul><br/>');
    }
    ?>    


  <div class="content">
    <h3><br>Projects Dashboard</h3>

    
   <p>Welcome to your projects home page. From here you can create a new project, search for an existing project, or run the projects report. </p>
    <div class="dashboard">
    <h4 class="legend">Run Projects Report</h4>
    <hr>
    <form name="form2" method="post" action="reports.html" value="clickable button"> 
  
       <p>
         <input type="submit" class="input" name="Search" id="Search" value="Run Report">
       </p>
    </form>
  </div>
  <div class="dashboard">
    <h4 class="legend">Search All Projects</h4>
    <hr>
    <form name="form2" method="post" action="searchResults.php" value="clickable button"> 
       <p>Search Term:
         <input name="Project Name" type="text" id="Project Name" size="17">
       </p>
       <p>
         <input type="submit" class="input" name="Search" id="Search" value="Go">
       </p>
    </form>
  </div>
  <div class="dashboard">
    <h4 class="legend">Create a new project<br>
    </h4>
    <hr>
  
     <form name="form1" method="post" action="createProject.php" value="clickable button"> 
       <p>
         <label for="projectId">Project Name</label>
         :
         <input name="projectName" type="text" id="projectName" size="17">
       </p>
       <p>
         <input type="submit" class="input" name="Add" id="Add" value="Add" id="addProject">
       </p>
     </form>

</div><div class="contentClear"><p>Results will be displayed on the next page.</p></div>
  </div>


<?php
require_once 'footer.php'; 
?>

<!--<script>
    $('input[type=submit]').click(function() {
       if($('#projectName').val().length < 1)  {
           alert("Project Name cannot be blank.");
           return false;
       } else {
           return true;
       }
    });
</script>-->