<main>
    <section class="shop">
        <div class="container">
            <div class="title">- Products -</div>
            <div class="filters">
                <form action="index.php?action=shop" method="get">
                    <input type="hidden" name="action" value="shop">
                    <?php
                        if(isset($_GET)&&isset($_GET["search"])){
                        ?>
                            <input type="hidden" name="search" value="<?php echo $_GET["search"]?>">
                        <?php
                        }
                    ?>
                    <input type="hidden" name="action" value="shop">
                    <div class="filterBlock">
                        <div class="name">Category</div>
                        <select name="categories">
                            <option <?php if(!isset($_GET)&&!isset($_GET["categories"])){echo "selected";}?> value="all">All</option>
                            <?php
                                $categories = CATEGORY::GetAllCategories();
                                for ($i=0; $i < count($categories); $i++) { 
                                ?>
                                <option <?php if(isset($_GET)&&isset($_GET["categories"])&&$_GET["categories"]==$categories[$i]["Category_ID"]){echo "selected";}?> value="<?php echo $categories[$i]["Category_ID"] ?>"><?php echo $categories[$i]["Category_Name"] ?></option>
                                <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="filterBlock">
                        <div class="name">Sort By</div>
                        <select name="sort">
                            <option value="plth" <?php if(isset($_GET)&&isset($_GET["sort"])&&$_GET["sort"]=="plth"||!isset($_GET)&&!isset($_GET["sort"])){echo "selected";}?>>Price, low to high</option>
                            <option value="phtl" <?php if(isset($_GET)&&isset($_GET["sort"])&&$_GET["sort"]=="phtl"){echo "selected";}?>>Price, high to low</option>
                            <option value="dotn" <?php if(isset($_GET)&&isset($_GET["sort"])&&$_GET["sort"]=="dotn"){echo "selected";}?>>Date, old to new</option>
                            <option value="dnto" <?php if(isset($_GET)&&isset($_GET["sort"])&&$_GET["sort"]=="dnto"){echo "selected";}?>>Date, new to old</option>
                        </select>
                    </div>
                    <button type="submit">OK</button>
                </form>
            </div>
            <div class="shopBlock">
                <?php 
                    $shopItems = SHOP::GetGoodsByFilter($_GET);
                    if(count($shopItems)>0){
                    ?>
                    <div class="products">
                        <?php
                        for ($i=0; $i < count($shopItems); $i++) { 
                        ?>
                            <a href="index.php?action=product&view=<?php echo $shopItems[$i]["ShopItem_ID"]?>" class="product">
                                <div class="product__photo"><img src="img/shop/<?php echo $shopItems[$i]["ShopItemImages_Image"]?>" alt=""></div>
                                <div class="product__title"><?php echo $shopItems[$i]["ShopItem_Name"]?></div>
                                <div class="product__price">$<?php echo number_format($shopItems[$i]["ShopItem_Price"], 2, '.', ',');?></div>
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    } else {
                        ?>
                        <h2 class="nothingFound">Nothing Was Found</h2>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>