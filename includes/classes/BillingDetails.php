<?php
    class BillingDetails{
        // Insert billing details into database
        public static function insertDetails($con, $agreement, $token, $username){
            //Prepare query
            $query = $con->prepare("INSERT INTO billingDetails (agreementId, nextBillingDate, token, username) VALUES (:agreementId, :nextBillingDate, :token, :username)");

            //Bind values
            $query->bindValue(":agreementId", $agreement->getId());
            $query->bindValue(":nextBillingDate", $agreement->getAgreementDetails()->getNextBillingDate());
            $query->bindValue(":token", $token);
            $query->bindValue(":username", $username);

            //Return result
            return $query->execute();
        }
    }
?>