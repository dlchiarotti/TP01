<?php

    require_once('session.php');

    include('config.php');

    $bdd = connectDB();

    getNom($bdd);

    function getNom(PDO $inBdd) {

        $worker = file_get_contents("../HTML/modify_contact.html");
        $html = "";

        $bdd = $inBdd;
        $query = "SELECT * FROM `perso_carnet` WHERE `login_user` = '" . $_SESSION['id'] . "' ORDER BY `nom` ASC";
        $sth = $bdd->query($query);

        $result = $sth->fetchall(PDO::FETCH_ASSOC);

        $html = '<option value="">Selectionnez le contact</option>';

        foreach ($result as $line) {

            $html .='"<option value="' . $line['nom'] . '">'. $line['nom'] .' '. $line['prenom'] . '</option>';
        }

        $worker = str_replace('[[contact]]',$html, $worker);

        echo $worker;

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