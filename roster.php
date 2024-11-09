<?php
error_reporting(0);
require_once "includes/database_functions.php";
include "includes/header.php";
include "includes/navbar.php";

?>
<br/><br/><br/><br/><br/><br/>
<div class= 'center'>  <h1><?php echo $_GET["team"]; ?> </h1> </div>

<?php
$yearID = $_GET["yearID"];
$teamID = $_GET["teamID"];
//send a SQL statement and get results in to teams
$sql = "SELECT a.playerID, a.yearID, a.teamID, m.nameFirst, m.nameLast, t.name, t.W, t.L,t.Rank
from Appearances a join Master m on m.playerID = a.playerID
JOIN Teams t on t.teamID=a.teamID and t.yearID=a.yearID
where t.yearID = '{$yearID}' and t.teamID = '{$teamID}'
order by nameLast, nameFirst";

$players = getDataFromSQL($sql);

// print_r($_GET);


echo "<div class= 'center'>";
$name = $players[0]["name"]." ".$players[0]["yearID"];

echo "<h1>{$name}</h1>";
echo "<h2> Players</h2>";
foreach($players as $player){
    echo "<a href='player.php?playerID=".$player["playerID"]."'>";
    echo $player["nameFirst"];
    echo " ";
    echo $player["nameLast"];
    echo "</a> ";
    echo "<BR>";
}
echo "</div>"; 

echo "<h2> Wins and Losses</h2>";
echo $player["W"]." ". "Wins"." ".$player["L"]." "."Losses";

echo "<h2> Rank</h2>";
echo $player["Rank"];
include "includes/footer.php";

?>