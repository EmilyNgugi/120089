<!DOCTYPE html>
<html>
<head>
    <title>Calorie Calculator</title>

    <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
        body {
           height: 100% ;
            width: 100%;
            margin: 0;
            padding: 0;
            background-attachment: fixed;
            background-image: url("images/banner.jpg");
            background-size: cover;
            background-position: center;
            filter: brightness(100%);
            font-family: Poppins, sans-serif;
        }
        .homenavbar{
        width: 100%;
        display: flex;
        position: absolute;
        padding: 30px 20px;
        background-color: transparent; 
        justify-content: space-between;
        z-index:1111;
        transition:0.5 ease;
}
.logo{
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
ol{
    display: flex;
    margin: auto 0;
}
ol li{
    list-style: none;
    margin-right: 20px;
}
ol li a{
    font-size: 20px;
    font-weight: 500;
    text-decoration: none;
    color: #FFFFFF;  
}
ol li:hover a{
    color: #000000;
}
        .header {
            background-color: darkpink;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .header b{
        color:#FFFFFF; 
        font-size: 50px
}
        .header h1{
        color: #000000;
        text-align: center;
        margin-top: 7%;
        font-size: 50px
}
        .container {
            display: flex;
            justify-content: space-between;
            padding: 50px;
        }
        .column {
            width: 35%;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
        }
        .input-field {
            width: 50%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .input{
            width: 10%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button {
            background-color: #c31e52;
            color: #FFFFFF;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
         .mealplan{
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-weight: 800;
        padding: 5px 20px;
        font-size: 2vw;
        margin-top: 1.2em;
        color: #FFFFFF;
        border: 2px;
        border-radius: 50px;
        background: #c31e52;
        transition: 0.3s ease;
        position: center;
        font-family: Poppins, sans-serif;s
}
        .mealplan:hover{
    color: #FFFFFF;
    cursor: pointer;
    letter-spacing:1.5px;
    background color: #AA336A;
}
    p{
    color: #000000;
    text-align: center;
    font-size: 20px;
               
        }

        }
    </style>
</head>
<body>
     <div class="homenavbar">
  <a href="#" class="logo">F<B>M</B>.</a>
  <ol>
    <li><a href="index.php">Home</a></li>
    <li><a href="newmeal.php">MealPlan</a></li>
    <li><a href="workout.php">Workout</a></li>
    <li><a href="profile.php">My Account</a></li>
  </ol>
</div>

    <div class="header">
        <h1><b>C</b>alculate your <b>C</b>als</h1>
        <label for="measurement">Measurement System:</label>
        <select id="measurement" class="input">
            <option value="imperial">Imperial</option>
            <option value="metric">Metric</option>
        </select>
    </div>
    <div class="container">
        <div class="column">
            <h2> ABOUT ME</h2>
            <form method="post" action="save_data.php">
             <select id="gender" name="gender"class="input-field">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <select id="activity" name="activity" class="input-field">
                <option value="sedentary">Sedentary(little or no exercise)</option>
                <option value="light">Lightly Active(light exercise/sports 1-3 days a week)</option>
                <option value="moderate">Moderately Active(moderate exercise /sports 3-5 days a week)</option>
                <option value="active">Very Active(hard exercise/sports 6-7 days a week)</option>
                <option value="extra">Extra Active(very hard exercise/ sports &physical job or 2x training)</option>
            </select>
            <input class="input-field" type="number" id="weight" name="weight" placeholder="Current Weight (kg)">
            <input class="input-field" name="height" type="number" id="height" placeholder="Height (cm)">
            <input class="input-field" name="age" type="number" id="age" placeholder="Age">
        </div>
        <div class="column">
            <h2>MY WEIGHT GOAL</h2>
            <select id="goal" name="goal" class="input-field">
                <option value="lose">Lose Weight</option>
                <option value="gain">Gain Weight</option>
                <option value="maintain">Maintain Weight</option>
            </select>
            <input class="input-field" name="targetWeight" type="number" id="targetWeight" placeholder="Target Weight (kg)">
            <input class="input-field" name="weeksToGoal" type="number" id="weeksToGoal" placeholder="Weeks to Achieve Goal"><br>

                <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
    <input type="hidden" name="calories" id="calories" value="">
<input type="hidden" name="submit" value="Save Data">
<button type="submit" class="button">Save Data</button>

            <button id="calculate" class="button">Calculate</button>
            <p id="result"></p>
        </div>
    </div>
</form>
    <script>
        document.getElementById("calculate").addEventListener("click", calculateCalories);

        function calculateCalories() {
            
            const gender = document.getElementById("gender").value;
            const activity = document.getElementById("activity").value;
            const weight = parseFloat(document.getElementById("weight").value);
            const height = parseFloat(document.getElementById("height").value);
            const age = parseFloat(document.getElementById("age").value);

            const goal = document.getElementById("goal").value;
            const targetWeight = parseFloat(document.getElementById("targetWeight").value);
            const weeksToGoal = parseFloat(document.getElementById("weeksToGoal").value);
            const weightLimit = 90;

            if (targetWeight >= weightLimit) {
              if (activity === "light" || activity === "sedentary") {
                const resultElement = document.getElementById("result");
                resultElement.innerHTML = "To reach your target weight safely, we recommend consulting a healthcare professional.";
                return; 
            }
            }

           
            let bmr = 0;

            if (gender === "male") {
                bmr = (10 * weight) + (6.25 * height) - (5 * age) + 5;
            } else if (gender === "female") {
                bmr = (10 * weight) + (6.25 * height) - (5 * age) - 161;
            }

            
            let calorieFactor = 1.2; // Sedentary

            switch (activity) {
                case "light":
                    calorieFactor = 1.375; // Lightly Active
                    break;
                case "moderate":
                    calorieFactor = 1.55; // Moderately Active
                    break;
                case "active":
                    calorieFactor = 1.725; // Very Active
                    break;
            }

            const totalCalories = bmr * calorieFactor;

            let calorieGoalMessage = "";
            let dailyCalorieChange = 0;

            if (goal === "lose") {
                dailyCalorieChange = -500;
            } else if (goal === "gain") {
                dailyCalorieChange = (weeksToGoal <= 4) ? 600 : 400; //based on target weeks
            }

            const targetCalories = totalCalories + dailyCalorieChange;

            if (goal === "lose" && targetCalories < totalCalories) {
                calorieGoalMessage = "To reach your target weight safely, we recommend consulting a healthcare professional.";
            } else {
                calorieGoalMessage = `To reach your target weight of ${targetWeight} kg, your daily calorie intake should be ${targetCalories.toFixed(2)} calories, including a surplus of ${dailyCalorieChange} calories per day.`;
            }

                document.getElementById("calories").value = totalCalories;
            
            const resultElement = document.getElementById("result");
            resultElement.innerHTML = `Your total daily calorie needs are ${totalCalories.toFixed(2)} calories. ${calorieGoalMessage}`;
        }
    </script>
    <p class="meal">
        Access your meal plan to meet your required calories by clicking below.
    </p>
    <a href="newmeal.php">
            <button class="mealplan">MEALPLAN</button>
        </a>
    </div>
</body>
</html>




