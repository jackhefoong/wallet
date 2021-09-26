<?php 
$title = "My Wallet";
require_once "../controllers/connection.php";
require_once "../controllers/users.php";
require_once "../controllers/admins.php";
date_default_timezone_set("Asia/Kuala_Lumpur");
// session_start();
function get_content() {
    
    $balance = show_balance();

    $query = "SELECT * FROM category";
    $result = mysqli_query($GLOBALS["cn"], $query);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // $incomes = get_income();
?>

<div class="bg-img">

<div class="container msg">
    <?php if(isset($_SESSION["message"])): ?>
        <div class="card-panel white-text <?php echo $_SESSION["class"] ?>">
            <?php echo $_SESSION["message"]; ?>
        </div> 
    <?php endif; ?>
</div>

<div class="row"></div>
<div class="container grey darken-4 round">
    <div class="row">
        <div class="col m12 white-text center-align"><h4>Your Balance</h4>
        <img src="../assets/img/whitewshadow.jpg" alt="#">
        <?php if(count($balance) != 0) :  ?>
            <?php
                echo "<h3> RM" . $balance[0]["balance"] . "</h3>";
            ?>
        <?php endif; ?>
        <?php if(count($balance) == 0) :  ?>
            <h4 class="white-text center-align">You don't have a wallet yet...</h4>
            <form method="POST" action="/web.php">
            <input type="hidden" name="action" value="create_wallet">
            <div class="input-field">
                <input type="hidden" name="wallet" id="wallet" value="0">
            </div>
            <button class="btn grey lighten-2 black-text">Create Wallet</button>
        </form>
        <?php endif; ?>
        </div>
    </div>
<!-- </div> -->

<?php if(count($balance) != 0) :  ?>
<div class=" grey darken-4">
    <div class="row">
    <div class="col m6 white-text">
        <h4 class="center-align">Income</h4>
        <form method="POST" action="/web.php">
            <input type="hidden" name="action" value="add_income">
            <div class="input-field">
                <input type="number" name="income" id="income" min="0">
                <label for="income">Enter your income here</label>
            </div>
            <button class="btn grey lighten-2 black-text">Enter</button>
        </form>
    </div>

    <div class="col m6 white-text ">
        <h4 class="center-align">Expenses</h4>
        <form method="POST" action="/web.php">
            <input type="hidden" name="action" value="add_expenses">
            <div class="input-field">
                <input type="number" name="expenses" id="expenses" min="0">
                <label for="expenses">Enter your expenses here</label>
            </div>
            <div class="input-field">
                <select name="category_id">
                    <option value="" disabled selected>Please select a category</option>
                    <?php foreach($categories as $category): ?>

                        <option value="<?php echo $category['category_id'] ?>">
                            <?php echo $category['category'] ?>
                        </option>

                    <?php endforeach; ?>
                    <label>Category</label>
                </select>
            </div>
            <button class="btn grey lighten-2 black-text">Enter</button>
        </form>
    </div>
    </div>
</div>
<?php endif; ?>
</div>

<div class="row"></div>

</div>


<?php
}
require_once "layout.php";
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