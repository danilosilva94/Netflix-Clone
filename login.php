<?php
    require_once("includes/config.php");
    require_once("includes/classes/Account.php");
    require_once("includes/classes/FormSanitizer.php");
    require_once("includes/classes/Constants.php");

    //Create new account object
    $account = new Account($con);

    //Check if submit button is pressed
    if(isset($_POST['submitButton'])){
        //Login button was pressed
        $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
        $password = FormSanitizer::sanitizeFormPassword($_POST['password']);

        $result = $account->login($username, $password);

        if($result == true){
            $_SESSION['userLoggedIn'] = $username;
            header("Location: index.php");
        }
    }

    //Function to get input value
    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Movies</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
    <div class="signInContainer">
        <div class="imgContainer">
            <img src="assets/images/login-background.jpg" class="login-background" alt="login-background.jpg">
        </div>
        <img src="assets/images/logo.png" class="logo" title="logo" alt="logo.png">
        <div class="column">

            <div class="header">
                <h3>Sign In</h3>
                <span>to continue to Movies</span>
            </div>

            <form method="POST">
                <input type="text" name="username" placeholder="Username" 
                value="<?php getInputValue('username'); ?>"
                required>
                <input type="password" name="password" placeholder="Password" required>

                <?php echo $account->getError(Constants::$loginFailed); ?>
                <input type="submit" name="submitButton" value="Submit">
            </form>

            <a href="register.php" class="signInMessage">Need an account? Sign up here!</a>
        </div>
    </div>
</body>
</html>