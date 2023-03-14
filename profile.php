<?php
require_once("includes/header.php");
require_once("includes/paypalConfig.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/BillingDetails.php");

//Check if user is logged in
$user = new User($con, $userLoggedIn);

//Message variables
$detailsMessage = "";
$passwordMessage = "";
$subscriptionMessage = "";

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

//Execute billing agreement
if(isset($_GET['success']) && $_GET['success'] == 'true'){
    $token = $_GET['token'];
    $agreement = new \PayPal\Api\Agreement();

    //Keep error message as default in case of error
    $subscriptionMessage = "<div class='alertError'>
                                        Something went wrong!
                                    </div>";

    try{
        //Execute agreement
        $agreement->execute($token, $apiContext);

        //Get billing result
        $result = BillingDetails::insertDetails($con, $agreement, $token, $userLoggedIn);

        //Set is subscribed to true if $result is true
        $result = $result && $user->setIsSubscribed(1);

        //Check if $result is true and display success message
        if($result){
            $subscriptionMessage = "<div class='alertSuccess'>
                                        Subscription successful!
                                    </div>";
        }

    } catch(PayPal\Exception\PayPalConnectionException $ex){
        echo $ex->getCode();
        echo $ex->getData();
        die($ex);
    } catch(Exception $ex){
        die($ex);
    }

} else if(isset($_GET['success']) && $_GET['success'] == 'false'){
    // Show error message
    $subscriptionMessage = "<div class='alertError'>
                                Something went wrong!
                            </div>";
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

    <div class="formSection">
        <h2>Subscription</h2>

        <div class="message">
            <?php echo $subscriptionMessage; ?>
        </div>

        <?php
            //Check if user is subscribed
            if ($user->getIsSubscribed()) {
                echo "<h3>You are subscribed! Go to Paypal to cancel.</h3>";
            } else {
                echo "<a href='billing.php'>Subscribe to Movies!</a>";
            }
        ?>
    </div>

</div>