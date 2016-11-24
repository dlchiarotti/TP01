<?php

	require_once('session.php');

	$connect = connectDB();
	$letter = $_POST['search'];


	selectContact($connect,$letter);


	function selectContact(PDO $inConnect, $inLetter) {
		$query = null;

		try {

			$query = "SELECT * FROM perso_carnet WHERE nom LIKE '".$inLetter."%' OR prenom LIKE '".$inLetter."%'";
			$sth = $inConnect->query($query);
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $all) {
				echo 'Nom : '.$all['nom'];
				echo '<br>';
				echo 'Prénom : '.$all['prenom'];
				echo '<br>';
				echo 'Service : '.$all['service'];
				echo '<br>';
				echo 'Mail : '.$all['mail'];
				echo '<br>';
				echo 'Téléphone fixe : '.$all['tel_fixe'];
				echo '<br>';
				echo 'Téléphone portable : '.$all['tel_port'];
				echo '<br><br>';
			}

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



