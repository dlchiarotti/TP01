<?php

    require_once('session.php');
   
    $home =  file_get_contents("../HTML/home.html");

    $templateVar_One   = "";
    $templateVar_Two   = "";
    $templateVar_Three = "";

    if ($_SESSION["type"] == "admin") {

        $templateVar_One = "<div class='box-link first_box'>
                            <a href = 'redirection.php?search=add_account'><i class='fa fa-user-plus'></i><span class='hr'></span> Ajouter un compte</a>
                            </div>";

        $templateVar_Two ="<div class='box-link'>
                            <a href = 'redirection.php?search=modify_account'><i class='fa fa-wrench' aria-hidden='true'></i><span class='hr'></span> Modifier un compte</a>
                            </div>";

        $templateVar_Three = "<div class='box-link'>
                            <a href = 'redirection.php?search=delete_account'><i class='fa fa-trash' aria-hidden='true'></i><span class='hr'></span> Supprimer un compte</a>
                            </div>";

        $home = str_replace("[[addAccount]]", $templateVar_One ,$home);
        $home = str_replace("[[modifyAccount]]", $templateVar_Two ,$home);
        $home = str_replace("[[deleteAccount]]", $templateVar_Three ,$home);

        echo $home;

    } else {

        $home = str_replace("[[addAccount]]", $templateVar_One, $home);
        $home = str_replace("[[modifyAccount]]", $templateVar_Two ,$home);
        $home = str_replace("[[deleteAccount]]", $templateVar_Three ,$home);

        echo $home;
    }