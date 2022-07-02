<?php 
    if(strlen($_SESSION["Cart"])>0){
        $_POST["Cart"] = $_SESSION["Cart"];
    } else {
        ?>
            <script>window.location.href = "index.php?action=404"</script> 
        <?php
    }
?>
<main>
    <section class="order">
        <div class="container">
            <div class="title">- Make An Order -</div>
            <div class="order__block">
                <div class="contacts">
                    <div class="title">Contacts</div>
                    <form action="index.php?action=orderSent" method="post">
                        <div class="input_block">
                            <p class="s">First name</p>
                            <input type="text" name="name" placeholder="Enter first name" required maxlength="32" onkeypress="noDigits(event)"> 
                        </div>
                        <div class="input_block">
                            <p class="s">Last name</p>
                            <input type="text" name="surname" placeholder="Enter last name" required maxlength="32" onkeypress="noDigits(event)">
                        </div>
                        <div class="input_block">
                            <p>Email</p>
                            <input type="mail" name="mail" placeholder="Enter email">
                        </div>
                        <div class="input_block">
                            <p class="s">Phone Number</p>
                            <input type="text" minlength="10" placeholder="Enter phone Number , ex. +12345677890" required name="phone" pattern="+1[0-9]{10}">
                        </div>
                        <div class="input_block">
                            <p>Comments</p>
                            <textarea name="comments" id="comments" placeholder="Some Comments" maxlength="500"></textarea>
                        </div>
                        <input type="hidden" value="true" name="sentOrder">
                        <input type="hidden" value='<?php echo $_POST["Cart"]?>' name="shoppingCart">
                        <button type="submit">Make An Order</button>
                    </form>
                </div>
                <div class="shoppingCart">
                    <div class="title">Shopping Cart</div>
                    <?php 
                        $ids = [];
                        $newCart = json_decode($_POST["Cart"],true);
                        if(count($newCart)>0){
                            for ($i=0; $i < count($newCart); $i++) { 
                                array_push($ids,$newCart[$i]["id"]);
                            }
                            $cart = SHOP::GetGoodsByIds($ids);
                    ?>
                    <div class="products">
                        <div class="top">
                            <div class="photo"></div>
                            <div class="name">Name</div>
                            <div class="price">Price</div>
                            <div class="amount">Amount</div>
                            <div class="total">Total</div>
                        </div>
                        <?php
                            for ($ind=0; $ind < count($newCart); $ind++) { 
                                for ($i=0; $i < count($cart); $i++) { 
                                    if($newCart[$ind]["id"]==$cart[$i]["ShopItem_ID"]){
                                    ?>
                                    <div class="product">
                                        <div class="photo"><img src="img/shop/<?php echo $cart[$i]["ShopItemImages_Image"]?>" alt="Item photo"></div>
                                        <div class="name"><?php echo mb_strimwidth($cart[$i]["ShopItem_Name"], 0, 30,"..")?></div>
                                        <div class="price">$<?php echo number_format($newCart[$ind]["price"], 2, ',', ' '); ?></div>
                                        <div class="amount"><?php echo $newCart[$ind]["amount"]?></div>
                                        <div class="total"><?php echo $newCart[$ind]["total"]?></div>
                                    </div>
                                    <?php
                                    }
                                }
                            } 
                        }
                        ?>
                    </div>
                    <div class="totalPrice">Total: <span class="num">$</span></div>
                </div>
            </div>
        </div>
    </section>
</main>