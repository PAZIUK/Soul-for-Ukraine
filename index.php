<?php
    session_start();
    require_once("models/database.php");
    require_once("models/shop.php");
    require_once("models/category.php");
    require_once("models/user.php");
    require_once("models/admin.php");

    require_once("layout/head.php");
    require_once("layout/header.php");

    if(isset($_GET["action"])){
        $a = $_GET["action"];
        if (file_exists("views/".$a.".php")) {
            require_once("views/".$a.".php");
        }	else {
        ?>
            <script>window.location.href = "index.php?action=404"</script> 
        <?php
        }
    }
    else {
        if(isset($_GET["redirect"])){
            ?>
                <script>
                    setTimeout(() => {
                        window.location.href = "index.php?action=<?php echo $_GET["redirect"]?>"
                    }, 50);
                </script> 
            <?php
        } else {
            require_once("views/main.php");
        }
    }

    require_once("layout/footer.php");
    ?>
    <script>
        console.log(localStorage.getItem("cart"));
        if(localStorage.getItem("cart")){
            $.ajax({
                url: window.location.href,
                method: "POST",            
                data: {Cart:localStorage.getItem("cart")},         
                dataType: "html",         
                success: function (data) {
                    $('#shoppingCart').html($(data).filter('#shoppingCart').html());
                },
            });
        }
    </script>
    <div id="shoppingCart">
        <?php 
            if(isset($_POST["Cart"])&&strlen($_POST["Cart"])>0){
                $_SESSION["Cart"] = $_POST["Cart"];
            } else {
                if(isset($_SESSION['Cart'])){
                    unset($_SESSION['Cart']);
                }
            }
        ?>
    </div>
    <?php
?>