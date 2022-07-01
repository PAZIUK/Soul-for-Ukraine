<body>
    <?php
        if(isset($_GET)&&isset($_GET["find"])){
            ?>
            <script>window.location.href = "index.php?action=shop&search=<?php echo $_GET["find"]?>"</script>
            <?php
        }
    ?>
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="/" class="navbar-brand"><img src="img/config/logo.png" alt="Logo">Soul for Ukraine</a>
                <ul class="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php?action=shop">Shop</a></li>
                    <li><a href="index.php#about">About Us</a></li>
                    <li><a href="index.php#contacts">Contact Us</a></li>
                </ul>
                <div class="actions">
                    <!-- <div class="search">
                        <button class="mainBtn"><img src="https://img.icons8.com/material-sharp/24/FFFFFE/search.png"/></button>
                        <div class="searchBlock">
                            <form action="" method="GET">
                                <input required type="text" maxlength="100" name="find" placeholder="Search ...">
                                <button type="submit"><img src="https://img.icons8.com/material-sharp/24/FFFFFE/search.png"/></button>
                            </form>
                        </div>
                    </div> -->
                    <a href="index.php?action=cart" class="shoppingCart"><span>!</span><img src="https://img.icons8.com/ios-glyphs/30/FFFFFE/shopping-cart--v1.png"/></a>
                    <div class="user">
                        <button class="userBtn"><img src="https://img.icons8.com/ios-filled/50/FFFFFE/user-male-circle.png"/></button>
                        <ul class="userActions">
                        <?php
                            if (isset($_SESSION["isAdmin"])&&$_SESSION["isAdmin"]==true) {
                                ?>
                                <li><a href="index.php?action=admin">Admin Panel</a></li>
                                <?php 
                                if (!empty($_POST)&&isset($_POST["isLogout"])&&$_POST["isLogout"]=="true") {
                                    session_unset();
                                    ?>
                                        <script>window.location.href = "index.php"</script>
                                    <?php
                                } else {
                                    ?>
                                    <li>
                                        <form action="" method="POST">
                                            <input type="hidden" name="isLogout" value="true">
                                            <button class="logout">Log Out</button>
                                        </form>	
                                    </li>
                                    <script>
                                        document.querySelector("header ul.userActions li form button").addEventListener("click",function() {
                                            if (window.confirm("Do you really want to log out?")) {
                                                this.parentElement.querySelector("input").setAttribute("value","true")
                                            } else {
                                                this.parentElement.querySelector("input").setAttribute("value","false")
                                            }
                                        })
                                    </script>
                                    <?php
                                }
                            } else {
                                ?>
                                <li><a href="index.php?action=login">Log In</a></li>
                                <?php
                            }
                        ?>
                        </ul>
                    </div>
                    <div class="toggle">
                        <img src="img/config/toggleBtn.png" alt="Menu Button">
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <body>