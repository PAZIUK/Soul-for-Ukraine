<main>
    <section class="success">
        <div class="blur"></div>
        <div class="container">
            <div class="block">
                <div class="photo"><img src="https://img.icons8.com/external-flat-icons-pause-08/160/000000/external-birthday-christmas-collection-flat-icons-pause-08.png" alt="success"/></div>
                <h2 class="title">Congratulations!</h2>
                <p class="desc">You have successfully logged in!</p>
                <a href="index.php" class="successBtn">Main Page</a>
                <?php
                    if (isset($_SESSION["isAdmin"])&&$_SESSION["isAdmin"]==true) {
                        ?>
                            <a href="index.php?action=admin" class="successBtn">Admin Panel</a>
                        <?php
                    }
                ?>
            </div>
        </div>
    </section>
</main>