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
    <h3><br>Thank you for Signing Up!</h3>

    
   <p>Welcome to CJC Project Estimator </p>
  </div>
<?php
require_once 'footer.php'; 
?>

