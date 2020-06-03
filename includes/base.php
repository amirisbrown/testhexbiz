<?php

include_once __DIR__.'/global.php';

class Base
{
    public function verifyToken() {

        if (isset($_POST['token'])) {
            if (!empty($_POST['token'])) {
                if (!hash_equals($_SESSION['token'], $_POST['token'])) {
                    throw new InvalidArgumentException("Token Expired");
                } 
            }
        }
        else {
            throw new InvalidArgumentException("Invalid Request");
        }
    }
}

?>