<?php
error_reporting(0);
require_once "includes/database_functions.php";
include "includes/header.php";
include "includes/navbar.php";

?>
<br/><br/><br/><br/><br/><br/>
<div class= 'center'>  <h1><?php echo $_GET["team"]; ?> Years</h1> </div>

<?php
$teamName = $_GET["team"];
//send a SQL statement and get results in to teams
$sql = "SELECT yearID, teamID
        FROM Teams
        where teamID in (select teamID
				from Teams
                where name = '{$teamName}')
order by name";

$years = getDataFromSQL($sql);

// print_r($_GET);

echo "<div class= 'center'>";
foreach($years as $year){
    echo "<a href='roster.php?yearID=".$year["yearID"]."&teamID=".$year["teamID"]."'>";
    echo $year["yearID"];
    echo "</a> ";
    echo "<BR>";
}
echo "</div>"; 
    
include "includes/footer.php";

?>