<?php  
require_once "connection.php";

//REGISTER
function register($request) {
	global $cn;
	$errors = 0; 
	$username = $request["username"];
	$password = $request["password"];
	$password2 = $request["password2"];

	if(strlen($username) < 8) {
		$_SESSION["message"] = "Username must be greater than 8 characters";
		$_SESSION["class"] = "red darken-4";
		$errors++;
		header("Location: ../views/register.php");
	}

	if(strlen($password) < 8) {
		$_SESSION["message"] = "Password must be greater than 8 characters";
		$_SESSION["class"] = "red darken-4";
		$errors++;
		header("Location: ../views/register.php");
	}

	if($password != $password2) {
		$_SESSION["message"] = "Password do not match";
		$_SESSION["class"] = "red darken-4";
		$errors++;
		header("Location: ../views/register.php");
	}

	if($username) {
		$query = "SELECT username FROM users WHERE username = '$username'";
		$result = mysqli_fetch_assoc(mysqli_query($cn, $query));
		if($result) {
			$_SESSION["message"] = "Username Taken";
			$_SESSION["class"] = "red darken-4";
			$errors++;
			header("Location: ../views/register.php");
			mysqli_close($cn);
		}
	}

	if($errors === 0) {
		$password = password_hash($password, PASSWORD_DEFAULT);
		$query = "INSERT INTO users (username, password) 
		VALUES ('$username', '$password')";
		mysqli_query($cn, $query);
		mysqli_close($cn);
		$_SESSION["message"] = "Registered successfully";
		$_SESSION["class"] = "light-green darken-1";
		header('Location: ../views/login.php');
	}
}

//LOGIN
function login($request) {
	global $cn;
	$username = $request["username"];
	$password = $request["password"];

	$query = "SELECT * FROM users WHERE username = '$username'";
	$user = mysqli_fetch_assoc(mysqli_query($cn, $query));
	session_start();
	 
	if($user && password_verify($password, $user["password"])) {
		$_SESSION["user_data"] = $user;
		$_SESSION["message"] = "Welcome, ".  $_SESSION["user_data"]["username"];
		$_SESSION["class"] = "light-green darken-1";

		mysqli_close($cn);
		header("Location: /");
	} else {
		$_SESSION["message"] = "Invalid Credentials";
		$_SESSION["class"] = "red darken-4";
		header("Location: /");
	}
}

//LOGOUT
function logout() {
	session_start();

	session_unset();

	session_destroy();

	header("location: /");
}
?>