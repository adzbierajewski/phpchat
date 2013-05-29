<?php
function clean_input($input){
		return strip_tags($input);
}

function get_count(){
	$db = new Mysqlidb(db_host,db_username,db_password,db_name);
	// Check connection
	if (mysqli_connect_errno())
	{
		die('<h1>Database Error</h1>');
	}
	//$result = mysqli_query($con,"SELECT * FROM chats");
	$result = $db->get('chats', '');
	if($result){
		return $result->num_rows;
		mysqli_close($con);
		return true;
	} else {
		return false;
	}
}
function add_chat($fromwhere, $who, $chat){
	$db = new Mysqlidb(db_host,db_username,db_password,db_name);
	// Check connection
	if(get_count()==chatlimit){
		if(mysqli_query($con,"TRUNCATE table chats")){
			return true;
		} else {
			return false;
		}
	}
	
	$insertData = array(
    'playername' => clean_input($who),
    'message' => clean_input($chat),
    'ipaddress' => clean_input($_SERVER["REMOTE_ADDR"]),
    'timedate' => gmmktime()
);

if($db->insert('chats', $insertData)){
	return true;
}
}

function get_chats($timeformat){
	$con = mysqli_connect(db_host,db_username,db_password,db_name);
	if (mysqli_connect_errno())
	{
		die('<h1>Database Error</h1>');
	}
$result = mysqli_query($con,'SELECT playername, message, timedate FROM  `chats` ORDER BY  `timedate` ASC ');
while($row = mysqli_fetch_array($result))
  {
  print gmdate($timeformat, $row['timedate']) . ' - ' . $row['playername'] . ': ' . $row['message'] . '<br />';
  }
mysqli_close($con);
}
?>
