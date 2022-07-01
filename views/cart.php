<script>
    if(JSON.parse(localStorage.getItem("cart"))!=null){
        $.ajax({
            url: window.location.href,
            method: "POST",            
            data: {Cart:localStorage.getItem("cart")},         
            dataType: "html",         
            success: function (data) {
                $('main').html($(data).filter('main').html());
                $("body").append("<footer id='footer'>"+$(data).filter("#footer").html()+"</div>");
            },
        });
    } else {
        window.location.href = "index.php"
    }
</script>
<main>
    <section class="cart">
        <div class="container">
            <div class="title">- Shopping Cart -</div>
            <?php 
                $ids = [];
                $newCart = json_decode($_POST["Cart"],true);
                if(count($newCart)>0){
                    for ($i=0; $i < count($newCart); $i++) { 
                        array_push($ids,$newCart[$i]["id"]);
                    }
                    $cart = SHOP::GetGoodsByIds($ids);
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="item">Item</th>
                                <th scope="col" class="textCenter price">Price</th>
                                <th scope="col" class="textCenter quantity">Quantity</th>
                                <th scope="col" class="textCenter total">Total</th>
                                <th scope="col" class="textCenter remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($ind=0; $ind < count($newCart); $ind++) { 
                                for ($i=0; $i < count($cart); $i++) { 
                                    if($newCart[$ind]["id"]==$cart[$i]["ShopItem_ID"]){
                                    ?>
                                    <tr>
                                        <td class="item">
                                            <div class="block">
                                                <div class="photo"><img src="img/shop/<?php echo $cart[$i]["ShopItemImages_Image"]?>" alt="Item Image"></div>
                                                <div class="info">
                                                    <div class="name"><?php echo mb_strimwidth($cart[$i]["ShopItem_Name"], 0, 30,"..");?></div>
                                                    <?php 
                                                    if($cart[$i]["ShopItem_Sizes"]!=null){
                                                        ?>
                                                        <div class="size">Size: <span><?php if($newCart[$ind]["id"]==$cart[$i]["ShopItem_ID"]){ echo $newCart[$ind]["size"];}?></span></div>
                                                        <?php
                                                    }?>
                                                    <div class="num">SKU: <?php echo $cart[$i]["ShopItem_ID"]?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="textCenter price">$<?php echo number_format($newCart[$ind]["price"], 2, ',', ' '); ?></td>
                                        <td class="textCenter quantity"><?php echo $newCart[$ind]["amount"]?></td>
                                        <td class="textCenter total"><?php echo $newCart[$ind]["total"]?></td>
                                        <td class="textCenter remove"><img src="img/config/removeBtn.png" alt="Remove Btn"></td>
                                    </tr>
                                    <?php
                                    }
                                }
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
                    <a href="index.php?action=order" class="order">Make An Order</a>
                    <?php
                } else {
                    ?>  
                    <div class="nothingFoundBlock"><h2 class="nothingFound">You didn’t add anything to your cart</h2></div>
                    <?php
                }
            ?>

            <script src='js/animation.js'></script>
        </div>
    </section>
</main>