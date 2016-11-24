<?php

	require_once('session.php');
	include('config.php');

	$connect = connectDB();
	
	//$selectNom = selectNom($connect,$_POST);

    if(!empty($_POST['nomActuel'] && $_POST['nom'] && $_POST['prenom'] && $_POST['email'] && $_POST['fixe'])) {
	
        updateContact($connect,$_POST);
        echo 'Modification effectuée';

	} else {

		echo 'Veuillez renseigner tous les champs';
	}


	function selectNom(PDO $inConnect,$inPost) {

		$query = null;

		try {

			$query = "SELECT nom FROM perso_carnet WHERE nom='".$inPost['nom']."' AND `login_user` = '" . $_SESSION['id'] . "'";

			$sth = $inConnect->query($query);
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);

			$nom = $result[0]['nom'];
			return $nom;

		} catch (Exception $exc) {

			echo 'Query failed : ' .$exc->getMessage();
			echo '<br>';
			echo $exc->getTraceAsString();
			return false;

		}
	}

	function updateContact(PDO $inConnect, $inPost) {

		$query = null;

		try {

			$query = "UPDATE perso_carnet SET nom='".$inPost['nom']."', prenom='".$inPost['prenom']."',service='".$inPost['service']."',mail='".$inPost['email']."',tel_fixe='".$inPost['fixe']."',tel_port='".$inPost['portable']."' WHERE nom='".$inPost['nomActuel']."'";

			$inConnect->query($query);

		} catch (Exception $exc) {

			echo 'Query failed : ' .$exc->getMessage();
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

