<?php 
	class USER
	{
		public static function getUserByLogin($login){
			$mysqli = DATABASE::Connect();
            $mysqli->set_charset("utf8mb4");
			$sql = "SELECT * FROM users WHERE Users_Username = ?"; // SQL with parameters
			$stmt = $mysqli->prepare($sql); 
			$stmt->bind_param("s", $login);
			$stmt->execute();
			$result = $stmt->get_result();
			$user = $result->fetch_assoc();
			return $user;
		}
	}	
?>