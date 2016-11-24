<?php

 session_start();
 session_write_close();

 if (!isset($_SESSION['user'])) {

     header('location: ../index.html');
     exit(0);
 }

		$bdd = connectDB();
		
		
		if (!empty($_POST['type'])) {
  			deleteContactId($bdd,$_POST);
		  	deleteFichePerso($bdd,$_POST);    
			deleteId($bdd,$_POST);
			echo 'Compte supprimé';
		} else {
		  	echo 'Suppression du compte impossible';	
		}
  
		
	function deleteContactId($inBdd,$inPost) {		
	  $bdd = $inBdd;
     $query = "DELETE FROM `perso_carnet` WHERE `login_user`='".$inPost['type']."'; ";
     $sth = $bdd->query($query);
   }
		
	function deleteFichePerso($inBdd,$inPost) {
		$bdd = $inBdd;
		$query = "DELETE FROM `entreprise_carnet` WHERE `e_login_user`='".$inPost['type']."';";
		$sth = $bdd->query($query);
	}
	
   function deleteId($inBdd,$inPost) {
      $bdd = $inBdd;
      $query = "DELETE FROM `login` WHERE `id` ='".$inPost['type']."';";
      $sth = $bdd->query($query);
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