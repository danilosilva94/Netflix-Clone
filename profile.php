<?php
require_once("includes/header.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");

//Check if user is logged in
$user = new User($con, $userLoggedIn);

//Message variables
$detailsMessage = "";
$passwordMessage = "";

//Check if save details button was pressed
if (isset($_POST["saveDetailsButton"])) {
    //Create new account object
    $account = new Account($con);

    //Sanitize form input
    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

    //Update user details
    if ($account->updateDetails($firstName, $lastName, $email, $userLoggedIn)) {
        //Update session variables
        $detailsMessage = "<div class='alertSuccess'>
                                Details updated successfully!
                            </div>";
    } else {
        //Display error message
        $errorMessage = $account->getFirstError();

        //Display error message
        $detailsMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";
    }
}

//Check if save password button was pressed
if (isset($_POST["savePasswordButton"])) {
    //Create new account object
    $account = new Account($con);

    //Sanitize form input
    $oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2 = FormSanitizer::sanitizeFormPassword($_POST["newPassword2"]);

    //Update user password
    if ($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedIn)) {
        //Display success message
        $passwordMessage = "<div class='alertSuccess'>
                                Password updated successfully!
                            </div>";
    } else {
        //Display error message
        $errorMessage = $account->getFirstError();

        //Display error message
        $passwordMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";
    }
}

?>

<div class="settingsContainer column">

    <div class="formSection">

        <form method="POST">

            <h2>User details</h2>

            <?php

            $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $user->getFirstName();
            $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getLastName();
            $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();
            ?>

            <input type="text" name="firstName" placeholder="First name" value="<?php echo $firstName; ?>">
            <input type="text" name="lastName" placeholder="Last name" value="<?php echo $lastName; ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">

            <div class="message">
                <?php echo $detailsMessage; ?>
            </div>

            <input type="submit" name="saveDetailsButton" value="Save">


        </form>

    </div>

    <div class="formSection">

        <form method="POST">

            <h2>Update password</h2>

            <input type="password" name="oldPassword" placeholder="Old password">
            <input type="password" name="newPassword" placeholder="New password">
            <input type="password" name="newPassword2" placeholder="Confirm new password">

            <div class="message">
                <?php echo $passwordMessage; ?>
            </div>

            <input type="submit" name="savePasswordButton" value="Save">


        </form>

    </div>

</div>