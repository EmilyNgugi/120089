<!DOCTYPE html>
<html>
<head>
    <title>Calorie Calculator</title>
</head>
<body>
    <h1>Calorie Calculator</h1>

    <label for="age">Age (years):</label>
    <input type="number" id="age" placeholder="Enter your age">

    <label for="weight">Weight (kg):</label>
    <input type="number" id="weight" placeholder="Enter your weight">

    <label for="height">Height (cm):</label>
    <input type="number" id="height" placeholder="Enter your height">

    <label for="gender">Gender:</label>
    <select id="gender">
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>

    <label for="activityLevel">Activity Level:</label>
    <select id="activityLevel">
        <option value="sedentary">Sedentary (little or no exercise)</option>
        <option value="lightlyActive">Lightly active (light exercise or sports 1-3 days a week)</option>
        <option value="moderatelyActive">Moderately active (moderate exercise or sports 3-5 days a week)</option>
        <option value="veryActive">Very active (hard exercise or sports 6-7 days a week)</option>
        <option value="superActive">Super active (very hard exercise, physical job, or training twice a day)</option>
    </select>

    <button onclick="calculateCalories()">Calculate Calories</button>

    <p>Your Basal Metabolic Rate (BMR): <span id="bmr">0</span> calories/day</p>
    <p>Your Daily Caloric Needs: <span id="calories">0</span> calories/day</p>

    <script>
        function calculateCalories() {
            const age = parseInt(document.getElementById("age").value);
            const weight = parseFloat(document.getElementById("weight").value);
            const height = parseFloat(document.getElementById("height").value);
            const gender = document.getElementById("gender").value;
            const activityLevel = document.getElementById("activityLevel").value;

            let bmr;

            if (gender === "male") {
                bmr = 88.362 + (13.397 * weight) + (4.799 * height) - (5.677 * age);
            } else if (gender === "female") {
                bmr = 447.593 + (9.247 * weight) + (3.098 * height) - (4.330 * age);
            }

            let calorieFactor = 0;

            switch (activityLevel) {
                case "sedentary":
                    calorieFactor = 1.2;
                    break;
                case "lightlyActive":
                    calorieFactor = 1.375;
                    break;
                case "moderatelyActive":
                    calorieFactor = 1.55;
                    break;
                case "veryActive":
                    calorieFactor = 1.725;
                    break;
                case "superActive":
                    calorieFactor = 1.9;
                    break;
            }

            const dailyCalories = Math.round(bmr * calorieFactor);

            document.getElementById("bmr").textContent = bmr;
            document.getElementById("calories").textContent = dailyCalories;
        }
    </script>
</body>
</html>