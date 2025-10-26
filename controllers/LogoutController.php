<?php
class LogoutController {
    public function handle() {
        session_start();
        session_unset();   
        session_destroy(); 
        header('Location: index.php?route=login');
        exit;
    }
}
