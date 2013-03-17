<?php
require_once 'header.php';

$userName = trim($_POST["userName"]);
$password = trim($_POST["password"]);

if (!empty($_POST)) {

    if (empty($userName)) {
        $errorMessages .= "<li>User Name is a required field.</li>";
    }
    if (empty($password)) {
        $errorMessages .= "<li>Password is a required field.</li>";
    }

    if (empty($errorMessages)) {
        // validate the user name and password
        $conn = dbConnect();

        $stmt = $conn->prepare('select rtrim(UserName) UserName, rtrim(PasswordSalt) PasswordSalt, rtrim(PasswordHash) PasswordHash from appusers where rtrim(UserName) = :userName');
        $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array
        if (count($results) < 1) {
            $errorMessages .= "<li>The user name or password that you entered was invalid.</li>";
        }

        if (empty($errorMessages)) {
            foreach ($results as $user) {
                extract($user);

                //$passwordSalt = $results["PasswordSalt"];
                $passwordHash = hash('sha256', $password . $PasswordSalt);


                $stmt = $conn->prepare('select UserName from appusers where rtrim(UserName) = :userName and rtrim(passwordHash) = :passwordHash');
                $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
                $stmt->bindParam(':passwordHash', $passwordHash, PDO::PARAM_STR);
                $stmt->execute();
                $results2 = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array
            }
        }

        dbDisconnect($conn);

        if (count($results2) < 1) {
            $errorMessages .= "<li>The user name or password that you entered was invalid.</li>";
        } else {
            setcookie('auth', $passwordHash, time()+3600);
            redirect('home.php');
        }
    }
}
?>


<h1>Login</h1>

<div class="signup">
    <h4>Enter your user name and password below to log in.</h4>
    <form method="post" action="login.php">


<?php
if (!empty($errorMessages)) {
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
            <tr>
                <td class="firstcoll">Password:<span class='required'>*</span></td>
                <td><input name="password" type="password"  size="15" maxlength="15"></td>
            </tr>
            <tr>
                <td class="firstcoll">
                <td class="submitcoll"><input type="submit" name="Submit2" id="Submit2" value="Submit"></td>
            </tr>
        </table>
    </form>
    <p>&nbsp;</p>    
    <span class='required'>* Required Fields</span>
    <p>&nbsp;</p>
</div>   
<?php
require_once 'footer.php';
?>