<?php
    require_once 'header.php'; 

    $userName = $_POST["userName"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $companyName = $_POST["companyName"];
    $password = $_POST["password"];
    $passwordConfirm = $_POST["passwordConfirm"];
    
    $errorMessages = '';
    
    if(! empty($_POST)) {
        if(empty($userName)) {
            $errorMessages .= "<li>User Name is a required field.</li>";
        }
        if(empty($firstName)) {
            $errorMessages .= "<li>First Name is a required field.</li>";
        }
        if(empty($lastName)) {
            $errorMessages .= "<li>Last Name is a required field.</li>";
        }        
        if(empty($password)) {
            $errorMessages .= "<li>Password is a required field.</li>";
        }        
        if(empty($passwordConfirm)) {
            $errorMessages .= "<li>Confirm Password is a required field.</li>";
        }
        if($password != $passwordConfirm) {
            $errorMessages .= "<li>Password fields do not match.</li>";
        }
        
        // if we didn't get any errors then let's go ahead and insert
        if(empty($errorMessages)) {
            // make sure that the user name is not already being used
            $conn = dbConnect();

            $stmt = $conn->prepare('select UserName from appusers where UserName = :userName');
            $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array


            dbDisconnect($conn);

            if(count($results) > 0) {
                $errorMessages .= "<li>That User Name is already being used. Please choose another.</li>";
            } else {
                
                $passwordSalt = date('YmdHis');
                $passwordHash = hash('sha256', $password . $passwordSalt);
                
                $query = $conn->prepare('insert into appusers (username, firstname, lastname, companyname, passwordhash, passwordsalt ) values (:userName, :firstName, :lastName, :companyName, :passwordHash, :passwordSalt)');
                $query->bindParam(':userName', trim($userName));
                $query->bindParam(':firstName', trim($firstName));
                $query->bindParam(':lastName', trim($lastName));
                $query->bindParam(':companyName', trim($companyName));
                $query->bindParam(':passwordHash', trim($passwordHash));
                $query->bindParam(':passwordSalt', trim($passwordSalt));
                
                $query->execute();
            }
            


        }
        
        
        
        
    }
    
?>
  
   <p><br>Sign up for the CJC Project Estimator - It's free and we won't spam you.</p>
   
   <div class="fieldset">
    <h4 class="legend">Sign-up</h4>
    <form method="post" action="signup.php">

        
    <?php
    if(! empty($errorMessages)) {
        echo('<ul class="errorMessage">');
        echo($errorMessages); 
        echo('</ul><br/>');
    }
    ?>

       
        
    <table class="table">
      <tr >
        <td class="firstcoll">User Name:<span class='required'>*</span></td>
        <td><input name="userName" type="text" value="<?php echo($userName); ?>" size="15" maxlength="45"></td>
      </tr>
      <tr >
        <td class="firstcoll">First Name:<span class='required'>*</span></td>
        <td><input name="firstName" type="text" value="<?php echo($firstName); ?>" size="15" maxlength="45"></td>
      </tr>
      <tr>
        <td class="firstcoll">Last Name:<span class='required'>*</span></td>
        <td><input name="lastName" type="text" value="<?php echo($lastName); ?>" size="15" maxlength="45"></td>
      </tr>
      <tr>
        <td class="firstcoll">Company Name: </td>
        <td><input name="companyName" type="text" value="<?php echo($companyName); ?>" size="15" maxlength="45"></td>
      </tr>
      <tr>
        <td class="firstcoll">Password:<span class='required'>*</span></td>
        <td><input name="password" type="password"  size="15" maxlength="15"></td>
      </tr>
      <tr>
        <td class="firstcoll">Confirm Password:<span class='required'>*</span></td>
        <td><input name="passwordConfirm" type="password"  size="15" maxlength="15"></td>
      </tr>
      <tr>
        <td class="firstcoll">
        <td class="submitcoll"><input type="submit" name="Submit2" id="Submit2" value="Submit"></td>
      </tr>
    </table>
    </form>
     
    <span class='required'>* Required Fields</span>
    <p>&nbsp;</p>
   </div>   
<?php
    require_once 'footer.php'; 
?>