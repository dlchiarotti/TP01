<?php


    session_start();
    session_write_close();

    if (!isset($_SESSION['user'])) {

     header('location: ../index.html');
     exit(0);
    }

    $connect = connectDB();

    $idCase = ucfirst(strtolower($_POST['nom']));


    if (empty ($idCase && $_POST['pass'] && $_POST['confirmPass'] && $_POST['type'])) {

        echo 'Veuillez renseigner tous les champs';
        exit(0);
    }

    if ($_POST['pass'] == $_POST['confirmPass']) {

        addAccount($connect, $idCase, $_POST['pass'], $_POST['type']);
        echo 'Compte ajouté';

    } else {

        echo 'Erreur';
    }

     function addAccount(PDO $connect, $user, $pass, $type) {
        $query = null;

        try {

        //hash un mdp
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        //password_verify($pass, $hash);
        $query = "INSERT INTO `login`(`user`, `pass`, `type`) VALUES ('".$user."','".$hash."','".$type."')";
           $connect->query($query);

       } catch (Exception $exc) {

             echo 'Query failed : ' . $exc->getMessage();
             echo '<br>';
             echo $exc->getTraceAsString();
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
