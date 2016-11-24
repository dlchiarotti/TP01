<?php
    session_start();
    session_write_close();

    if (!isset($_SESSION['user'])) {

    header('location: ../index.html');
    exit(0);
    }