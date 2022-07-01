<?php
	class SHOP
	{
		public static function GetNewGoods(){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `shopitems` INNER JOIN `shopitemimages` ON shopitems.ShopItem_Images=shopitemimages.ShopItemImages_ID ORDER by shopitems.ShopItem_AddTime DESC LIMIT 8";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			$myResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			return $myResult;
		}
		public static function GetGoodsByFilter($get){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `shopitems` INNER JOIN `shopitemimages` ON shopitems.ShopItem_Images=shopitemimages.ShopItemImages_ID WHERE shopitems.ShopItem_ID > 0";
			if(isset($get["categories"])&&$get["categories"]!="all"){
				$category = $get["categories"];
				$sql = $sql." AND `shopitems`.`ShopItem_Category` = $category";
			}
			// if(isset($get["search"])){
			// 	$search = "%".$get["search"]."%";
			// 	$sql = $sql." AND shopitems.ShopItem_Name LIKE '$search'";
			// }
			if(isset($get["sort"])){
				$sort = $get["sort"];
				switch ($sort) {
					case "plth":
						$sql = $sql." ORDER by shopitems.ShopItem_Price ASC";
						break;
					case "phtl":
						$sql = $sql." ORDER by shopitems.ShopItem_Price DESC";
						break;
					case "dotn":
						$sql = $sql." ORDER by shopitems.ShopItem_AddTime ASC";
						break;
					case "dnto":
						$sql = $sql." ORDER by shopitems.ShopItem_AddTime DESC";
						break;
				}
			}
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			$myResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			return $myResult;
		}
		public static function GetGoodsById($id){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `shopitems` INNER JOIN `shopitemimages` ON shopitems.ShopItem_Images=shopitemimages.ShopItemImages_ID WHERE shopitems.ShopItem_ID = ? ORDER by shopitems.ShopItem_AddTime DESC";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$myResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			return $myResult;
		}
		public static function GetGoodsByIds($ids){
			$idsSql = "";
			for ($i=0; $i < count($ids); $i++) { 
				if(count($ids)==1){
					$idsSql = $idsSql."(".$ids[$i].")";
				} else {
					if($i==0){
						$idsSql = $idsSql."(".$ids[$i].",";
					} else if ($i+1==count($ids)){
						$idsSql = $idsSql.$ids[$i].")";
					} else {
						$idsSql = $idsSql.$ids[$i].",";
					}
				}
			}
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `shopitems` INNER JOIN `shopitemimages` ON shopitems.ShopItem_Images=shopitemimages.ShopItemImages_ID WHERE shopitems.ShopItem_ID IN ";
			$sql = $sql.$idsSql;
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			$myResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			return $myResult;
		}
		public static function sendOrder($post){
			$mysqli = DATABASE::Connect();
			$sql = "INSERT INTO `orders` (`Order_Name`, `Order_Mail`, `Order_Phone`, `Order_Comments`) VALUES (?, ?, ?, ?)";
			$stmt = $mysqli->prepare($sql);
			$name = trim($post["name"])." ".trim($post["surname"]);
			$stmt->bind_param('ssss',$name,$post["mail"],$post["phone"],$post["comments"]);
			$stmt->execute();

			$sql = "SELECT LAST_INSERT_ID();";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			$id = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["LAST_INSERT_ID()"];

			$cart = json_decode($post["shoppingCart"],true);
			$sql = "INSERT INTO `orderdetails` (`orderDetails_OrderId`, `orderDetails_ShopItemId`, `orderDetails_Amount`, `orderDetails_Size`, `orderDetails_Price`, `orderDetails_Total`) VALUES (?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($sql);
			for ($i=0; $i < count($cart); $i++) { 
				$stmt->bind_param('iiisds',$id,$cart[$i]["id"],$cart[$i]["amount"],$cart[$i]["size"],$cart[$i]["price"],$cart[$i]["total"]);
				$stmt->execute();
			}
		}
		public static function GetGoodsByOrder($id){
			$mysqli = DATABASE::Connect();
			$sql = "SELECT * FROM `orderdetails` INNER JOIN `orders` ON `orderdetails`.`orderDetails_OrderId` = `orders`.`Order_ID` INNER JOIN `shopitems` ON `orderdetails`.`orderDetails_ShopItemId` = `shopitems`.`ShopItem_ID` INNER JOIN `shopitemimages` ON `shopitemimages`.`ShopItemImages_ID` = `shopitems`.`ShopItem_Images` WHERE `orders`.`Order_ID` = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('i',$id);
			$stmt->execute();
			$myResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			return $myResult;
		}
	}
?>