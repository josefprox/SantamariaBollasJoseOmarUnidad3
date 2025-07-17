<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requiereLogin() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }
}

function soloAdmin() {
    requiereLogin();
    if ($_SESSION['usuario'] !== 'admin') {
        header("Location: indexusuario.php");
        exit();
    }
}

function soloUsuario() {
    requiereLogin();
    if ($_SESSION['usuario'] === 'admin') {
        header("Location: indexadmin.php");
        exit();
    }
}
