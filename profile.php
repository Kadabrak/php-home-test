<style>
html{
	background-color: rgb(30,30,30);
}

h1{
	color:white;
	text-align: center;
}
div.profil{
	margin-top:64px;
	background-color: rgb(49,49,49);
	margin-left: 20%;
	margin-right: 20%;
	border-radius: 10px;
	display: block;
}
img.profil{
	margin: auto;
	display: block;
}
p{
	color: white;
	padding: 32px;
	font-weight: bold;
}
hr{
	margin-left: auto;
	margin-right: auto;
	height: 2px;
	border-width:0;
	padding-top: 0px;
	background-color: white;
}
div.background-profil{
	border-radius: 10px 10px 0px 0px;
}
div.message{
	margin-top:32px;
	background-color: rgb(49,49,49);
	margin-left: 20%;
	margin-right: 20%;
	border-radius: 10px;
	display: block;
}
div.message:hover,div.post:hover{
	box-shadow: 0 4px 8px 0 rgba(255, 255, 255, 0.2),0 6px 20px 0 rgba(255, 255, 255, 0.2),0 6px 20px 0 rgba(255, 255, 255, 0.2);
}
textarea{
		background-color: rgb(98,98,98);
		border-radius: 5px;
		padding-top: 5px;
		padding-left: 5px;
		border: None;
		width: 90%;
		margin-left: 5%;
		height: 120px;
		resize: none;
		font-size: 20px;
		color: white;
}
textarea:focus {
  border: 0px;
}
button[type=submit] {
	margin-left: 10%;
	color: white;
	width: 50%;
	background-color: green;
	margin-top: 32px;
	margin-bottom: 32px;
	width: 20%;
	margin-left: 40%;
	border-radius: 5px;
	height: 30px;
	border: None;
}
button[type=submit]:hover {
	animation-name: button-hover;
	font-weight: bold;
	background-color: red;
	animation-duration: 0.3s;
	animation-iteration-count: infinite;
}
@keyframes button-hover {
  0%   {rotate: 0deg;}
  25%  {rotate: 5deg;}
  50%  {rotate: 0deg;}
  75%  {rotate: -5deg;}
  100% {rotate: 0deg;}
}
h2{
	padding-top: 32px;
	color: white;
	text-align: center;
}
div.post{
	margin-top:32px;
	background-color: rgb(49,49,49);
	margin-left: 20%;
	margin-right: 20%;
	border-radius: 10px;
}
div.post_head{
	width: 100%;
	border-radius: 10px 10px 0px 0px ;
}
h3.post{
	color: white;
	display:inline-block;
	padding-left: 10px;
	margin-top: 30px;
	margin-bottom: 0;
}
img.post_head{
	margin-top: 10px;
	margin-left: 5px;
}

</style>
<html>
<?php
function get_user_profil($dbname,$user_id){
	$db = new SQLite3($dbname);
    $sql = $db->query("SELECT description,picture,background_color,id FROM user_profil WHERE owner_id=".$user_id);
	$result = $sql->fetchArray(SQLITE3_ASSOC);
	if($result['id'] === NULL){
		create_profil($dbname,$user_id);
		$db = new SQLite3($dbname);
		$sql = $db->query("SELECT description,picture,background_color,id FROM user_profil WHERE owner_id=".$user_id);
		$result = $sql->fetchArray(SQLITE3_ASSOC);
	}
	return array($result["picture"],$result["description"],$result["background_color"]);
}
function create_profil($dbname,$id){
	$db = new SQLite3($dbname);
	$db->exec("INSERT INTO user_profil (owner_id) VALUES('$id')");
}
function profil_head($dbname,$profil){
	echo "<div class='profil'>";
	echo "<div class='background-profil' style='background-color:#".$profil[2].";'>";
	echo '<img class="profil" src="/Images/'.$profil[0].'.png" width="128" height="128" style="filter: invert(100%)"/>';
	echo '<hr>';
	echo "</div>";
	echo "<h1>".$_SESSION['user']['name']."</h1>";
	echo "<p>".$profil[1]."</p>";
	echo "</div>";	
}
function post_display($all_post,$profil){
	$all_post = array_reverse($all_post);
	foreach($all_post as $post){
		echo "<div class='post'>";
		echo "<div class='post_head' style='background-color:#".$profil[2].";'>";
		echo "<div style='display:inline-block;vertical-align:top;'>";
		echo '<img class ="post_head" src="/Images/'.$profil[0].'.png" width="64" height="64" style="filter: invert(100%)"/>';
		echo "</div>";
		echo "<h3 class='post'>".$_SESSION['user']['name']."</h3>";
		echo '<hr>';
		echo "</div>";
		echo "<div style='padding-left: 10px;margin-top: 10px; padding-bottom: 10px;'><span style='color:white;'>".$post."</span></div>";
		echo "</div>";	
	}
}
function say_it($dbname){
	echo "<div class='message'>";
	echo '<form  method="post" action="/profil.php">';
	echo "	<h2>What do you want to say ?</h2>";
	echo '	<textarea name="text"></textarea>';
	echo '	<button type="submit" value="text">SAY IT !</button>';
	echo '</form>';
    echo '</div>';	
}
function save_post($dbname,$message,$userid){
	$message = strip_tags($message);
	$db = new SQLite3($dbname);
	$db->exec("INSERT INTO post (owner_id,text) VALUES('$userid','$message')");
	unset($_POST['text']);
	echo '<meta http-equiv="refresh" content="0.5">';
}
function get_post($dbname,$userid){
	$datab = new SQLite3($dbname);
    $sqlite = $datab->query("SELECT text FROM post WHERE owner_id=".$userid);
	$all_post_user = array();
	while($row = $sqlite->fetchArray(SQLITE3_ASSOC)){
			array_push($all_post_user,$row['text']);
	}
	return $all_post_user;
}
session_start();
if(!$_SESSION){
	header("Location: login.php");
	exit;
}
elseif($_SESSION['user']["role"] === 0 or $_SESSION["user"]["role"] === 1){
	$dbname = 'test.db';
	$profil = get_user_profil($dbname,$_SESSION['user']['id']);
	profil_head($dbname,$profil);
	say_it($dbname);
	$all_post = get_post($dbname,$_SESSION['user']['id']);
	post_display($all_post,$profil);
	if(!empty($_POST)){
		if(!empty($_POST['text'])){
			save_post($dbname,$_POST["text"],$_SESSION['user']['id']);
		}
	}
	include 'headmenu.php';
}
?>
</html>
