<?php 
$title = "History";
require_once "../controllers/connection.php";
require_once "../controllers/users.php";
require_once "../controllers/admins.php";
// session_start();
function get_content() {

    // global $cn;
    // $categories = get_category();

    $categoryArray = array();
    $dataArray = array();

    // foreach($categories as $category) {
    //     array_push($categoryArray, $category["category"]);
    // }
    
    if(isset($_SESSION["expenses"])) {
        $expenses = $_SESSION["expenses"];

        foreach ($expenses as $expense) {
            array_push($categoryArray, $expense["category"]);
        }
    
        foreach ($expenses as $expense) {
            array_push($dataArray, intval($expense["amount"]));
        }
        
    } else {
        global $cn;

        $user = $_SESSION["user_data"]["user_id"];

        $month = date("n");
	    $year = date("Y");

        $query = "SELECT expenses.date, expenses.amount, expenses.category, category.category FROM expenses JOIN category WHERE category.category_id = expenses.category AND expenses.user_id = $user AND YEAR(expenses.date) = $year AND MONTH(expenses.date) = $month";

        $result = mysqli_query($cn, $query);
        $expenses = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($expenses as $expense) {
            array_push($categoryArray, $expense["category"]);
        }
    
        foreach ($expenses as $expense) {
            array_push($dataArray, intval($expense["amount"]));
        }
    }
    

    // var_dump($expenses);
	// die();

    // foreach ($expenses as $expense) {
    //     array_push($categoryArray, $expense["category"]);
    // }

    // foreach ($expenses as $expense) {
    //     array_push($dataArray, intval($expense["amount"]));
    // }
    
?>
<div class="container">
    <h4 class="white-text">Expenses</h4>
    <br>
    <h5 class="center-align white-text" id="text"></h5>
</div>
<div class="container">
<form method="POST" action="/web.php" class="center-align">
    <input type="hidden" name="action" value="querymonth">
    <div class="input-field">
        <input type="month" name="month" id="month" value="<?php echo (isset($_SESSION['date']))? $_SESSION['date'][0] . '-' . $_SESSION['date'][1]: date('Y-m') ;?>"> <!--min="<?php echo date("Y-01"); ?>" max="<?php echo date("Y-12"); ?>"-->
    </div>
    <button class="btn grey lighten-2 black-text">Choose Month</button>
</form>
</div>

<div id="chartsize" class="container">
<canvas id="myChart" width="400" height="400"></canvas>
</div>

<script>
    
<?php echo "let category =" . json_encode(array_values($categoryArray)) . ";" ?>
<?php echo "let data =" . json_encode(array_values($dataArray)) . ";" ?>

if(data.length == 0) {
    document.getElementById("text").innerHTML = "You have no expenses yet";
}

let ctx = document.getElementById('myChart');
let myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        labels: category,
        datasets: [{
            data: data,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 0.5
        }]
    },
    options: {
        plugins: {
            legend: {
                position: "right"
            }
        }
    }
});
</script>

<?php
}
require_once "layout.php";
?>