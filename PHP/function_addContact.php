<?php

    session_start();
    session_write_close();;

    if (!isset($_SESSION['user'])) {

        header('location: ../index.html');
        exit(0);
    }

    $dbh = connectDB();

    if (!empty($_POST["nom"] && $_POST["prenom"] && $_POST["email"] && $_POST["tel"])) {
			
        addContact($dbh);
		
    } else {
    		echo 'Veuillez renseigner tous les champs';
    }


    function addContact(PDO $inDbh) {
        $dbh         = $inDbh;
        $sth         = "";
        $query       = null;
        $inName      = "";
        $inLName     = "";
        $inService   = "";
        $inMail      = "";
        $inPhone     = "";
        $inCellPhone = "";

        if( isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['service']) && isset($_POST['email'])
            && isset($_POST['tel']) && isset($_POST['portable']) ) {

            $inName      = ucfirst(strtolower(filter_var($_POST['nom'], FILTER_SANITIZE_STRING))) ;
            $inLName     = ucfirst(strtolower(filter_var($_POST['prenom'], FILTER_SANITIZE_STRING)));
            $inService   = ucfirst(strtolower(filter_var($_POST['service'], FILTER_SANITIZE_STRING)));
            $inMail      = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

           if ( preg_match("`^0[0-9]([-. ]?\d{2}){4}[-. ]?$`",$_POST['tel']) ) {

                $inPhone = $_POST["tel"];

           } else {

               echo "Erreur lors de l'ajout du contact";

           }

            if ( preg_match("`^0[0-9]([-. ]?\d{2}){4}[-. ]?$`",$_POST['portable']) ) {
               $inCellPhone = $_POST["portable"];


            } else {

               echo "Erreur lors de l'ajout du contact";
               
            }

            try {

                $query = "INSERT INTO `perso_carnet` (nom,prenom,service,mail,tel_fixe,tel_port,login_user) VALUES ('" . $inName . "','" . $inLName . "','" . $inService . "','" . $inMail . "','" . $inPhone . "','" . $inCellPhone . "','" . $_SESSION['id'] ."')";
                $sth   = $dbh ->query($query);
					 echo 'Ajout du contact effectué';
            } catch (Exception $exc) {

                echo "L'adresse Email a déjà été enregistrée, veuillez ressaisir une autre adresse";
            }
        }
    }


    function connectDB() {

        $dbName = 'tp_evalue_01';
        $host = '127.0.0.1';
        $user = 'root';
        $password = 'mode83';
        $dsn = 'mysql:dbname=' . $dbName . ';host=' . $host;
        $dsn = "mysql:dbname=$dbName;host=$host";

        $dbh = null;

        try {
            $pdoOptions = array(
                PDO::ATTR_EMULATE_PREPARES => false,
                /* PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE, */
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_AUTOCOMMIT => TRUE,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

            $dbh = new PDO($dsn, $user, $password, $pdoOptions);

        } catch (PDOException $e) {

            echo 'Connection failed ! : ' . $e->getMessage();

            die(__FILE__ . " " . __FUNCTION__ . " " . __LINE__);
        }

        return $dbh;
    }