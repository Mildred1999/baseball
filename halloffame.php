<?php
error_reporting(E_ERROR | E_PARSE);
require_once "includes/database_functions.php";
include "includes/header.php";
include "includes/navbar.php";
?>

<br/><br/><br/><br/><br/><br/>
<div class='center'><h1>Hall Of Famers (1936 - 2017)</h1></div>

<?php

// Query for top 25 highest individual season salaries
$sql = "SELECT h.playerID, m.nameFirst, m.nameLast, h.yearID,h.category
FROM HallOfFame h JOIN Master m
ON h.playerID = m.playerID
WHERE inducted = 'Y';";



// Fetch data for both queries
$halloffames = getDataFromSQL($sql);


// Display Top Season Salaries in a Table
echo "<div class='center'>";

echo "<table border='1' cellpadding='10' cellspacing='0' style='margin: 0 auto;'>";
echo "<tr><th>Player</th><th>Year</th><th>Category</th></tr>";

foreach ($halloffames as $halloffame) {
    $playerName = $halloffame["nameFirst"]." ".$halloffame["nameLast"];
    $year = $halloffame["yearID"]; 
    
    echo "<tr>";
    echo "<td><a href='player.php?playerID=".$halloffame["playerID"]."'>".$playerName."</a></td>";
    echo "<td>".$year."</td>";
    echo "<td>".$halloffame["category"]."</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";


include "includes/footer.php";
?>