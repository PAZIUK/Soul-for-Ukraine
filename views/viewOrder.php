<?php
    if (isset($_SESSION["isAdmin"])&&$_SESSION["isAdmin"]==true){
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
                }
            }
        }
        if(isset($_GET["goods"])&&$_GET["goods"]=="true"){
        ?>
        <main>
            <section class="cart">
                <div class="container">
                    <div class="title">- Order Goods -</div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="item">Item</th>
                                <th scope="col" class="textCenter price">Price</th>
                                <th scope="col" class="textCenter quantity">Quantity</th>
                                <th scope="col" class="textCenter total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cart = SHOP::GetGoodsByOrder($_GET["id"]);
                            for ($i=0; $i < count($cart); $i++) { 
                                ?>
                                <tr>
                                    <td class="item">
                                        <div class="block">
                                            <div class="photo"><img src="img/shop/<?php echo $cart[$i]["ShopItemImages_Image"]?>" alt="Item Image"></div>
                                            <div class="info">
                                                <div class="name"><?php echo mb_strimwidth($cart[$i]["ShopItem_Name"], 0, 30,"..");?></div>
                                                <?php 
                                                if($cart[$i]["orderDetails_Size"]!=null){
                                                    ?>
                                                    <div class="size">Size: <span><?php echo $cart[$i]["orderDetails_Size"]?></span></div>
                                                    <?php
                                                }?>
                                                <div class="num">SKU: <?php echo $cart[$i]["ShopItem_ID"]?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="textCenter price">$<?php echo number_format($cart[$i]["orderDetails_Price"], 2, ',', ' '); ?></td>
                                    <td class="textCenter quantity"><?php echo $cart[$i]["orderDetails_Amount"]?></td>
                                    <td class="textCenter total"><?php echo $cart[$i]["orderDetails_Total"]?></td>
                                </tr>
                                <?php
                            }                    
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="item">
                                    Total:  <span class="num"></span>
                                </td>
                                <td class="textCenter price"></td>
                                <td class="textCenter quantity"></td>
                                <td class="textCenter total">$</td>
                                <td class="textCenter remove"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </main>
        <?php
        } else {
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
                                <li><a class="buttn" href="index.php?action=admin&view=orders"><img src="img/config/left-arrow.png" alt="Arrow"> Go Back</a></li>
                            </ul>
                        </aside>
                        <section class="content">
                            <?php
                            if(!empty($_POST)){
                                if(isset($_POST["action"])){
                                    if($_POST["action"]=="orders"){
                                        if(isset($_POST["isCheck"])&&$_POST["isCheck"]=="true"){
                                            ADMIN::CheckOrderById($_POST["check"]);
                                        }
                                    }
                                }
                            }
                            if(isset($_GET["id"])){
                                $ID = $_GET["id"];
                            }
                            ?>
                            <div class="content__block active" id="orders">
                                <?php $order = ADMIN::getOrderById($ID);
                                    if($order!=null){
                                        $order = $order[0];
                                ?>
                                <h2 class="title">Order №<?php echo $ID?></h2>
                                <div class="applicationAbout">
                                    <div class="applicationAbout__row">
                                        <p>№</p>
                                        <p><?php echo $order["Order_ID"]?></p>
                                    </div>
                                    <div class="applicationAbout__row">
                                        <p>Name</p>
                                        <p><?php echo $order["Order_Name"]?></p>
                                    </div>
                                    <div class="applicationAbout__row">
                                        <p>Email</p>
                                        <?php if($order["Order_Mail"]!=null){
                                            ?>
                                            <a href="mailto:<?php echo $order["Order_Mail"]?>"><?php echo $order["Order_Mail"]?></a>
                                            <?php
                                            } else {
                                            ?>
                                            <p>Doesn`t Exist</p>
                                            <?php
                                            }
                                        ?>  
                                    </div>
                                    <div class="applicationAbout__row">
                                        <p>Phone</p>
                                        <a href="tel:<?php echo $order["Order_Phone"]?>"><?php echo $order["Order_Phone"]?></a>
                                    </div>
                                    <div class="applicationAbout__row">
                                        <p>Comments</p>
                                        <p><?php if(strlen($order["Order_Comments"])>0){echo $order["Order_Comments"];} else {echo "Doesn`t Exist";}?></p>
                                    </div>
                                    <div class="applicationAbout__row">
                                        <p>Time</p>
                                        <p>
                                        <?php 
                                            $date = date_create($order["Order_DateTime"]);
                                            echo date_format($date, 'm-d-Y  h:i:s A')
                                        ?>
                                        </p>
                                    </div>
                                    <div class="applicationAbout__row goods">
                                        <p>Goods</p>
                                        <a href="index.php?action=viewOrder&id=<?php echo $ID?>&goods=true"><img src="img/config/eye.png" alt="View"></a>
                                    </div>
                                    <div class="applicationAbout__row submit">
                                        <?php if($order["Order_Checked"]==1){?>
                                            <img src="img/config/check-box.png" alt="Checked">
                                        <?php } else { ?>
                                            <form action="" method="post" class="ordersCheckedForm">
                                                <input type="hidden" name="action" value="orders">
                                                <input type="hidden" name="check" value="<?php echo $order["Order_ID"]?>">
                                                <input type="hidden" name="isCheck" value="true">
                                                <button type="submit">CHECK</button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                                } else{
                                    ?>
                                        <script>window.location.href = "index.php?action=admin"</script> 
                                    <?php
                                } 
                                ?>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
            <script src="js/admin.js"></script>
        </main>
        <?php 
        }       
    } else { 
?>
    <script>window.location.href = "index.php?action=404"</script> 
<?php
    }
?>