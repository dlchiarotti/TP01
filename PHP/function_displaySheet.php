<?php
    require_once('session.php');
    include('config.php');

    $bdd = connectDB();

    displaySheet($bdd);

    function displaySheet(PDO $inBdd) {

        $bdd = $inBdd;
        $query = "SELECT * FROM `entreprise_carnet` WHERE `e_login_user`='" .$_POST['type'] . "'";
        $sth = $bdd->query($query);

        $result = $sth->fetchall(PDO::FETCH_ASSOC);
        //        var_dump($result);
        //         die();

        //foreach($result as $all) {

            echo 'Nom : '.$result[0]['e_nom'];
            echo '<br>';
            echo 'Prénom :'.$result[0]['e_prenom'];
            echo '<br>';
            echo 'Service : '.$result[0]['e_service'];
            echo '<br>';
            echo 'Mail : '.$result[0]['e_mail'];
            echo '<br>';
            echo 'Téléphone fixe : '.$result[0]['e_tel_fixe'];
            echo '<br>';
            echo 'Téléphone portable : '.$result[0]['e_tel_port'];
            echo '<br><br>';
        //}

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