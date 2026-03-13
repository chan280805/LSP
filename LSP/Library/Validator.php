<?php

class Validator {

    public static function email($email){
        return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

}