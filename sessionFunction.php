<?php
function sessionClear(){
    //actor
    unset($_SESSION['last_name']);
    unset($_SESSION['family_name']);
    unset($_SESSION['mail']);
    unset($_SESSION['password']);
    unset($_SESSION['gender']);
    unset($_SESSION['grade']);
    unset($_SESSION['authority']);
    //event
    unset($_SESSION['event_name']);
    unset($_SESSION['address']);
    unset($_SESSION['month']);
    unset($_SESSION['date']);
    unset($_SESSION['number']);
        
}
?>
