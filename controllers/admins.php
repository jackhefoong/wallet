<?php  
require_once 'connection.php';

function add_post($request) {
	global $cn;
	$user = $_SESSION["user_data"]["user_id"];
    $postname = $request["title"];
	$postlink = $request["link"];

    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
	$upload_dir = "/public/";
    $image = "";

    if (($_FILES["fileUpload"]["size"]) == 0) {
		$_SESSION['message'] = "Please upload an image";
		$_SESSION['class'] = "red darken-4";
		header('Location: ../views/articles.php');
    } else {
        $image = $upload_dir.$_FILES['fileUpload']['name'][0];

        $file_name = $_FILES['fileUpload']['name'][0];
        $temp_name = $_FILES['fileUpload']['tmp_name'][0];
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);

        if(in_array($file_type, $extensions)) {
            move_uploaded_file($temp_name, $_SERVER['DOCUMENT_ROOT'].$upload_dir.$file_name);
			if(strlen($postname) < 1 || strlen($postlink) < 1) {
				$_SESSION['message'] = "Please enter a link or title";
				$_SESSION['class'] = "red darken-4";
				header("Location: ../views/articles.php");
			} else {
				$query = "INSERT INTO articles (user_id, post_name, post_link, post_img) 
				VALUES ($user, '$postname', '$postlink', '$image')";
		
				mysqli_query($cn, $query);
				mysqli_close($cn);
				
				session_start();
				$_SESSION['message'] = "Article Posted successfully";
				$_SESSION['class'] = "light-green darken-1";
				header('Location: ../views/articles.php');
			}
        } else {
            $_SESSION['message'] = "File type is not supported";
			$_SESSION['class'] = "red darken-4";
			header('Location: ../views/articles.php');
        }
    }
}

function show_feedbacks() {
	global $cn;

	// $query = "SELECT * FROM feedback";
	// $result = mysqli_query($cn, $query);
	// $feedbacks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    $query = "SELECT users.username, feedback.* FROM feedback JOIN users WHERE feedback.user_id = users.user_id";
	$result = mysqli_query($cn, $query);
	$feedbacks = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $feedbacks;
}

function delete_post($request) {
	global $cn;
	$id = $request["id"];
	$query = "UPDATE articles
	SET deleted = 1
	WHERE id = $id";

	// var_dump($id);
	// die();
	mysqli_query($cn, $query);
	mysqli_close($cn);
	
	session_start();
	$_SESSION['message'] = "Post deleted successfully";
	$_SESSION['class'] = "light-green darken-1";
	header("location: ../views/articles.php");
}

function mark_as_read($request) {
	global $cn;
	$id = $request["id"];
	$query = "UPDATE feedback
	SET mark_as_read = 1
	WHERE feedback_id = $id";

	// var_dump($id);
	// die();
	mysqli_query($cn, $query);
	mysqli_close($cn);
	
	session_start();
	$_SESSION['message'] = "Feedback reviewed";
	$_SESSION['class'] = "light-green darken-1";
	header("location: ../views/feedbacks.php");
}

?>