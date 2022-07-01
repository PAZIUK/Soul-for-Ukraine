<?php
	class CATEGORY
	{
		public static function GetAllCategories(){
			$mysqli = DATABASE::Connect();
            $sql = "SELECT * FROM `category`";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			$myResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            return $myResult;
		}
	}
?>