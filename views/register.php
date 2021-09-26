
<?php
session_start();
$title = "Register";
require_once "../controllers/connection.php";
require_once "../controllers/Authenticators.php";
function get_content() {
?>

<div class="container msg">
    <?php if(isset($_SESSION["message"])): ?>
        <div class="card-panel white-text <?php echo $_SESSION["class"] ?>">
            <?php echo $_SESSION["message"]; ?>
        </div> 
    <?php endif; ?>
</div>

<div class="bg-img ">
    <!-- <div class="container"> -->
        <div class="row">
            <div class="col m12 loginform">
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
                    <span class="card-title">Register</span>
                    <form action="/web.php" method="POST">
                    <input type="hidden" name="action" value="register">
                    <div class="input-field">
                        <input type="text" name="username" id="username">
                        <label for="username">User Name</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" id="password">
                        <label for="password">Password</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password2" id="password2">
                        <label for="password2">Confirm Password</label>
                    </div>
                    <button class="btn grey lighten-2 black-text">
                        Register
                    </button>
                    </form>
                    </div>
                    <div class="card-action">
                    <small class="white-text">Already have an account? <a href="login.php" class="amber-text lighten-1">Click here to login.</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}
require_once "layout.php"
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
