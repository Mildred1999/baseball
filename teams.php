<?php
error_reporting(E_ERROR | E_PARSE);
require_once "includes/database_functions.php";
include "includes/header.php";
include "includes/navbar.php";

?>
<br/><br/><br/><br/><br/><br/>
<div class= 'center'>  <h1>Teams and Leagues</h1> </div>

<?php

//send a SQL statement and get results in to teams
$sql = "SELECT name, GROUP_CONCAT(DISTINCT lgID ORDER BY lgID SEPARATOR ', ') AS leagues
FROM Teams
GROUP BY name;";

$teams = getDataFromSQL($sql);

// print_r($_GET);


echo "<div class= 'center'>";
echo "<table>";
echo "<tr><th>Teams</th><th>Leagues</th></tr>";
foreach($teams as $team){
    echo "<tr><td>";
    echo "<a href='years.php?team=".$team["name"]."'>";
    echo $team["name"];
    echo "</a> </td>";
    echo "<td>".$team["leagues"]."</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>"; 
    
include "includes/footer.php";

?>