<?php 
	class ADMIN
	{
		public static function getOrders($start,$end){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `orders` ORDER BY `orders`.`Order_Checked` ASC, `orders`.`Order_DateTime` DESC LIMIT ?,?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("ii",$start,$end);
			$stmt->execute();
			return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		}
		public static function getOrderById($id){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `orders` WHERE `orders`.`Order_ID` = $id";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		}
		public static function CheckOrderById($id){
			$mysqli = DATABASE::Connect();
			$sql = "UPDATE `orders` SET `orders`.`Order_Checked` = 1 WHERE `orders`.`Order_ID` = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("i",$id);
			$stmt->execute();
		}
		public static function getAllOrders(){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `orders`";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		}
		public static function addGoods($post,$files){
			$imgtype = explode(".",$_FILES['photo']['name']);
			$imgtype = $imgtype[count($imgtype)-1];
			$imagename = md5($_FILES['photo']['name']);
			$imagetemp = $_FILES['photo']['tmp_name'];
			$imagePath = "img/shop/";
			$fullImageName = $imagename . "." . $imgtype;
			if(is_uploaded_file($imagetemp)) {
				move_uploaded_file($imagetemp, $imagePath . $fullImageName);
			}

			$mysqli = DATABASE::Connect();
			$sql = "INSERT INTO `shopitemimages` (`ShopItemImages_Image`) VALUES (?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("s",$fullImageName);
			$stmt->execute();

			$sql = "SELECT LAST_INSERT_ID();";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			$img = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["LAST_INSERT_ID()"];

			$sizesArr = [];
			if(($post["cat"]==1||$post["cat"]==2)&&isset($post["sizexs"])){array_push($sizesArr,"XS");};
			if(($post["cat"]==1||$post["cat"]==2)&&isset($post["sizes"])){array_push($sizesArr,"S");};
			if(($post["cat"]==1||$post["cat"]==2)&&isset($post["sizem"])){array_push($sizesArr,"M");};
			if(($post["cat"]==1||$post["cat"]==2)&&isset($post["sizel"])){array_push($sizesArr,"L");};
			if(($post["cat"]==1||$post["cat"]==2)&&isset($post["sizexl"])){array_push($sizesArr,"XL");};
			if(($post["cat"]==1||$post["cat"]==2)&&count($sizesArr)==0){array_push($sizesArr,"XS,S,M,L,XL");};
			$sizes = implode(",",$sizesArr);
			$sql = "INSERT INTO `shopitems` (`ShopItem_Name`, `ShopItem_Description`, `ShopItem_Images`, `ShopItem_Category`, `ShopItem_Price`, `ShopItem_Sizes`) VALUES (?,?,?,?,?,?);";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("ssiids",$post["name"],$post["desc"],$img,$post["cat"],$post["price"],$sizes);
			$stmt->execute();
		}
		public static function changeGoods($post,$files){
			$mysqli = DATABASE::Connect();
			$img = $post["PhotoID"];
			if($files["photo"]["size"]>0){
				$imgtype = explode(".",$_FILES['photo']['name']);
				$imgtype = $imgtype[count($imgtype)-1];
				$imagename = md5($_FILES['photo']['name']);
				$imagetemp = $_FILES['photo']['tmp_name'];
				$imagePath = "img/shop/";
				$fullImageName = $imagename . "." . $imgtype;
				if(is_uploaded_file($imagetemp)) {
					move_uploaded_file($imagetemp, $imagePath . $fullImageName);
				}

				$sql = "INSERT INTO `shopitemimages` (`ShopItemImages_Image`) VALUES (?)";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param("s",$fullImageName);
				$stmt->execute();

				$sql = "SELECT LAST_INSERT_ID();";
				$stmt = $mysqli->prepare($sql);
				$stmt->execute();
				$img = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["LAST_INSERT_ID()"];
			}

			$sizesArr = [];
			if(($post["cat"]==1||$post["cat"]==2)&&isset($post["sizexs"])){array_push($sizesArr,"XS");};
			if(($post["cat"]==1||$post["cat"]==2)&&isset($post["sizes"])){array_push($sizesArr,"S");};
			if(($post["cat"]==1||$post["cat"]==2)&&isset($post["sizem"])){array_push($sizesArr,"M");};
			if(($post["cat"]==1||$post["cat"]==2)&&isset($post["sizel"])){array_push($sizesArr,"L");};
			if(($post["cat"]==1||$post["cat"]==2)&&isset($post["sizexl"])){array_push($sizesArr,"XL");};
			if(($post["cat"]==1||$post["cat"]==2)&&count($sizesArr)==0){array_push($sizesArr,"XS,S,M,L,XL");};
			$sizes = implode(",",$sizesArr);
			$sql = "UPDATE `shopitems` SET `ShopItem_Name` = ?, `ShopItem_Description` = ?, `ShopItem_Images` = ?, `ShopItem_Category` = ?, `ShopItem_Price` = ?, `ShopItem_Sizes` = ? WHERE `shopitems`.`ShopItem_ID` = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("ssiidsi",$post["name"],$post["description"],$img,$post["cat"],$post["price"],$sizes,$post["ID"]);
			$stmt->execute();
		}
		public static function getItems($start,$end){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `shopitems` ORDER BY `shopitems`.`ShopItem_AddTime` DESC LIMIT ?,?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("ii",$start,$end);
			$stmt->execute();
			return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		}
		public static function getAllItems(){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `shopitems`";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		}
		public static function DeleteItemById($id){
			$mysqli = DATABASE::Connect();
			$sql = "DELETE FROM `shopitems` WHERE `shopitems`.`ShopItem_ID` = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("i",$id);
			$stmt->execute();
		}
		public static function getItemById($id){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `shopitems` INNER JOIN `category` ON `category`.`Category_ID`=`shopitems`.`ShopItem_Category` INNER JOIN `shopitemimages` ON `shopitemimages`.`ShopItemImages_ID`=`shopitems`.`ShopItem_Images` WHERE `shopitems`.`ShopItem_ID` = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("i",$id);
			$stmt->execute();
			return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		}
		public static function SetUsername($POST){
			$mysqli = DATABASE::Connect();
			$sql = "UPDATE `users` SET `users`.`Users_Username` = ? WHERE `users`.`Users_ID` = 1";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("s",$POST["login"]);
			$stmt->execute();
		}
		public static function CheckOldPassword($password){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT `users`.`Users_Password` FROM `users` WHERE `users`.`Users_ID` = 1";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			$passwordDB = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["Users_Password"];
			return password_verify($password, $passwordDB);
		}
		public static function SetPassword($password){
			$hashPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
			$mysqli = DATABASE::Connect();
			$sql = "UPDATE `users` SET `users`.`Users_Password` = ? WHERE`users`.`Users_ID` = 1";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("s",$hashPassword);
			$stmt->execute();
			return $hashPassword;
		}
		public static function GetUsername(){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT `users`.`Users_Username` FROM `users` WHERE `users`.`Users_ID` = 1";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		}
		public static function GetPassword(){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT `users`.`Users_Password` FROM `users` WHERE `users`.`Users_ID` = 1";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		}
		public static function returnToAdminHome(){
			?>
				<script>window.location.href = "index.php?action=admin"</script> 
			<?php 
		}
	}	
?>