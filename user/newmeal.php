<?php
$meals = array(
  "Breakfast" => array(
    array("name" => "Eggs(3 boiled)", "calories" => 234),
    array("name" => "Oatmeal", "calories" => 200),
    array("name" => "Chocolate banana Smoothie", "calories" => 550),
    array("name" => "Spinach Avocado Banana shake(1 cup each)", "calories" => 495),
    array("name" => "Vanilla(whey) berry shake(237ml)", "calories" => 600),
  ),
  "Snack(between breakfast and lunch)" => array(
    array("name" => "Yogurt", "calories" => 150),
    array("name" => "Mixed Fruit(avocado, banana, mango)", "calories" => 350),
    array("name" => "Mixed Nuts", "calories" => 607),
  ),
  "Lunch" => array(
    array("name" => "Fish stir fry", "calories" => 488),
    array("name" => "Sandwich", "calories" => 400),
    array("name" => "Lentil Soup", "calories" => 600),
    array("name" => "Rice (1 cup)", "calories" => 250),
    array("name" => "Chicken avocado sandwich", "calories" => 340),
  ),
  "Snack(between lunch and dinner)" => array(
    array("name" => "Yogurt", "calories" => 150),
    array("name" => "Mixed Fruit(avocado, banana, mango)", "calories" => 350),
    array("name" => "Mixed Nuts", "calories" => 607),
  ),
  "Dinner" => array(
    array("name" => "Grilled chicken(400cals)+ Rice(250 cals)", "calories" => 650),
    array("name" => "Steak(600 cals) + Potatoes(110 cals)", "calories" => 710),
    array("name" => "Vegetable stir-fry", "calories" => 450),
    array("name" => "Garlic butter pasta", "calories" => 281),
    array("name" => "Ugali(429 cals)+ Eggs(234 cals)", "calories" => 663),
  )
);

function generateMealPlan($calorieGoal) {
  global $meals;
  $mealPlan = array();
  $totalCalories = 0;

  foreach ($meals as $mealType => $mealOptions) {
    $randomIndex = array_rand($mealOptions);
    $meal = $mealOptions[$randomIndex];
    $mealPlan[$mealType] = $meal;
    $totalCalories += $meal['calories'];
  }

  $mealPlan['Total Calories'] = $totalCalories;

  if ($totalCalories > $calorieGoal) {
    $mealPlan['Exceeded Calories'] = $totalCalories - $calorieGoal;
  } else {
    $mealPlan['Remaining Calories'] = $calorieGoal - $totalCalories;
  }

  return $mealPlan;
}

if (isset($_POST['submit'])) {
  $calorieGoal = $_POST['calorieGoal'];
  $mealPlan = generateMealPlan($calorieGoal);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daily Meal Plan</title>
    <style>
        body {
            background-image: url("images/weight.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            color: #000;
            font-family: Arial, sans-serif;
            align-items: center;
            text-align: center;
            padding-top: 40px;
            position: relative;
            display: flex;
            min-height: 100vh;
            margin: 0;
            justify-content: center;

        }

        h2 {
            color: #c31e52;
            margin-bottom: 50px;
        }

        .card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px; 
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 200px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px); 
        }

        button {
            background-color: #c31e52;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #ff1493;
        }

        .mealnavbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            padding: 10px;
            color: #FFFFFF;
        }

        .logo {
            font-size: 2.8em;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            color: #000000;
        }

        .logo B {
            color: #c31e52;
        }

        ol {
            list-style-type: none;
            padding: 0;
            margin: 0;
            color: #FFFFFF;
        }

        ol li {
            display: inline;
            margin-right: 20px;
        }

        ol li a {
            font-size: 20px;
            font-weight: 500;
            text-decoration: none;
            color: #FFFFFF;
        }

        ol li:last-child {
            margin-right: 0;
        }

        ol li:hover a {
            color: #000000;
        }

        .container {
            padding: 20px 0;
            align-content: center;
            width: 100%;
        }

        .calorie {
            width: 100%;
            filter: brightness(100%);
        }

        strong {
            font-weight: bold;
            padding-bottom: 20px;
        }
    </style>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

    <script>
        function downloadAsPDF() {
            const element = document.getElementById('mealPlanContainer');

            html2pdf(element);
        }
    </script>
</head>

<body>
<div class="mealnavbar">
    <a href="#" class="logo">F<B>M</B>.</a>
    <ol>
        <li><a href="home.php">CaloryCount</a></li>
        <li><a href="workout.php">Workout</a></li>
        <li><a href="profile.php">My Account</a><li>
           <li><a href="#" onclick="return confirmLogout();">Log Out</a></li>
    </ol>
    <script>
    function confirmLogout() {
        var result = confirm("Are you sure you want to log out?");
        if (result) {
           
            window.location.href = 'index.php';
        } else {
          
        }
        return false;
    }
</script>
</div>
<div class="calorie">
    <div class="container">
        <h2>Meal Plan for Today</h2>
        <?php if (isset($mealPlan)) : ?>
          <div id="mealPlanContainer">
            <div class="card-container">
                <?php foreach ($mealPlan as $mealType => $meal) : ?>
                    <?php if ($mealType === 'Total Calories' || $mealType === 'Exceeded Calories' || $mealType === 'Remaining Calories') : ?>
                        <div class="card"><strong><?= $mealType ?>:<br></strong> <?= $meal ?></div>
                    <?php else : ?>
                        <div class="card"><strong><?= $mealType ?></strong><br><br><?= $meal['name'] ?> (<?= $meal['calories'] ?> calories)</div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
          </div>
          <br><button class="download-btn" onclick="downloadAsPDF()">Download as PDF</button><br>
        <?php endif; ?>

        <form action="" method="post">
            <label for="calorieGoal">Enter your calorie goal:</label>
            <input type="number" id="calorieGoal" name="calorieGoal" required>
            <button type="submit" name="submit">Generate Meal Plan</button>
        </form>
    </div>
</div>
</body>
</html>