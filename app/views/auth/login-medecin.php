<?php
/**
 * login-medecin.php
 * Cette page redirige vers la page de connexion générale.
 * Le design premium a été déplacé vers register-medecin.php
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Location: index.php?route=/login');
exit();
