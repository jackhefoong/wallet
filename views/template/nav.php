<nav class="grey darken-4">
    <div class="nav-wrapper container">
        <a href="/" class="brand-logo "><img src = "../../assets/img/walletlogo.png" ></a>
        <a href="#" data-target="mobile-menu" class="sidenav-trigger">
        <i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down ">
            <li><a href="/">Home</a></li>
            <li><a href="/views/articles.php">Articles</a></li>
            <?php if(isset($_SESSION["user_data"]) && $_SESSION["user_data"]["isAdmin"]): ?>
                <li><a href="/views/feedbacks.php">Feedbacks</a></li>
            <?php endif; ?>
            <?php if(isset($_SESSION["user_data"]) && !$_SESSION["user_data"]["isAdmin"]): ?>
                <li><a href="/views/wallet.php">My Wallet</a></li>
                <li><a href="/views/history.php">History</a></li>
            <?php endif; ?>
            
            <?php if(isset($_SESSION["user_data"])): ?>
            <li><a class="dropdown-trigger" href="#!" data-target="navdropdown"> <span class="white-text">
                <?php if(isset($_SESSION["user_data"])): ?>
                    <?php echo $_SESSION["user_data"]["username"];?> 
                <?php endif; ?>
            </span> <i class="material-icons right">account_circle arrow_drop_down</i></a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<ul id="navdropdown" class="dropdown-content grey darken-4 ">
        <?php if(isset($_SESSION["user_data"])): ?>
        <li><a href="/web.php/logout">Logout</a></li>
        <?php endif; ?>
</ul>

<ul class="sidenav" id="mobile-menu">
    <li><a href="/">Home</a></li>
    <?php if(isset($_SESSION["user_data"]) && !$_SESSION["user_data"]["isAdmin"]): ?>
        <li><a href="/views/wallet.php">My Wallet</a></li>
        <li><a href="/views/history.php">History</a></li>
    <?php endif; ?>
        <li><a href="/views/articles.php">Articles</a></li>
    <?php if(isset($_SESSION["user_data"]) && $_SESSION["user_data"]["isAdmin"]): ?>
        <li><a href="/views/feedbacks.php">Feedbacks</a></li>
    <?php endif; ?>

    <?php if(!isset($_SESSION["user_data"])): ?>
    <li><a href="/">Login</a></li>
    <?php endif; ?>

    <?php if(isset($_SESSION["user_data"])): ?>
    <li><a href="/web.php/logout">Logout</a></li>
    <?php endif; ?>
</ul>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // let elems = document.querySelectorAll('.sidenav');
    // let instances = M.Sidenav.init(elems, {});

    // let dropdowns = document.querySelectorAll('.dropdown-trigger')
    // let ddinst = M.Dropdown.init(dropdowns, {});
    M.AutoInit();
});

// $(document).ready(function(){
//     $('.sidenav').sidenav();
// });
</script>

          