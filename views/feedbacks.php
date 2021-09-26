<?php 
$title = "Articles";
require_once "../controllers/connection.php";
require_once "../controllers/users.php";
require_once "../controllers/admins.php";
// session_start();
function get_content() {
    global $cn;
    $feedbacks = show_feedbacks();

    // $query2 = "SELECT users.username, feedback.* FROM feedback JOIN users WHERE feedback.user_id = users.user_id";
	// $result2 = mysqli_query($cn, $query2);
	// $usernames = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    // var_dump($username);
    // die();
?>

<div class="bg-img">

<div class="container msg">
    <?php if(isset($_SESSION["message"])): ?>
        <div class="card-panel white-text <?php echo $_SESSION["class"] ?>">
            <?php echo $_SESSION["message"]; ?>
        </div> 
    <?php endif; ?>
</div>

<div class="container">
    <div class="row">
    <h4 class=" header white-text">Feedbacks</h4>
        <?php foreach($feedbacks as $feedback): ?>
            <?php if($feedback["mark_as_read"] == 0): ?>
                <div class="col s12 m12">
                    <div class="card grey darken-4 white-text">
                        <div class="card-content">
                        <p><?php echo $feedback["feedback"]; ?> <br><small class="">By: <?php echo $feedback["username"]; ?></small></p>
                        <!-- </div> -->
                        
                        <form method="POST" action="/web.php" class="right-align">
                        <input type="hidden" name="action" value="mark_as_read">
                        <input type="hidden" name="id" value="<?php echo $feedback['feedback_id']?>">
                        <button class="btn red darken-4 white-text">Mark as read</button>
                        </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

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