<?php
    class FormSanitizer{
        //Format first and last name
        public static function sanitizeFormString($inputText){
            //Remove html tags
            $inputText = strip_tags($inputText);
            //Remove spaces
            $inputText = str_replace(" ", "", $inputText);
            //Capitalize first letter
            $inputText = ucfirst(strtolower($inputText));
            //Uppercase first letter of each word
            $inputText = ucwords(strtolower($inputText));

            return $inputText;
        }

        //Format username
        public static function sanitizeFormUsername($inputText){
            //Remove html tags
            $inputText = strip_tags($inputText);
            //Remove spaces
            $inputText = str_replace(" ", "", $inputText);

            return $inputText;
        }

        //Format password
        public static function sanitizeFormPassword($inputText){
            //Remove html tags
            $inputText = strip_tags($inputText);

            return $inputText;
        }

        //Format email
        public static function sanitizeFormEmail($inputText){
            //Remove html tags
            $inputText = strip_tags($inputText);
            //Remove spaces
            $inputText = str_replace(" ", "", $inputText);

            return $inputText;
        }
    }
?>