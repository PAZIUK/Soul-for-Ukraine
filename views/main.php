<main>
    <section class="hello">
        <div class="blur"></div>
        <div class="container">
            <div class="hello_block">
                <h2 class="title">With Love For UKRAINE</h2>
                <p class="desc">All profit is donated to support Ukraine through trusted funds or direct purchases of necessities</p>
                <a href="index.php?action=shop">Shop & Help</a>
            </div>
        </div>
    </section>
    <?php 
        $newShopItems = SHOP::GetNewGoods();
        if(count($newShopItems)>0){
            ?>
            <section class="shop">
                <div class="container">
                    <div class="shopBlock">
                        <div class="title">Featured products</div>
                        <div class="products">
                            <?php 
                                for ($i=0; $i < count($newShopItems); $i++) { 
                                ?>
                                <a href="index.php?action=product&view=<?php echo $newShopItems[$i]["ShopItem_ID"]?>" class="product">
                                    <div class="product__photo"><img src="img/shop/<?php echo $newShopItems[$i]["ShopItemImages_Image"]?>" alt=""></div>
                                    <div class="product__title"><?php echo $newShopItems[$i]["ShopItem_Name"]?></div>
                                    <div class="product__price">$<?php echo number_format($newShopItems[$i]["ShopItem_Price"], 2, ',', ' ');?></div>
                                </a>
                                <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
    ?>
    <section class="about" id="about">
        <div class="container">
            <h2 class="title">- About Us -</h2>
            <div class="about__block">
                <div class="photo"></div>
                <div class="text">
                    <h3 class="title">Soul for Ukraine</h3>
                    <p>
                        Right now - we are Ukrainians, whose homes are being destroyed and families are hiding in the basements.
                        Just last week we were busy with our normal routines - making healthy sweets in Ukraine.
                        But suddenly everything has changed and will never be the same. So here we are, trying to find other ways to help our brave soldiers and volunteers.
                        All artworks were kindly donated by the artists from all over the world.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="contacts" id="contacts">
        <div class="container">
            <div class="block">
                <div class="contacts__block contacts">
                    <div class="title">Contact Us</div>
                    <ul>
                        <li><a href="tel:+12158889490" target="_blank"><img src="img/config/phone.png" alt="Phone">+1 215-888-9490</a></li>
                        <li><a href="mailto:soul4ukraine@gmail.com" target="_blank"><img src="img/config/gmail.png" alt="Mail">soul4ukraine@gmail.com</a></li>
                    </ul>
                </div>
                <div class="contacts__block">
                    <div class="title">Follow Us</div>
                    <ul class="media">
                        <li><a href="https://www.facebook.com/soul4ukraine" target="_blank"><img src="img/config/facebook.png" alt="Facebook"></a></li>
                        <li><a href="https://www.instagram.com/mzakrevskaphila" target="_blank"><img src="img/config/instagram.png" alt="Instagram"></a></li>
                        <li><a href="https://www.tiktok.com/@mariyaua21" target="_blank"><img src="img/config/tik-tok.png" alt="TikTok"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main>