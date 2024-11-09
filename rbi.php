<?php
error_reporting(E_ERROR | E_PARSE);
require_once "includes/database_functions.php";
include "includes/header.php";
include "includes/navbar.php";
?>

<br/><br/><br/><br/><br/><br/>
<div class='center'><h1>Top Runs Batted In</h1></div>

<?php

// Query for top 25 highest individual season salaries
$sql = "SELECT m.playerID,m.nameLast,m.nameFirst,SUM(x.RBI) AS withPost, SUM(x.RBI2) AS RegSeason 
FROM Master m
JOIN (SELECT  playerID,RBI,RBI as RBI2 FROM Batting 
UNION ALL
SELECT  playerID,RBI, 0 FROM BattingPost ) x 
ON (m.playerID=x.playerID)
GROUP BY playerID
ORDER BY 4 DESC
LIMIT 25;";



// Fetch data for both queries
$rbis = getDataFromSQL($sql);


// Display Top Season Salaries in a Table
echo "<div class='center'>";

echo "<table border='1' cellpadding='10' cellspacing='0' style='margin: 0 auto;'>";
echo "<tr><th>Player</th><th>RBI with Post Season</th><th>RBI - Regular Season</th></tr>";

foreach ($rbis as $rbi) {
    $playerName = $rbi["nameFirst"]." ".$rbi["nameLast"];
    $rbiwp = $rbi["withPost"]; // Format season salary
    $rbir = $rbi["RegSeason"];
    
    echo "<tr>";
    echo "<td><a href='player.php?playerID=".$rbi["playerID"]."'>".$playerName."</a></td>";
    echo "<td>".$rbiwp."</td>";
    echo "<td>".$rbir."</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";


include "includes/footer.php";
?>