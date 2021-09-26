<?php 
$title = "Articles";
require_once "../controllers/connection.php";
require_once "../controllers/users.php";
require_once "../controllers/admins.php";
// session_start();
function get_content() {

    $articles = show_articles();
?>

<div class="bg-img">

<div class="container msg">
    <?php if(isset($_SESSION["message"])): ?>
        <div class="card-panel white-text <?php echo $_SESSION["class"] ?>">
            <?php echo $_SESSION["message"]; ?>
        </div> 
    <?php endif; ?>
</div>

<?php if(isset($_SESSION["user_data"]) && $_SESSION["user_data"]["isAdmin"]): ?>
    <div class="row">
        <div class="col m6 offset-m3">
            <form method="POST" action="/web.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_post">
                <div class="input-field">
                    <input type="text" name="title" id="title">
                    <label for="title">Title</label>
                </div>
                <div class="input-field">
                    <input type="text" name="link" id="link">
                    <label for="link">Link to article</label>
                </div>
                <div class="input-field file-field">
                    <div class="btn grey lighten-2 black-text">
                        <input type="file" name="fileUpload[]" id="articleimg">
                        <span>Choose file</span>
                    </div>
                    <div class="file-path-wrapper">
                        <input type="text" class="file-path validate">
                    </div>
                </div>
                <button class="btn grey lighten-2 black-text">Upload Article</button>
            </form>
        </div>  
    </div>
<?php endif; ?>

<div class="container">
    <div class="row">
    <h4 class=" header white-text">Articles</h4>

        <?php foreach($articles as $article): ?>

            <?php if($article["deleted"] == 0): ?>
                <div class="col m6">
                <div class="card horizontal">
                <div class="card-image">
                    <img src="<?php echo $article["post_img"]; ?>">
                </div>
                <div class="card-stacked">
                    <div class="card-content white-text">
                    <h5><?php echo $article["post_name"]; ?></h5>
                    </div>
                    <div class="card-action">
                    <a href="<?php echo $article["post_link"]; ?>" target="_blank">Click here to read more</a>
                    </div>
                </div>

                <?php if(isset($_SESSION["user_data"]) && $_SESSION["user_data"]["isAdmin"]): ?>
                    <a class="btn modal-trigger red darken-4" href="#deleteModal<?php echo $article["id"]?>">Delete</a>
                        <div id="deleteModal<?php echo $article["id"]?>" class="modal">
                            <div class="modal-content">
                                <form method="POST" action="/web.php">
                                <input type="hidden" name="action" value="delete_post">
                                <input type="hidden" name="id" value="<?php echo $article["id"]?>">
                                <h4>Are you sure you want to delete?</h4>
                                <button class="btn red darken-4 white-text">Delete</button>
                                <a href="#!" class="modal-close waves-effect waves-green btn grey">Cancel</a>
                                </form>
                            </div>
                        </div>
                <?php endif; ?>
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