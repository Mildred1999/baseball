<?php
error_reporting(E_ERROR | E_PARSE);
require_once "includes/database_functions.php";
include "includes/header.php";
include "includes/navbar.php";
?>

<br/><br/><br/><br/><br/><br/>
<div class='center'><h1>Top Homeruns</h1></div>

<?php

// Query for top 25 highest individual season salaries
$sql = "SELECT m.playerID,m.nameLast,m.nameFirst,SUM(x.HR) AS withPost, SUM(x.HR2) AS RegSeason 
FROM Master m
JOIN (SELECT  playerID,HR,HR as HR2 FROM Batting 
UNION ALL
SELECT  playerID,HR, 0 FROM BattingPost ) x 
ON (m.playerID=x.playerID)
GROUP BY playerID
ORDER BY 4 DESC
LIMIT 25;";



// Fetch data for both queries
$homeruns = getDataFromSQL($sql);


// Display Top Season Salaries in a Table
echo "<div class='center'>";

echo "<table border='1' cellpadding='10' cellspacing='0' style='margin: 0 auto;'>";
echo "<tr><th>Player</th><th>Homeruns with Post Season</th><th>Homeruns - Regular Season</th></tr>";

foreach ($homeruns as $homerun) {
    $playerName = $homerun["nameFirst"]." ".$homerun["nameLast"];
    $hrwp = $homerun["withPost"]; // Format season salary
    $hr = $homerun["RegSeason"];
    
    echo "<tr>";
    echo "<td><a href='player.php?playerID=".$homerun["playerID"]."'>".$playerName."</a></td>";
    echo "<td>".$hrwp."</td>";
    echo "<td>".$hr."</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";


include "includes/footer.php";
?>