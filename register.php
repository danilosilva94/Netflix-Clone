<?php
    require_once("includes/config.php");
    require_once("includes/classes/FormSanitizer.php");
    require_once("includes/classes/Constants.php");
    require_once("includes/classes/Account.php");

    //Create new Account object
    $account = new Account($con);

    //Check if submit button is pressed
    if (isset($_POST['submitButton'])) {
        //Sanitize form data
        $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
        $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
        $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
        $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
        $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

        //Register user
        $success = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);

        //Check if registration was successful
        if ($success) {
            //Store session
            $_SESSION["userLoggedIn"] = $username;
            //Redirect to index page
            header("Location: index.php");
        }
    }

    //Function to get input value
    function getInputValue($name)
    {
        if (isset($_POST[$name])) {
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
                <h3>Sign Up</h3>
                <span>to continue to Movies</span>
            </div>

            <form method="POST">

                <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                <input type="text" name="firstName" placeholder="First name" 
                value="<?php getInputValue("firstName"); ?>"
                required>

                <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                <input type="text" name="lastName" placeholder="Last name" 
                value="<?php getInputValue("lastName"); ?>"
                required>

                <?php echo $account->getError(Constants::$usernameCharacters); ?>
                <?php echo $account->getError(Constants::$usernameTaken); ?>
                <input type="text" name="username" placeholder="Username" 
                value="<?php getInputValue("username"); ?>"
                required>

                <?php echo $account->getError(Constants::$emailInvalid); ?>
                <?php echo $account->getError(Constants::$emailTaken); ?>
                <input type="email" name="email" placeholder="Email" 
                value="<?php getInputValue("email"); ?>"
                required>

                <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                <input type="email" name="email2" placeholder="Confirm email" 
                value="<?php getInputValue("email2"); ?>"
                required>

                <?php echo $account->getError(Constants::$passwordCharacters); ?>
                <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                <input type="password" name="password" placeholder="Password" required>

                <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                <input type="password" name="password2" placeholder="Confirm password" required>

                <input type="submit" name="submitButton" value="SUBMIT">
            </form>

            <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>
        </div>
    </div>
</body>

</html>