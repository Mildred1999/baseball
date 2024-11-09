<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once "includes/database_functions.php";
include "includes/header.php";
include "includes/navbar.php";

?>
<br/><br/><br/><br/><br/><br/>


<?php
$playerID = $_GET["playerID"];
//send a SQL statement and get results in to teams
// $sql = "SELECT * 
// FROM Master m 
// JOIN Appearances a on a.playerID=m.playerID
// JOIN Teams t on t.teamID=a.teamID and t.yearID=a.yearID
// WHERE m.playerID='{$playerID}';";

$sql = "SELECT m.*,t.*,b.H AS Hits, b.AB AS AtBats, b.HR AS HomeRuns, b.RBI AS RunsBattedIn, 
CASE WHEN b.AB IS NOT NULL AND b.AB > 0 THEN ROUND(b.H / b.AB, 3) ELSE NULL END AS BattingAverage,
p.yearID, p.W AS Wins, p.L AS Losses, p.G AS GamesPitched, p.SO AS Strikeouts, p.SHO AS Shutouts, f.yearID,
f.POS AS Position, f.E AS Errors, f.DP AS DoublePlays, f.A AS Assists,
CASE WHEN m.bats = 'L' THEN 'Left'
	WHEN m.bats = 'R' THEN 'Right'
    ELSE 'Switch'
    END AS Bats,
CASE WHEN m.throws = 'L' THEN 'Left'
	WHEN m.throws = 'R' THEN 'Right'
    ELSE 'Ambidextrous'
    END AS Throws,
CASE WHEN m.deathYear IS NULL or m.deathYear=''
	THEN TIMESTAMPDIFF(YEAR, CONCAT(m.birthYear, '-', m.birthMonth, '-', m.birthDay), CURDATE())
	ELSE CONCAT(TIMESTAMPDIFF(YEAR, CONCAT(m.birthYear, '-', m.birthMonth, '-', m.birthDay), CONCAT(m.deathYear, '-', m.deathMonth, '-', m.deathDay)), '(Deceased)')
    END AS Age,
CASE WHEN m.birthCountry = 'USA' THEN NULL 
	ELSE m.birthCountry 
    END AS birthCountry,
CONCAT(m.birthYear, '-', m.birthMonth, '-', m.birthDay) AS birthdate
FROM Master m JOIN Appearances a ON a.playerID = m.playerID
LEFT JOIN Batting b on b.playerID=m.playerID and b.teamID=a.teamID and b.yearID=a.yearID
LEFT JOIN Pitching p on p.playerID=m.playerID and p.teamID=a.teamID and p.yearID=a.yearID
LEFT JOIN Fielding f on f.playerID=m.playerID and f.teamID=a.teamID and f.yearID=a.yearID
JOIN Teams t ON t.teamID = a.teamID AND t.yearID = a.yearID
WHERE m.playerID = '{$playerID}';";

// echo $sql;
// echo "<BR>";
$years = getDataFromSQL($sql);

$name = $years[0]["nameFirst"]." ".$years[0]["nameLast"];

echo "<h1>{$name}'s Page</h1>";
// echo "<pre>";
// print_r($years);
// echo "</pre>";
if(file_exists("images/player/{$playerID}.jpeg"))
    echo "<img src='images/player/{$playerID}.jpeg' >";
else
    echo "<img src='images/player/missing.jpeg' >";

echo "<div class='player-info'>";
echo "<h2>Personal Information</h2>";
echo "<table>";
echo "<tr><td><strong>Given Name:</strong></td><td>" .$years[0]["nameGiven"] . "</td></tr>";
echo "<tr><td><strong>Birth Date:</strong></td><td>" .$years[0]["birthdate"] . "</td></tr>";
echo "<tr><td><strong>Birth City:</strong></td><td>" . $years[0]["birthCity"] . "</td></tr>";
echo "<tr><td><strong>Birth Country:</strong></td><td>" .$years[0]["birthCountry"] . "</td></tr>";
echo "<tr><td><strong>Height:</strong></td><td>" .$years[0]["height"]. " cm</td></tr>";
echo "<tr><td><strong>Weight:</strong></td><td>" .$years[0]["weight"]. " kg</td></tr>";
echo "<tr><td><strong>Bats:</strong></td><td>" .$years[0]["Bats"]. "</td></tr>";
echo "<tr><td><strong>Throws:</strong></td><td>" .$years[0]["Throws"]. "</td></tr>";
echo "<tr><td><strong>Age:</strong></td><td>" .$years[0]["Age"]. "</td></tr>";
echo "</table>";
echo "</div>";

echo "<div class= 'center'>";
echo "<h2>Player Statistics</h2>";
echo "<table border='1' cellpadding='10' cellspacing='0' style='margin: 0 auto;'>";
echo "<tr><th>Teams and Years</th><th>Batting Average</th><th>Hits</th><th>At Bats</th><th>Home Runs</th><th>Runs Batted In</th>";
echo "<th>Wins</th><th>Losses</th><th>Games Pitched In</th><th>Strikeouts</th><th>Shutouts</th>";
echo "<th>Position</th><th>Errors</th><th>Double Plays</th><th>Assists</th></tr>";
foreach($years as $year){
    $yearID = $year["yearID"];
    $teamID = $year["teamID"];
    echo "<tr>";
    echo "<td><a href='roster.php?yearID={$yearID}&teamID={$teamID}'>";
    echo $year["yearID"];
    echo " ";
    echo $year["name"];
    echo "</a></td> ";
    echo "<td>".$year["BattingAverage"]."</td>";
    echo "<td>".$year["Hits"]."</td>";
    echo "<td>".$year["AtBats"]."</td>";
    echo "<td>".$year["HomeRuns"]."</td>";
    echo "<td>".$year["RunsBattedIn"]."</td>";
    echo "<td>".$year["Wins"]."</td>";
    echo "<td>".$year["Losses"]."</td>";
    echo "<td>".$year["GamesPitched"]."</td>";
    echo "<td>".$year["Strikeouts"]."</td>";
    echo "<td>".$year["Shutouts"]."</td>";
    echo "<td>".$year["Position"]."</td>";
    echo "<td>".$year["Errors"]."</td>";
    echo "<td>".$year["DoublePlays"]."</td>";
    echo "<td>".$year["Assists"]."</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>"; 

    
include "includes/footer.php";

?>