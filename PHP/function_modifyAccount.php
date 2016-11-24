<?php


    require_once('session.php');

    $connect = connectDB();


    if (empty ($_POST['user'] && $_POST['type'])) {
        echo 'Veuillez renseigner tous les champs';

    } else {

        updateAccount($connect,$_POST['type'],$_POST['user']);
        echo 'Modification du status effectuée';
        //header('location:Error_And_Management.php');
        exit(0);
    }

    function updateAccount(PDO $connect,$inType,$inUser) {
        $query = null;

        try {

            $query = "UPDATE login SET type='".$inType."' WHERE user='".$inUser."'";
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