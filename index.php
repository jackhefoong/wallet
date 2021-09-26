<?php
session_start();
$title = "HomePage";
require_once "controllers/connection.php";
require_once "controllers/Authenticators.php";
function get_content() {
?>

<div class="container msg">
    <?php if(isset($_SESSION["message"])): ?>
        <div class="card-panel white-text <?php echo $_SESSION["class"] ?>">
            <?php echo $_SESSION["message"]; ?>
        </div> 
    <?php endif; ?>
</div>

<div class="bg-img_home">
    <!-- <div class="container"> -->
    <div class="row">
        <div class="col m6 white-text" id="introbox">
            <h1 class="left-align">Manage your expenses</h1>
            <h5 class="right-align">-brought to you by wallet</h5>
            <h4 class="left-align" id="infobox">Our main purpose is to help individuals manage their financials wisely. We are a simple web app that allow users to keep track of their expenses and income. By doing so, you may monitor yourself and refrain from splurging.</h4>
        </div>
        <?php if(!isset($_SESSION["user_data"])): ?>
            <div class="col m6 loginform">
                        <!-- <form action="/web.php" method="POST">
                        <input type="hidden" name="action" value="login">
                        <div class="input-field">
                            <input type="text" name="username" id="username">
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" id="password">
                            <label for="password">Password</label>
                        </div>
                        <button class="btn grey lighten-2 black-text">Login</button>
                        <small class="white-text">Don't have an account yet? <a href="./register.php">Sign up now.</a></small>
                        </form> -->

                        <div class="card grey darken-4">
                            <div class="card-content white-text">
                            <span class="card-title">Login</span>
                            <form action="/web.php" method="POST">
                            <input type="hidden" name="action" value="login">
                            <div class="input-field">
                                <input type="text" name="username" id="username">
                                <label for="username">Username</label>
                            </div>
                            <div class="input-field">
                                <input type="password" name="password" id="password">
                                <label for="password">Password</label>
                            </div>
                            <button class="btn grey lighten-2 black-text">Login</button>
                            </form>
                            </div>
                            <div class="card-action">
                            <small class="white-text">Don't have an account yet? <a href="views/register.php" class="amber-text lighten-1">Sign up now.</a></small>
                            </div>
                        </div>


            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION["user_data"]) && !$_SESSION["user_data"]["isAdmin"]): ?>
            <div class="col m6 loginform">
                        <!-- <form action="/web.php" method="POST">
                        <input type="hidden" name="action" value="login">
                        <div class="input-field">
                            <input type="text" name="username" id="username">
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" id="password">
                            <label for="password">Password</label>
                        </div>
                        <button class="btn grey lighten-2 black-text">Login</button>
                        <small class="white-text">Don't have an account yet? <a href="./register.php">Sign up now.</a></small>
                        </form> -->

                        <div class="card grey darken-4">
                            <div class="card-content white-text">
                            <span class="card-title">User Feedback</span>
                            <form action="/web.php" method="POST">
                            <input type="hidden" name="action" value="feedback" class="black-text">
                            <div class="input-field">
                                <label for="feedback">Feedback</label>
                                <br><br>
                                <textarea name="feedback" id="feedback" cols="80" rows="5"></textarea>
                            </div>
                            <button class="btn grey lighten-2 black-text">Submit</button>
                            </form>
                            </div>
                        </div>


            </div>
        <?php endif; ?>
        </div>
    </div>
</div>


<?php
}
require_once "views/layout.php"
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector(".card-panel")
        setTimeout(() => {
            <?php unset($_SESSION["message"]); ?>
            <?php unset($_SESSION["class"]); ?>
            card.classList.toggle("hide");
        }, 5000)
    })
</script>