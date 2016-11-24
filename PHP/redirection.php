<?php
    require_once("session.php");

    $search = array ("search_employee","create_employee_sheet","home", "search_contact", "add_contact", "modify_contact", "delete_contact","add_account", "modify_account", "delete_account");

    if (in_array($_GET['search'], $search) === false) {

        header('location: ../index.html');
    }

    if ($_GET['search'] == "home") {

       header('location:Error_And_Management.php');
        exit(0);
    }


    // ?search=search_contact.html
    if ($_GET['search'] == "search_contact") {

        $searchContact = file_get_contents("../HTML/".$_GET['search'].".html");

        echo $searchContact;

      // ?search=add_contact.html
    } else if ($_GET['search'] == "add_contact") {

        $addContact= file_get_contents("../HTML/".$_GET['search'].".html");

        echo $addContact;


      //?search=modify_contact.html
    } else if ($_GET['search'] == "modify_contact") {

        include("function_selectModifyContact.php");




    } else if ($_GET['search'] == "delete_contact") {

        $deleteContact = file_get_contents("../HTML/".$_GET['search'].".html");

        echo $deleteContact;



    } else if ($_GET['search'] == "add_account") {

        $addAccount= file_get_contents("../HTML/".$_GET['search'].".html");

        echo $addAccount;



    } else if ($_GET['search'] == "modify_account") {

        include("function_selectModifyAccount.php");




    } else if ($_GET['search'] == "delete_account") {

        include("function_selectDeleteAccount.php");



    }  else if ($_GET['search'] == "search_employee") {

        include("function_sheetEmployee.php");



    } else if ($_GET['search'] == "create_employee_sheet") {

        $persoAccount = file_get_contents("../HTML/" . $_GET['search'] . ".html");

        echo $persoAccount;
    }

