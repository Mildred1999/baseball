<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once "includes/database_functions.php";
include "includes/header.php";
include "includes/navbar.php";

?>
<br/><br/><br/><br/><br/><br/>
<div class= 'center'>  <h1>Search Results</h1> </div>

<?php

///print_r($_POST);
//Need to get term from POST
$term = $_POST["term"];

//send a SQL statement and get results in to teams
$sql = "SELECT *
FROM Master
WHERE nameLast LIKE '{$term}%'
or nameFirst LIKE '{$term}%'
OR CONCAT( nameFirst, ' ', nameLast) LIKE '{$term}%'
";

// echo $sql;
// echo "<BR>";
$players = getDataFromSQL($sql);

// echo "<pre>";
// print_r($players);
// echo "</pre>";

echo "<div class= 'center'>";
foreach($players as $player){
    echo "<a href='player.php?playerID=".$player["playerID"]."'>";
    echo $player["nameFirst"];
    echo " ";
    echo $player["nameLast"]; 
    echo "</a> ";
    echo "<BR>";
}
echo "</div>"; 
    
include "includes/footer.php";


?>