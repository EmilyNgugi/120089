<?php

include('connect.php');


$query = "SELECT users.id, users.username, users.email, user_data.gender, user_data.activity, user_data.weight, user_data.height, user_data.age, user_data.goal, user_data.targetWeight, user_data.weeksToGoal, user_data.calories
          FROM users
          INNER JOIN user_data ON users.email = user_data.email";


$selectedMonthNewUsers = null;


if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];

    if ($filter === 'female') {
        $query .= " WHERE user_data.gender = 'female'";
    } elseif ($filter === 'male') {
        $query .= " WHERE user_data.gender = 'male'";
    }
}


$selectedMonthNewUsers = null;


$queryNewUsers = "SELECT users.id, users.username, users.email, user_data.gender
                  FROM users
                  INNER JOIN user_data ON users.email = user_data.email";


if (isset($_GET['month'])) {
    $selectedMonthNewUsers = $_GET['month'];
    $currentYear = date('Y');
    $queryNewUsers .= " WHERE MONTH(users.registration_date) = $selectedMonthNewUsers
                      AND YEAR(users.registration_date) = $currentYear
                      AND DATEDIFF(CURDATE(), users.registration_date) <= 30";
}


$result = $conn->query($query);


if ($result) {
     $userDataQuery = "SELECT AVG(user_data.activity) as avgActivity,
                                 AVG(user_data.weight) as avgWeight,
                                 AVG(user_data.height) as avgHeight,
                                 AVG(user_data.age) as avgAge,
                                 AVG(user_data.calories) as avgCalories
                      FROM users
                      INNER JOIN user_data ON users.email = user_data.email";
                       $userDataResult = $conn->query($userDataQuery);

    if ($userDataResult) {
        $userData = $userDataResult->fetch_assoc();
    } else {
        echo 'Error fetching user data for chart: ' . $conn->error;
    }


    
    echo '<div class="container" id="userDataReportContainer"><h2><br><br>User Data Report</h2>';
    displayUserData($result);
    echo '<a href="#" class="download-btn" onclick="downloadUserDataReport()">Download PDF - User Data Report</a></div>';
} else {
    
    echo 'Error: ' . $conn->error;
}



$resultNewUsers = $conn->query($queryNewUsers);

$newUsersDataQuery = "SELECT COUNT(CASE WHEN user_data.gender = 'male' THEN 1 END) as maleCount,
                                COUNT(CASE WHEN user_data.gender = 'female' THEN 1 END) as femaleCount
                     FROM users
                     INNER JOIN user_data ON users.email = user_data.email";

$newUsersDataResult = $conn->query($newUsersDataQuery);

if ($resultNewUsers) {
        $newUsersDataQuery = "SELECT COUNT(CASE WHEN user_data.gender = 'male' THEN 1 END) as maleCount,
                                    COUNT(CASE WHEN user_data.gender = 'female' THEN 1 END) as femaleCount
                         FROM users
                         INNER JOIN user_data ON users.email = user_data.email";

    $newUsersDataResult = $conn->query($newUsersDataQuery);

    if ($newUsersDataResult) {
        $newUsersData = $newUsersDataResult->fetch_assoc();
    } else {
        echo 'Error fetching new users data for chart: ' . $conn->error;
    }

    
    echo '<div class="container" id="newUsersReportContainer"><h2><br>New Users Report for Month ' . $selectedMonthNewUsers . '</h2>';
    

    
    displayNewUsersData($resultNewUsers);
    echo '<a href="#" class="download-btn" onclick="downloadNewUsersReport()">Download PDF - New Users Report</a></div>';
} else {
    
    echo 'Error fetching new users: ' . $conn->error;
}



$conn->close();


function displayUserData($result)
{
    echo '<table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Activity</th>
                <th>Weight</th>
                <th>Height</th>
                <th>Age</th>
                <th>Goal</th>
                <th>Target Weight</th>
                <th>Weeks to Goal</th>
                <th>Calories</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['username'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['gender'] . '</td>
                <td>' . $row['activity'] . '</td>
                <td>' . $row['weight'] . '</td>
                <td>' . $row['height'] . '</td>
                <td>' . $row['age'] . '</td>
                <td>' . $row['goal'] . '</td>
                <td>' . $row['targetWeight'] . '</td>
                <td>' . $row['weeksToGoal'] . '</td>
                <td>' . $row['calories'] . '</td>
              </tr>';
    }

    echo '</table>';
}


function displayNewUsersData($resultNewUsers)
{
    echo '<table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gender</th>
            </tr>';

    while ($rowNewUsers = $resultNewUsers->fetch_assoc()) {
        echo '<tr>
                <td>' . $rowNewUsers['id'] . '</td>
                <td>' . $rowNewUsers['username'] . '</td>
                <td>' . $rowNewUsers['email'] . '</td>
                <td>' . $rowNewUsers['gender'] . '</td>
              </tr>';
    }

    echo '</table>';
}
$monthLabels = array();
for ($i = 1; $i <= 12; $i++) {
    $monthLabels[] = date('F', mktime(0, 0, 0, $i, 1));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Data Report</title>
     <style type="text/css">
        * {
            padding: 0px;
            margin-top:  40px;
        }
         .container {
        width: 80%; 
        margin: 0 auto;
        
        padding: 20px; 
    }
    .canvas{
        width: 100%;
    }
        body {
            
            background-image: url("images/weight.jpeg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
.download-btn {
            padding: 10px;
            background-color: #333333;
            color: #FFFFFF;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        h2 {
            font-family: Arial, sans-serif;
            color: #c31e52;
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid white;
        }

        th, td {
            padding: 10px;
            text-align: left;
            color: #FFFFFF;
        }

        th {
            background-color: #333333;
        }

        td {
            background-color: #555555;
        }

        form {
            margin-top: 10px;
        }

        select {
            padding: 5px;
        }

        input[type="submit"] {
            padding: 5px 10px;
            background-color: #333333;
            color: #FFFFFF;
            cursor: pointer;
        }
        .mealnavbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(0, 0, 0, 0); 
    position: fixed;
    top: 0;
    right: 0;
    z-index: 999; 
    padding: 0px; 
    color: #FFFFFF;
    position: absolute;
}
.logo {
   font-size: 2.8em;
  font-weight: 800;
  letter-spacing: 2px;
  text-transform:  uppercase;
  text-decoration: none;
  color: #000000;
  padding: 0px;
}
.logo B{
  color: #c31e52;
}

ol {
    list-style-type: none;
    padding: 0;
    margin: 0;
    color: #FFFFFF;
    align-self: left;
}

ol li {
    display: inline;
    margin-right: 20px; 
}
ol li a{
  font-size: 20px;
  font-weight: 500;
  text-decoration: none;
  color: #808080;
  font-family: Arial, sans-serif;  
}

ol li:last-child {
    margin-right: 0; 
}
ol li:hover a{
  color: #000000;
}
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

     <script>
        function downloadUserDataReport() {
            const element = document.getElementById('userDataReportContainer');
            html2pdf(element);
        }

       async function downloadNewUsersReport() {
        const element = document.getElementById('newUsersReportContainer');
        
        await new Promise(resolve => setTimeout(resolve, 500));
        html2pdf(element);
        }
    </script>

     <script>
       
        function generateBarChart(chartId, labels, data, title) {
            var ctx = document.getElementById(chartId).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: title
                        }
                    }
                }
            });
        }

     
        var userLabels = ['Activity', 'Weight', 'Height', 'Age', 'Calories'];
         var userData = [<?php echo $userData['avgActivity'] ?>, <?php echo $userData['avgWeight'] ?>, <?php echo $userData['avgHeight'] ?>, <?php echo $userData['avgAge'] ?>, <?php echo $userData['avgCalories'] ?>];

        var newUsersLabels = ['New Users'];
        var newUsersData = [<?php echo $newUsersData['maleCount'] ?>, <?php echo $newUsersData['femaleCount'] ?>];

   
        window.onload = function() {
            generateBarChart('userChart', userLabels, userData, 'User Data');
            generateBarChart('newUsersChart', newUserLabels, newUsersData, 'New Users Data');
           
 document.getElementById('month').value = selectedMonthNewUsers;
        };
    </script>
</head>
<body>
     <div class="mealnavbar">
  
  <ol>
    <li><a href="index.php">Home</a></li>
    <li><a href="#" onclick="return confirmLogout();">Log Out</a></li>
    <li><a href="profile.php">My Account</a></li>
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
    <div class="container">
       

        <form method="get" action="">
            
     <div class="container" id="userDataReportContainer">
            <labelfor="filter">Filter by Gender:</label>
            <select name="filter" id="filter">
                <option value="all">All</option>
                <option value="female">Female</option>
                <option value="male">Male</option>
            </select>
            
            <input type="submit" value="Apply Filter">

        </form>

        <form method="get" action="">
            <label for="month">Select Month:</label>
            <select name="month" id="month">
                <?php
               
                for ($i = 1; $i <= 12; $i++) {
                    echo '<option value="' . $i . '">' . date('F', mktime(0, 0, 0, $i, 1)) . '</option>';
                }
                ?>
            </select>
            <input type="submit" value="Generate Report">
        </form>
    </div>
      <div class="container" id="newUsersReportContainer">
        <canvas id="userChart" width="500" height="300"></canvas>
        <canvas id="newUsersChart" width="500" height="300"></canvas>

</body>
</html>
