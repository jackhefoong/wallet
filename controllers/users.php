<?php  
require_once 'connection.php';
date_default_timezone_set("Asia/Kuala_Lumpur");
session_start();

function feedback($request) {
	global $cn;
	$user = $_SESSION["user_data"]["user_id"];
	$feedback = $request['feedback'];

	if(strlen($feedback) < 1) {
		$_SESSION['message'] = "No feedback submitted";
		$_SESSION['class'] = "red darken-4";
        header("Location: ../views/feedbakcs.php");
	} else {
		$query = "INSERT INTO feedback (user_id, feedback) 
		VALUES ($user, '$feedback')";

		mysqli_query($cn, $query);
		mysqli_close($cn);
		
		session_start();
		$_SESSION['message'] = "Feedback Submitted successfully";
		$_SESSION['class'] = "light-green darken-1";
		header('Location: /');
	}
}

function show_articles() {
	global $cn;

	$query = "SELECT * FROM articles";
	$result = mysqli_query($cn, $query);
	$articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $articles;
}

function create_wallet($request) {
	global $cn;

	$user = $_SESSION["user_data"]["user_id"];
	$balance = $request["wallet"];

	$query = "INSERT INTO balance (user_id, balance) 
	VALUES ($user, $balance)";

	mysqli_query($cn, $query);
	mysqli_close($cn);
	
	session_start();
	$_SESSION['message'] = "Wallet created successfully";
	$_SESSION['class'] = "light-green darken-1";
	header('Location: ../views/wallet.php');
}

function add_income($request) {
	global $cn;

	$date = date("Y-m-d");
	$user = $_SESSION["user_data"]["user_id"];
	$income = $request['income'];

	if(intval($income) <= 0) {
		$_SESSION['message'] = "Please input a value greater than 0";
		$_SESSION['class'] = "red darken-4";
        header("Location: ../views/wallet.php");
	} else {
		$query = "INSERT INTO income (user_id, date, amount) 
		VALUES ($user, '$date', $income)";

		mysqli_query($cn, $query);

		$query2 = "SELECT balance FROM balance WHERE user_id = $user";
		$result2 = mysqli_query($cn, $query2);
		$balance = mysqli_fetch_all($result2, MYSQLI_ASSOC);
	
		$finalbal = (intval($balance[0]["balance"]) + intval($income));
		$query3 = "UPDATE balance SET balance = $finalbal WHERE user_id = $user";
		mysqli_query($cn, $query3);
		// var_dump(intval($income));
		// die();
	
		mysqli_close($cn);

		session_start();
		$_SESSION['message'] = "Income updated successfully";
		$_SESSION['class'] = "light-green darken-1";
		header('Location: ../views/wallet.php');
	}
}

function show_balance() {
	global $cn;

	$user = $_SESSION["user_data"]["user_id"];

	$query = "SELECT balance FROM balance WHERE user_id = $user";
	$result = mysqli_query($cn, $query);
	$balance = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $balance;
}

function add_expenses($request) {
	global $cn;

	$month = date("n");
	$year = date("Y");
	// $day = date("d");
	$date = date("Y-m-d");

	// var_dump($month);
	// var_dump($year);
	// var_dump($day);
	// var_dump($date);
	// die();

	$user = $_SESSION["user_data"]["user_id"];
	$expenses = $request['expenses'];
	$category_id = $request['category_id'];

	if(intval($expenses) <= 0 || !isset($category_id)) {
		$_SESSION['message'] = "Please check input details";
		$_SESSION['class'] = "red darken-4";
        header("Location: ../views/wallet.php");
	} else {
		$querycheck = "SELECT expenses.* FROM expenses WHERE expenses.category = $category_id AND expenses.user_id = $user AND YEAR(expenses.date) = $year AND MONTH(expenses.date) = $month";
		$resultcheck = mysqli_query($cn, $querycheck);


		if(mysqli_num_rows($resultcheck) == 0) {

			$query = "INSERT INTO expenses (user_id, date, amount, category) 
			VALUES ($user, '$date', $expenses, $category_id)";

			mysqli_query($cn, $query);

			$query2 = "SELECT balance FROM balance WHERE user_id = $user";
			$result2 = mysqli_query($cn, $query2);
			$balance = mysqli_fetch_all($result2, MYSQLI_ASSOC);

			$finalbal = (intval($balance[0]["balance"]) - intval($expenses));
			$query3 = "UPDATE balance SET balance = $finalbal WHERE user_id = $user";
			mysqli_query($cn, $query3);
	
			// var_dump(intval($finalbal));
			// die();
		
			mysqli_close($cn);
	
			session_start();
			$_SESSION['message'] = "Expenses updated successfully";
			$_SESSION['class'] = "light-green darken-1";
			header('Location: ../views/wallet.php');

		} else if (mysqli_num_rows($resultcheck) == 1) {

			$queryexp = "SELECT expenses.amount FROM expenses WHERE expenses.category = $category_id AND expenses.user_id = $user AND YEAR(expenses.date) = $year AND MONTH(expenses.date) = $month";
			$resultexp = mysqli_query($cn, $queryexp);
			$existexp = mysqli_fetch_all($resultexp, MYSQLI_ASSOC);

			$newexp = (intval($existexp[0]["amount"]) + intval($expenses));

			$queryupdate = "UPDATE expenses SET amount = $newexp WHERE expenses.category = $category_id AND expenses.user_id = $user AND YEAR(expenses.date) = $year AND MONTH(expenses.date) = $month ";
			mysqli_query($cn, $queryupdate);

			$query2 = "SELECT balance FROM balance WHERE user_id = $user";
			$result2 = mysqli_query($cn, $query2);
			$balance = mysqli_fetch_all($result2, MYSQLI_ASSOC);
		
			$finalbal = (intval($balance[0]["balance"]) - intval($expenses));
			$query3 = "UPDATE balance SET balance = $finalbal WHERE user_id = $user";
			mysqli_query($cn, $query3);
	
			// var_dump(intval($finalbal));
			// die();
		
			mysqli_close($cn);
	
			session_start();
			$_SESSION['message'] = "Expenses updated successfully";
			$_SESSION['class'] = "light-green darken-1";
			header('Location: ../views/wallet.php');
		}
	}
}

// function get_category() {
// 	global $cn;

//     $query = "SELECT * FROM category";
//     $result = mysqli_query($GLOBALS["cn"], $query);
//     $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

// 	return $categories;
// }

function get_expenses() {
	global $cn;

	$user = $_SESSION["user_data"]["user_id"];

    $query = "SELECT expenses.date, expenses.amount, expenses.category, category.category FROM expenses JOIN category WHERE category.category_id = expenses.category AND expenses.user_id = $user";

    $result = mysqli_query($cn, $query);
    $expenses = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $expenses;
	
}

// function get_income() {
// 	global $cn;

// 	$user = $_SESSION["user_data"]["user_id"];

// 	$query = "SELECT income.date, income.amount FROM income WHERE income.user_id = $user";
// 	$result = mysqli_query($cn, $query);
// 	$incomes = mysqli_fetch_all($result, MYSQLI_ASSOC);

// 	return $incomes;
// }

function querymonth($request) {
	$date = $request["month"];
	$onlymonth = substr($date, -2);
	$onlyyear = substr($date, 0, 4);

	// var_dump($date);
	// var_dump($onlymonth);
	// var_dump($onlyyear);
	// die();

	global $cn;

	$user = $_SESSION["user_data"]["user_id"];

    $query = "SELECT expenses.date, expenses.amount, expenses.category, category.category FROM expenses JOIN category WHERE category.category_id = expenses.category AND expenses.user_id = $user AND YEAR(expenses.date) = '$onlyyear' AND MONTH(expenses.date) = '$onlymonth'";

    $result = mysqli_query($cn, $query);
    $_SESSION["expenses"] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION["date"] = [$onlyyear, $onlymonth];

	header('Location: ../views/history.php');
}

?>