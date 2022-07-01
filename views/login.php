<?php
	if (isset($_SESSION["auth"])&&$_SESSION["auth"] == true) {
		?>
            <script>window.location.href = "index.php"</script> 
        <?php
	} else {
        $error = false;
		if(!empty($_POST)){
			$username = $_POST['login'];
            $user = USER::getUserByLogin($username);
            if($user==null){
                $error = true;
            } else {
                $password = $_POST['password'];
                $passwordBD = $user["Users_Password"];
                if(password_verify($password, $passwordBD)==true){
                    $_SESSION["ID"] = $user["Users_ID"];
                    $_SESSION["USERNAME"] = $user["Users_Username"];
                    if (intval($user["Users_isAdmin"]) == 1) {
                        $_SESSION["isAdmin"] = true;
                    } else {
                        $_SESSION["isAdmin"] = false;
                    }
                    $_SESSION["auth"] = true;
                    ?>
                        <script>
                            localStorage.removeItem('signInError')
                            localStorage.removeItem('signInEndTime')
                            localStorage.removeItem('signInErrorCount')
                            window.location.href = "index.php?action=loginSuccess"
                        </script> 
                    <?php
                } else {
                    $error = true;
                }
            }
        }
        ?>  
        <main>
            <section class="success">
                <div class="blur"></div>
                <div class="container">
                    <div class="block">
                        <div class="form__block">
                            <div class="photo">
                                <img src="img/config/logo.png" alt="Logo">
                                <h1 class="name">Soul for Ukraine</h1>
                            </div>
                            <h2 class="title">Log In</h2>
                            <form action="" method="post" onsubmit="formSignInSubmit(event)">
                                <div class="formInput">
                                    <label for="login">Username</label>
                                    <input type="text" name="login" required minlength="4" maxlength="32" placeholder="Enter Username" id="login">
                                    <img src="img/config/user.png" alt="Login">
                                </div>
                                <div class="formInput">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" required minlength="8" maxlength="32" placeholder="Enter Password" id="password">
                                    <img src="img/config/lock.png" alt="Login">
                                </div>

                                <button type="submit">Log In</button>
                            </form>  
                            <div class="signInError error" id="wait"><img src="img/config/warning.png" alt="Error">Wait 5 min. and try again<img src="img/config/warning.png" alt="Error"></div>
                            <?php if($error==true){?>  
                                <div class="signInError error active" id="invalid"><img src="img/config/warning.png" alt="Error">Invalid username or password<img src="img/config/warning.png" alt="Error"></div>
                                <script>
                                    if(!localStorage.getItem('signInError')){
                                        if(localStorage.getItem('signInErrorCount')){
                                            let n = +localStorage.getItem('signInErrorCount');
                                            if(n==5){
                                                localStorage.setItem('signInErrorCount',1)
                                                localStorage.setItem('signInError',true)
                                                document.querySelector("#wait").classList.add("active")
                                                let CurrentTime = new Date();
                                                CurrentTime.setMinutes(CurrentTime.getMinutes() + 5);
                                                localStorage.setItem('signInEndTime',CurrentTime)
                                            } else {
                                                n += 1
                                                localStorage.setItem('signInErrorCount',n)
                                            }
                                        } else {
                                            localStorage.setItem('signInErrorCount',1)
                                        }
                                    }
                                </script>
                            <?php }?> 
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php
    }
?>