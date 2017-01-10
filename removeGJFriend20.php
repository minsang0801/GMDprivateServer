<?php
include "connection.php";
require_once "incl/GJPCheck.php";
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$targetAccountID = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES);
// REMOVING FOR USER 1
$query = "SELECT * FROM accounts WHERE accountID = :accountID";
$query = $db->prepare($query);
$query->execute([':accountID' => $accountID]);
$requests = $query->rowCount();
$result = $query->fetchAll();
$accinfo = $result[0];
$friendlist = $accinfo["friends"];
$friends = $accinfo["friends"];
$friendsarray = explode(',',$friendlist);
if(($key = array_search($targetAccountID, $friendsarray)) !== false) {
    unset($friendsarray[$key]);
}
$xxlnewfriends = implode(",",$friendsarray);
$query3 = $db->prepare("UPDATE accounts SET friends=:newfriends WHERE accountID=:accountID");
// REMOVING FOR USER 2
$query = "SELECT * FROM accounts WHERE accountID = :targetAccountID";
$query = $db->prepare($query);
$query->execute([':targetAccountID' = > $targetAccountID]);
$requests = $query->rowCount();
$result = $query->fetchAll();
$accinfo = $result[0];
$friendlist = $accinfo["friends"];
$friends = $accinfo["friends"];
$friendsarray = explode(',',$friendlist);
if(($key = array_search($accountID, $friendsarray)) !== false) {
    unset($friendsarray[$key]);
}
$newfriends = implode(",",$friendsarray);
$query2 = $db->prepare("UPDATE accounts SET friends=:newfriends WHERE accountID=:targetAccountID");
//EXECUTING THE QUERIES
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query3->execute([':newfriends' => $xxlnewfriends, ':accountID' = > $accountID]);
	$query2->execute([':newfriends' => $newfriends, ':targetAccountID' = > $targetAccountID]);
	echo "1";
}else{
	echo "-1";
}
?>