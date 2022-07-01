<?php
    if(isset($_GET)&&isset($_GET["view"])&&$_GET["view"]!=null){
        $product = SHOP::GetGoodsById($_GET["view"])[0];
    } else {
        ?>
            <script>window.location.href = "index.php"</script> 
        <?php
    }
    if(count($_POST)>0){
        ?>
            <script>
                let cart = [];
                let size = "<?php if(isset($_POST["size"])){print $_POST["size"];}?>";
                let total = "<?php echo $_POST["total"]?>";
                let price = "<?php echo $_POST["price"]?>";
                let shopItem = {id:<?php echo $_POST["ID"]?>,amount:<?php echo $_POST["amount"];if(isset($_POST["size"])){echo ',size:size';}?>,price:price,total:total};
                if(localStorage.getItem("cart")){
                    if(JSON.parse(localStorage.getItem("cart")).length<20){
                        let hasError = true
                        cart = JSON.parse(localStorage.getItem("cart"))
                        for (let i = 0; i < cart.length; i++) {
                            if(cart[i].id==<?php echo $_POST["ID"]?>){
                                hasError = false
                            }
                        }
                        if(hasError){
                            cart.unshift(shopItem)
                            localStorage.setItem("cart",JSON.stringify(cart));
                        }
                    }
                } else {
                    cart.unshift(shopItem)
                    localStorage.setItem("cart",JSON.stringify(cart))
                }
                window.location.href = window.location.href
            </script> 
        <?php
    }
?>
<main>
    <section class="product">
        <div class="container">
            <div class="photo">
                <img src="img/shop/<?php echo $product["ShopItemImages_Image"] ?>" alt="">
            </div>
            <div class="info">
                <h2 class="name"><?php echo $product["ShopItem_Name"] ?></h2>
                <?php 
                    if($product["ShopItem_Sizes"]!=null){
                    ?>
                    <h3 class="material">100% Cotton</h3>
                <?php
                    }
                ?>
                
                <p class="desc"><?php echo $product["ShopItem_Description"] ?></p>
                <div class="info_row">
                    <div class="amount">
                        <span class="m">-</span>
                        <span class="num">1</span>
                        <span class="b">+</span>
                    </div>
                    <h4 class="price">$<?php echo number_format($product["ShopItem_Price"], 2, ',', ' '); ?></h4>
                </div>
                <?php
                if($product["ShopItem_Sizes"]!=null){
                    $sizes = explode(",",$product["ShopItem_Sizes"]);
                    ?>
                    <div class="info_row sizes">
                        <div class="size">
                    <?php
                    for ($i=0; $i < count($sizes); $i++) { 
                        ?>
                        <button class='<?php if($i==0){echo "active";}?>'><?php echo $sizes[$i]?></button>
                        <?php
                    }
                    ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <form action="" method="post">
                    <input type="hidden" name="ID" value="<?php echo $product["ShopItem_ID"]?>">
                    <input type="hidden" name="amount" value="1">
                    <input type="hidden" name="price" value="<?php echo $product["ShopItem_Price"]?>">
                    <input type="hidden" name="total" value="$<?php echo number_format($product["ShopItem_Price"], 2, ',', ' '); ?>">
                    <?php
                        if($product["ShopItem_Sizes"]!=null){
                        ?>
                        <input type="hidden" name="size" value="<?php echo $sizes[0]?>">
                        <?php
                        }
                    ?>
                    <button type="submit">Add To Cart</button>
                </form>
                <a href="index.php?action=cart" class="cart">Shopping Cart</a>
            </div>
            
        </div>
    </section>
</main>