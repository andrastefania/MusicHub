<?php
class LogoutController {
    public function handle() {
        session_start();
        session_unset();   // elimină toate variabilele
        session_destroy(); // distruge sesiunea curentă
        header('Location: index.php?route=login');
        exit;
    }
}
