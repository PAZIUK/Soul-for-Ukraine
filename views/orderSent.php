<?php 
    if(isset($_POST["sentOrder"])&&$_POST["sentOrder"]=="true"){
        SHOP::sendOrder($_POST);
        ?>
        <script>
            localStorage.removeItem("cart")
            window.location.href = window.location.href
        </script>
        <?php
    } else {
        ?>
        <main>
            <section class="success">
                <div class="blur"></div>
                <div class="container">
                    <div class="block">
                        <div class="photo"><img src="https://img.icons8.com/external-flat-icons-pause-08/160/000000/external-birthday-christmas-collection-flat-icons-pause-08.png" alt="success"/></div>
                        <h2 class="title">Congratulations!</h2>
                        <p class="desc">Your order was successfully sent!</p>
                        <a href="index.php?action=shop" class="successBtn">Continue Shopping</a>
                    </div>
                </div>
            </section>
        </main>
        <?php
    }
?>