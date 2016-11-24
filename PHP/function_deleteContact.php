<?php

 session_start();
 session_write_close();

 if (!isset($_SESSION['user'])) {

     header('location: ../index.html');
     exit(0);
 }

    $connect = connectDB();

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    if(!empty ($nom) || !empty ($prenom)) {

        deleteContact($connect, $_POST);

    } else {

        echo 'Veuillez renseigner tous les champs';
    }

    function deleteContact(PDO $inDbh, $inPost) {
        $query = null;

        $nameCase  = $inPost['nom'];
        $lNameCase = $inPost['prenom'];

        $queryPrenom = "SELECT prenom FROM perso_carnet WHERE prenom='".$lNameCase."';";
        $sth = $inDbh->query($queryPrenom);
        $resultPrenom = $sth->fetchAll(PDO::FETCH_ASSOC);

        $queryNom = "SELECT nom FROM perso_carnet WHERE nom='".$nameCase."';";
        $sth = $inDbh->query($queryNom);
        $resultNom = $sth->fetchAll(PDO::FETCH_ASSOC);

        if (isset($resultNom[0]) && $resultNom[0]['nom'] == $nameCase && isset($resultPrenom[0]) && $resultPrenom[0]["prenom"] == $lNameCase) {

            $queryDelete = "DELETE FROM perso_carnet WHERE (nom='".$nameCase."' AND prenom='".$lNameCase."') AND `login_user` = '".$_SESSION['id'] . "';";
            $inDbh->query($queryDelete);

            echo 'Suppression effectuée';

        } else {

            echo 'Suppression impossible';
        }
    }

    function connectDB() {

        $dbName = 'tp_evalue_01';
        $host = '127.0.0.1';
        $user = 'root';
        $password = 'mode83';
        $dsn = 'mysql:dbname=' . $dbName . ';host=' . $host;
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