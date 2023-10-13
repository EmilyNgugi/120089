<?php
$meals = array(
  "Breakfast" => array(
    array("name" => "Eggs", "calories" => 300),
    array("name" => "Oatmeal", "calories" => 200),
    array("name" => "Smoothie", "calories" => 150)
  ),
  "Lunch" => array(
    array("name" => "Salad", "calories" => 250),
    array("name" => "Sandwich", "calories" => 400),
    array("name" => "Soup", "calories" => 300)
  ),
  "Dinner" => array(
    array("name" => "Grilled chicken", "calories" => 400),
    array("name" => "Steak", "calories" => 600),
    array("name" => "Vegetable stir-fry", "calories" => 350)
  ),
  "Snack" => array(
    array("name" => "Yogurt", "calories" => 150),
    array("name" => "Fruit", "calories" => 100),
    array("name" => "Nuts", "calories" => 200)
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
<html>
<head>
  <title>Daily Meal Plan</title>
  <style>
    body {
      background-color: #fff;
      color: #000;
      font-family: Arial, sans-serif;
      align-items: center;
      text-align: center;
      margin-top: 125px;
    }

    h2 {
      color: #c31e52;
    }

    ul {
      list-style-type: none;
      padding: 0;
    }

    li {
      margin-bottom: 10px;
    }

    button {
      background-color:#c31e52;
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
    width: 100%;
    display: flex;
    position: fixed; 
    top: 0;
    padding: 40px 20px; 
    background-color: #e2a4a0;
    justify-content: space-between;
    z-index: 1111;
    transition: 0.5s ease;
    
  }
  
  .mealnavbar .logo {
   font-size: 2.8em;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform:  uppercase;
    text-decoration: none;
    color: #FFFFFF;
}
  .logo B{
    color: #000000;
}
  
  .mealnavbar ol {
    list-style-type: none;
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0;
   
  }
  
  .mealnavbar ol li {
    margin-right: 15px;
    
}

    ol li:hover a{
    color: #000000;
  }
  
  .mealnavbar ol li a {
    font-size: 20px;
    font-weight: 500;
    text-decoration: none;
    color: #FFFFFF;  
  }
  .calorie{
height: 100% ;
    width: 100%;
    position: absolute; 
    background-image: url("images/cal.jpg");
    background-size: cover;
    background-position: center;
    filter: brightness(100%);
   

  }

</style>
</head>
<body>
     <div class="mealnavbar">
  <a href="#" class="logo">F<B>M</B>.</a>
  <ol>
    <li><a href="index.php">Home</a></li>
    <li><a href="home.php">CaloryCount</a></li>
    <li><a href="workout.php">Workout</a></li>
    <li><a href="index.php">Log out</a></li>
  </ol>
</div>
<div class="calorie">
  <h2>Meal Plan for Today</h2>
  <?php if (isset($mealPlan)) : ?>
    <ul>
      <?php foreach ($mealPlan as $mealType => $meal) : ?>
        <?php if ($mealType === 'Total Calories') : ?>
          <li><?= $mealType ?>: <?= $meal ?></li>
        <?php elseif ($mealType === 'Exceeded Calories') : ?>
          <li><?= $mealType ?>: <?= $meal ?> (Exceeded by <?= $mealPlan['Exceeded Calories'] ?> calories)</li>
        <?php elseif ($mealType === 'Remaining Calories') : ?>
          <li><?= $mealType ?>: <?= $meal ?> (<?= $mealPlan['Remaining Calories'] ?> calories remaining)</li>
        <?php else : ?>
          <li><?= $mealType ?>: <?= $meal['name'] ?> (<?= $meal['calories'] ?> calories)</li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form action="" method="post">
    <label for="calorieGoal">Enter your calorie goal:</label>
    <input type="number" id="calorieGoal" name="calorieGoal" required>
    <button type="submit" name="submit">Generate Meal Plan</button>
  </form>
  </div>
</body>
</html>