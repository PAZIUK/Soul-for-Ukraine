<?php
    if (isset($_SESSION["isAdmin"])&&$_SESSION["isAdmin"]==true){
        if(count($_POST)>0&&isset($_POST["change"])&&$_POST["change"]=="true"){
            ADMIN::changeGoods($_POST,$_FILES);
            ?>
                <script>window.location.href = window.location.href</script> 
            <?php
        }
        if(isset($_GET["id"])){
            $ID = $_GET["id"];
            $item = ADMIN::getItemById($ID);
            if($item!=null){
                $item = $item[0];
                ?>
                <main id="admin">
                    <section class="admin">
                        <div class="blur"></div>
                        <div class="container">
                            <div class="block">
                                <aside>
                                    <a href="index.php" class="logo">
                                        <img src="img/config/logo.png" alt="Logo">
                                        <h2 class="name">Soul for Ukraine</h2>
                                    </a>
                                    <ul class="actions">
                                        <li><a class="buttn" href="index.php?action=admin&view=goods"><img src="img/config/left-arrow.png" alt="Arrow"> Go Back</a></li>
                                    </ul>
                                </aside>
                                <section class="content">
                                    <div class="content__block active" id="goods">
                                        <h2 class="title">Item №<?php echo $ID?></h2>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="change" value="true">
                                            <input type="hidden" name="ID" value="<?php echo $item["ShopItem_ID"]?>">
                                            <input type="hidden" name="PhotoID" value="<?php echo $item["ShopItemImages_ID"]?>">
                                            <div class="applicationAbout">
                                                <div class="applicationAbout__row">
                                                    <p>№</p>
                                                    <p><?php echo $item["ShopItem_ID"]?></p>
                                                </div>
                                                <div class="applicationAbout__row photo">
                                                    <p>Photo</p></p>
                                                    <div class="photo"><img src="img/shop/<?php echo $item["ShopItemImages_Image"] ?>" alt=""></div>
                                                    <div class="change">
                                                        <input type="file" name="photo">
                                                        <a class="changeBtn">Change</a>
                                                    </div>
                                                </div>
                                                <div class="applicationAbout__row">
                                                    <p>Name</p>
                                                    <input type="text" name="name" maxlength="100" required placeholder="Enter Name" value="<?php echo $item["ShopItem_Name"]?>">
                                                </div>
                                                <div class="applicationAbout__row">
                                                    <p>Description</p>
                                                    <textarea name="description" placeholder="Enter Description"><?php echo $item["ShopItem_Description"]?></textarea>
                                                </div>
                                                <div class="applicationAbout__row">
                                                    <p>Category</p>
                                                    <select name="cat" id="cat" required class="cat">
                                                        <option disabled>Select Category</option>
                                                    <?php
                                                        $categories = CATEGORY::GetAllCategories();
                                                        for ($i=0; $i < count($categories); $i++) { 
                                                        ?>
                                                        <option value="<?php echo $categories[$i]["Category_ID"] ?>" <?php if($categories[$i]["Category_ID"]==$item["ShopItem_Category"]){echo"selected";}?>><?php echo $categories[$i]["Category_Name"] ?></option>
                                                        <?php
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="applicationAbout__row">
                                                    <p>Price</p>
                                                    <input type="number" name="price" required step="0.01" placeholder="Enter Price" value="<?php echo $item["ShopItem_Price"]?>">
                                                </div>
                                                <div class="applicationAbout__row sizes <?php if($item["ShopItem_Category"]==1||$item["ShopItem_Category"]==2){echo "active";}?>">
                                                    <p>Sizes</p>
                                                    <?php 
                                                        $allSizes = $item["ShopItem_Sizes"];
                                                        $sizes = [];
                                                        if($allSizes!=null){
                                                            $sizes = explode(",",$allSizes);
                                                        }
                                                    ?>
                                                    <div class="inputs">
                                                        <div class="input">
                                                            <input type="checkbox" id="xs" name="sizexs" value="xs" <?php if(in_array("XS",$sizes)){echo "checked";}?>>
                                                            <label for="xs">XS</label>
                                                        </div>
                                                        <div class="input">
                                                            <input type="checkbox" id="s" name="sizes" value="s" <?php if(in_array("S",$sizes)){echo "checked";}?>>
                                                            <label for="s">S</label>
                                                        </div>
                                                        <div class="input">
                                                            <input type="checkbox" id="m" name="sizem" value="m" <?php if(in_array("M",$sizes)){echo "checked";}?>>
                                                            <label for="m">M</label>
                                                        </div>
                                                        <div class="input">
                                                            <input type="checkbox" id="l" name="sizel" value="l" <?php if(in_array("L",$sizes)){echo "checked";}?>>
                                                            <label for="l">L</label>
                                                        </div>
                                                        <div class="input">
                                                            <input type="checkbox" id="xl" name="sizexl" value="xl" <?php if(in_array("XL",$sizes)){echo "checked";}?>>
                                                            <label for="xl">XL</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="applicationAbout__row">
                                                    <p>Time</p>
                                                    <p>
                                                    <?php 
                                                        $date = date_create($item["ShopItem_AddTime"]);
                                                        echo date_format($date, 'm-d-Y  h:i:s A')
                                                    ?>
                                                    </p>
                                                </div>
                                                <div class="applicationAbout__row submit">
                                                    <button type="submit">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </section>
                    <script src="js/admin.js"></script>
                </main>
                <?php
            } else {
                ?>
                    <script>window.location.href = "index.php?action=admin"</script> 
                <?php
            }
        }        
    } else { 
?>
    <script>window.location.href = "index.php?action=404"</script> 
<?php
    }
?>