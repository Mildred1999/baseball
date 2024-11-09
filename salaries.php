<?php
error_reporting(E_ERROR | E_PARSE);
require_once "includes/database_functions.php";
include "includes/header.php";
include "includes/navbar.php";
?>

<br/><br/><br/><br/><br/><br/>
<div class='center'><h1>Top Baseball Salaries</h1></div>

<?php

// Query for top 25 highest individual season salaries
$sqlTopSeasonSalaries = "SELECT m.playerID, m.nameFirst, m.nameLast, s.salary, s.yearID
                         FROM Salaries s JOIN Master m ON s.playerID = m.playerID
                         ORDER BY s.salary DESC
                         LIMIT 25;";

// Query for top 25 highest career earnings by summing annual salaries
$sqlTopCareerEarnings = "SELECT m.playerID, m.nameFirst, m.nameLast, SUM(s.salary) AS totalEarnings
                         FROM Salaries s JOIN Master m ON s.playerID = m.playerID
                         GROUP BY m.playerID
                         ORDER BY totalEarnings DESC
                         LIMIT 25;";

// Fetch data for both queries
$topSeasonSalaries = getDataFromSQL($sqlTopSeasonSalaries);
$topCareerEarnings = getDataFromSQL($sqlTopCareerEarnings);

// Display Top Season Salaries in a Table
echo "<div class='center'>";
echo "<h2>Top 25 Season Salaries</h2>";
echo "<table border='1' cellpadding='10' cellspacing='0' style='margin: 0 auto;'>";
echo "<tr><th>Player</th><th>Season Salary</th><th>Year</th></tr>";

foreach ($topSeasonSalaries as $salary) {
    $playerName = $salary["nameFirst"] . " " . $salary["nameLast"];
    $seasonSalary = "$" . number_format($salary["salary"], 2); // Format season salary
    $year = $salary["yearID"];
    
    echo "<tr>";
    echo "<td><a href='player.php?playerID=".$salary["playerID"]."'>".$playerName."</a></td>";
    echo "<td>".$seasonSalary."</td>";
    echo "<td>".$year."</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

// Display Top Career Earnings in a Table
echo "<div class='center'>";
echo "<h2>Top 25 Career Earnings</h2>";
echo "<table border='1' cellpadding='10' cellspacing='0' style='margin: 0 auto;'>";
echo "<tr><th>Player</th><th>Career Earnings</th></tr>";

foreach ($topCareerEarnings as $career) {
    $playerName = $career["nameFirst"] . " " . $career["nameLast"];
    $totalEarnings = "$" . number_format($career["totalEarnings"], 2); // Format career earnings
    
    echo "<tr>";
    echo "<td><a href='player.php?playerID=" . $career["playerID"] . "'>" . $playerName . "</a></td>";
    echo "<td>" . $totalEarnings . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>"; 

include "includes/footer.php";
?>