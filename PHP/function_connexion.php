<?php
    session_start();

	if (session_id()) {

		session_destroy();
	}

	$dbh = connectDB();

	if (!empty($_POST["submit"])) {

		getPassword($dbh, $_POST);
	}

	function getPassword(PDO $inDbh, $inPost) {
		$dbh = $inDbh;
		$query = null;

		$idCase = ucfirst(strtolower($inPost['identifiant']));

		$query = "SELECT `id`, `user`, `pass`, `type` FROM `login` WHERE `user`='".$idCase. "'" ;

		$sth = $dbh->query($query);
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);


		if (count($result) && password_verify($inPost["password"], $result[0]["pass"])) {

			session_start();
			$_SESSION["user"] = $idCase;
			$_SESSION["type"] = $result[0]["type"];
            $_SESSION['id']   = $result[0]["id"];


			session_write_close();

			$dbh = $inDbh;
			$loginId = null;

			$loginId = "SELECT `e_login_user` FROM `entreprise_carnet` WHERE `e_login_user`='".$_SESSION['id']."';";


			$loginSth = $dbh->query($loginId);
			$loginResult = $loginSth->fetchall(PDO::FETCH_ASSOC);

			if($_SESSION['id'] != $loginResult[0]['e_login_user']) {

				header("Location: redirection.php?search=create_employee_sheet");

			} else {

				header("Location: Error_And_Management.php");

			}


		} else {

			if ( (empty($result[0]["user"]) || empty($idCase)) ||
				($result[0]["user"] !== $inPost["identifiant"])) {


				header("Location: ../index.html");
			}

			if ( (empty($result[0]["pass"]) || empty($inPost["password"])) ||
				 ($result[0]["pass"] !== $inPost["password"])) {

				header("Location: ../index.html");
			}

			exit(0);
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
			 return $dbh;

		}   catch (PDOException $e) {
			echo 'Connection failed ! : ' . $e->getMessage();
			die(__FILE__ . " " . __FUNCTION__ . " " . __LINE__);
			return NULL;
		}
	}