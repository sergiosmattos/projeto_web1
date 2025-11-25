<?php

if( $tipoUsuario !== 'Admin' ) {
    header('Location: dashboardUsuario.php');
    exit;
}