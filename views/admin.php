<?php
    if (isset($_SESSION["isAdmin"])&&$_SESSION["isAdmin"]==true){
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
                                <li><a class="buttn" href="index.php?action=admin&view=orders">Orders</a></li>
                                <li><a class="buttn" href="index.php?action=admin&view=addgoods">Add Goods</a></li>
                                <li><a class="buttn" href="index.php?action=admin&view=goods">Goods</a></li>
                                <li><a class="buttn" href="index.php?action=admin&view=personalSettings">Personal Settings</a></li>
                            </ul>
                        </aside>
                        <section class="content">
                            <?php
                            if(!empty($_POST)){
                                if(isset($_POST["action"])){
                                    if($_POST["action"]=="orders"){
                                        if(isset($_POST["isCheck"])&&$_POST["isCheck"]=="true"){
                                            ADMIN::CheckOrderById($_POST["check"]);
                                            ?>
                                            <script>
                                                window.location.href = window.location.href
                                            </script>
                                            <?php
                                        }
                                    } else if($_POST["action"]=="addgoods") {
                                        ADMIN::addGoods($_POST,$_FILES);
                                        ?>
                                        <script>
                                            window.location.href = window.location.href
                                        </script>
                                        <?php
                                    } else if($_POST["action"]=="goods") {
                                        if(isset($_POST["isDelete"])&&$_POST["isDelete"]=="true"){
                                            ADMIN::DeleteItemById($_POST["delete"]);
                                            ?>
                                            <script>
                                                window.location.href = window.location.href
                                            </script>
                                            <?php
                                        }
                                    } else if($_POST["action"]=="personalSettings") {
                                        ADMIN::SetUsername($_POST);
                                        if(strlen($_POST["oldPassword"])>0&&strlen($_POST["newPassword"])>0){
                                            $oldPasswordSimilarity = ADMIN::CheckOldPassword($_POST["oldPassword"]);
                                            if($oldPasswordSimilarity==true){
                                                ADMIN::SetPassword($_POST["newPassword"]);
                                            }
                                        }
                                        ?>
                                        <script>
                                            // window.location.href = window.location.href
                                        </script>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            <div class="content__block <?php if(empty($_GET["view"])){ echo 'active';} ?>" id="getStarted">
                                <h2 class="title">GET STARTED!</h2>
                                <h3>Now, you are ADMIN , and you can <br> see appointments and change site settings!</h3>
                                <p>For navigate, click on any button below, or find button on left menu.</p>
                                <div class="btns">
                                    <a class="buttn" href="index.php?action=admin&view=orders">Orders</a>
                                    <a class="buttn" href="index.php?action=admin&view=addgoods">Add Goods</a>
                                    <a class="buttn" href="index.php?action=admin&view=goods">Goods</a>
                                    <a class="buttn" href="index.php?action=admin&view=personalSettings">Personal Settings</a>
                                </div>
                            </div>
                            <div class="content__block <?php if(isset($_GET["view"])&&$_GET["view"]=="orders"){ echo 'active';} ?>" id="orders">
                            <?php 
                                if (!isset($_GET['page']) ) {  
                                    $page = 1;  
                                } else {  
                                    $page = $_GET['page'];  
                                } 
                                $results_per_page = 50;  
                                $page_first_result = ($page-1) * $results_per_page;  
                                $orders = ADMIN::getOrders($page_first_result,$results_per_page);
                                $allOrders = ADMIN::getAllOrders();
                                if(count($orders)>0){
                            ?>
                            <h2 class="title">Orders</h2>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td style="text-align:center;">№</td>
                                        <td class="name">Name</td>
                                        <td class="mail">Mail</td>
                                        <td class="phone">Phone</td>
                                        <td class="time">Time</td>
                                        <td class="act" style="justify-content:center;">Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for ($i=0; $i < count($orders); $i++) { 
                                    ?>  
                                        <tr>
                                            <td style="text-align:center;"><?php echo $orders[$i]["Order_ID"]?></td>
                                            <td class="name"><?php echo $orders[$i]["Order_Name"]?></td>
                                            <td class="mail">
                                                <?php if($orders[$i]["Order_Mail"]!=null){
                                                    ?>
                                                    <a href="mailto:<?php echo $orders[$i]["Order_Mail"]?>"><?php echo $orders[$i]["Order_Mail"]?></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                    Doesn`t Exist
                                                    <?php
                                                    }
                                                ?>        
                                            </td>
                                            <td class="phone"><a href="tel:<?php echo $orders[$i]["Order_Phone"]?>"><?php echo $orders[$i]["Order_Phone"]?></a></td>
                                            <td class="time">
                                                <?php 
                                                    $date = date_create($orders[$i]["Order_DateTime"]);
                                                    echo date_format($date, 'm-d-Y h:i:s A')
                                                ?>
                                            </td>
                                            <td class="act" style="justify-content:center;">
                                                <a class="view" href="index.php?action=viewOrder&id=<?php echo $orders[$i]["Order_ID"]?>"><img src="img/config/eye.png" alt="View"></a>
                                                <?php if($orders[$i]["Order_Checked"]==1){?>
                                                    <img src="img/config/checked.png" alt="Checked">
                                                <?php } else { ?>
                                                    <form action="" method="post" class="ordersCheckedForm">
                                                        <input type="hidden" name="action" value="orders">
                                                        <input type="hidden" name="check" value="<?php echo $orders[$i]["Order_ID"]?>">
                                                        <input type="hidden" name="isCheck" value="false">
                                                        <button type="submit">
                                                            <img src="img/config/checked.png" alt="Checked">
                                                        </button>
                                                    </form>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                                $results = ceil(count($allOrders) / $results_per_page);
                                if($results>1){
                                ?>
                                <div class="paginationBtns">
                                    <?php 
                                    if($page==$results&&$page-2>0){
                                        ?>
                                        <button link="index.php?action=admin&view=orders&page=<?php echo $page-2?>"><?php echo $page-2?></button>
                                        <?php
                                    }
                                    if($page>1){
                                        ?>
                                        <button link="index.php?action=admin&view=orders&page=<?php echo $page-1?>"><?php echo $page-1?></button>
                                        <?php
                                    }   
                                    ?>
                                    <button class="noactive"><?php echo $page?></button>
                                    <?php 
                                    if($page<$results){
                                        ?>
                                        <button link="index.php?action=admin&view=orders&page=<?php echo $page+1?>"><?php echo $page+1?></button>
                                        <?php
                                    }
                                    if($page==1&&$results>2){
                                        ?>
                                        <button link="index.php?action=admin&view=orders&page=<?php echo $page+2?>"><?php echo $page+2?></button>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                }
                            } else{
                                ?>
                                    <h2 class="title">YOU DON`T HAVE ORDERS!</h2>
                                <?php
                            } 
                            ?>
                            </div>
                            <div class="content__block <?php if(isset($_GET["view"])&&$_GET["view"]=="addgoods"){ echo 'active';} ?>" id="addgoods">
                                <h2 class="title">Add Goods</h2>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="addgoods">
                                    <div class="form__block">
                                        <label class="main">Photo</label>
                                        <input type="file" name="photo" required>
                                    </div>
                                    <div class="form__block">
                                        <label class="main">Name</label>
                                        <input type="text" name="name" maxlength="100" required placeholder="Enter name">
                                    </div>
                                    <div class="form__block">
                                        <label class="main">Description</label>
                                        <textarea name="desc" maxlength="500" required placeholder="Enter description"></textarea>
                                    </div>
                                    <div class="form__block">
                                        <label class="main">Category</label>
                                        <select name="cat" id="cat" required class="cat">
                                            <option disabled>Select Category</option>
                                        <?php
                                            $categories = CATEGORY::GetAllCategories();
                                            for ($i=0; $i < count($categories); $i++) { 
                                            ?>
                                            <option value="<?php echo $categories[$i]["Category_ID"] ?>"><?php echo $categories[$i]["Category_Name"] ?></option>
                                            <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="form__block">
                                        <label class="main">Price</label>
                                        <input type="number" name="price" required step="0.01" placeholder="Enter price" max="999999999">
                                    </div>
                                    <div class="form__block sizes active">
                                        <label class="main">Sizes</label>
                                        <div class="inputs">
                                            <div class="input">
                                                <input type="checkbox" id="xs" name="sizexs" value="xs">
                                                <label for="xs">XS</label>
                                            </div>
                                            <div class="input">
                                                <input type="checkbox" id="s" name="sizes" value="s">
                                                <label for="s">S</label>
                                            </div>
                                            <div class="input">
                                                <input type="checkbox" id="m" name="sizem" value="m">
                                                <label for="m">M</label>
                                            </div>
                                            <div class="input">
                                                <input type="checkbox" id="l" name="sizel" value="l">
                                                <label for="l">L</label>
                                            </div>
                                            <div class="input">
                                                <input type="checkbox" id="xl" name="sizexl" value="xl">
                                                <label for="xl">XL</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__block">
                                        <button type="submit">Add Item</button>
                                    </div>
                                </form>
                            </div>
                            <div class="content__block <?php if(isset($_GET["view"])&&$_GET["view"]=="goods"){ echo 'active';} ?>" id="goods">
                            <?php 
                                if (!isset($_GET['page']) ) {  
                                    $page = 1;  
                                } else {  
                                    $page = $_GET['page'];  
                                } 
                                $results_per_page = 50;  
                                $page_first_result = ($page-1) * $results_per_page;  
                                $items = ADMIN::getItems($page_first_result,$results_per_page);
                                $allItems = ADMIN::getAllItems();
                                if(count($items)>0){
                            ?>
                            <h2 class="title">All Goods</h2>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td style="text-align:center; width:10%">№</td>
                                        <td class="name" style="width:60%">Name</td>  
                                        <td class="time" style="text-align:center; width:30%">Time</td>
                                        <td class="act" style="justify-content:center">Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for ($i=0; $i < count($items); $i++) { 
                                    ?>  
                                        <tr>
                                            <td style="text-align:center;"><?php echo $items[$i]["ShopItem_ID"]?></td>
                                            <td class="name" style="flex:1 1 auto"><?php echo $items[$i]["ShopItem_Name"]?></td>
                                            <td class="time" style="text-align:center;">
                                                <?php 
                                                    $date = date_create($items[$i]["ShopItem_AddTime"]);
                                                    echo date_format($date, 'm-d-Y h:i:s A')
                                                ?>
                                            </td>
                                            <td class="act" style="justify-content:center;">
                                                <a class="view" href="index.php?action=viewGood&id=<?php echo $items[$i]["ShopItem_ID"]?>"><img src="img/config/eye.png" alt="View"></a>
                                                <form action="" method="post" class="goodsDeleteForm">
                                                    <input type="hidden" name="action" value="goods">
                                                    <input type="hidden" name="delete" value="<?php echo $items[$i]["ShopItem_ID"]?>">
                                                    <input type="hidden" name="isDelete" value="false">
                                                    <button type="submit">  
                                                        <img src="img/config/delete.png" alt="Delete">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                                $results = ceil(count($allItems) / $results_per_page);
                                if($results>1){
                                ?>
                                <div class="paginationBtns">
                                    <?php 
                                    if($page==$results&&$page-2>0){
                                        ?>
                                        <button link="index.php?action=admin&view=goods&page=<?php echo $page-2?>"><?php echo $page-2?></button>
                                        <?php
                                    }
                                    if($page>1){
                                        ?>
                                        <button link="index.php?action=admin&view=goods&page=<?php echo $page-1?>"><?php echo $page-1?></button>
                                        <?php
                                    }   
                                    ?>
                                    <button class="noactive"><?php echo $page?></button>
                                    <?php 
                                    if($page<$results){
                                        ?>
                                        <button link="index.php?action=admin&view=goods&page=<?php echo $page+1?>"><?php echo $page+1?></button>
                                        <?php
                                    }
                                    if($page==1&&$results>2){
                                        ?>
                                        <button link="index.php?action=admin&view=goods&page=<?php echo $page+2?>"><?php echo $page+2?></button>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                }
                            } else{
                                ?>
                                    <h2 class="title">YOU DON`T HAVE GOODS!</h2>
                                <?php
                            } 
                            ?>
                            </div>
                            <div class="content__block <?php if(isset($_GET["view"])&&$_GET["view"]=="personalSettings"){ echo 'active';} ?>" id="personalSettings">
                                <?php $adminUsername = ADMIN::GetUsername();?>
                                <h2 class="title">Personal Settings!</h2>
                                <form action="" method="post" id="personalSettings">
                                    <input type="hidden" name="action" value="personalSettings">
                                    <div class="content__block__child">
                                        <p><img src="img/config/user.png" alt="User">Username</p>
                                        <input type="text" name="login" required minlength="4" placeholder="Username" id="login" value="<?php echo $adminUsername[0]["Users_Username"]?>">
                                    </div>
                                    <div class="content__block__child passwordRecovery">
                                        <div class="head">
                                            <p><img src="img/config/lock.png" alt="Password">Password</p>
                                            <a class="passwordRecoveryOpen"><img src="img/config/pencil.png" alt="Password">Change Password</a>
                                        </div>
                                        <div class="passwordRecovery <?php if(isset($oldPasswordSimilarity)&&$oldPasswordSimilarity==false){ echo "active" ;}?>">
                                            <div class="inputBlock">
                                                <p <?php if(isset($oldPasswordSimilarity)&&$oldPasswordSimilarity==false){ echo "class='error'"; }?>><?php if(isset($oldPasswordSimilarity)&&$oldPasswordSimilarity==false){ echo "Invalid"; }?> Old Password</p>
                                                <div class="input">
                                                    <input type="password" name="oldPassword" minlength="8" maxlength="32" placeholder="Old Password" <?php if(isset($oldPasswordSimilarity)&&$oldPasswordSimilarity==false){ echo "class='error'"; }?>>
                                                    <i class='bx bx-low-vision passwordImg'></i>
                                                    <img src="img/config/eye.png" alt="Password" class="passwordImg active">
                                                </div>
                                            </div>
                                            <div class="inputBlock">
                                                <p>New Password</p>
                                                <div class="input">
                                                    <input type="password" name="newPassword" minlength="8" maxlength="32" placeholder="New Password">
                                                    <i class='bx bx-low-vision passwordImg'></i>
                                                    <img src="img/config/eye.png" alt="Password" class="passwordImg active">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="buttn">Save Changes</button>
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
    <script>window.location.href = "index.php?action=404"</script> 
<?php
    }
?>