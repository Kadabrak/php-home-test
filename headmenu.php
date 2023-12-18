<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
  position: fixed;
  top: 0;
  width: 100%;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #111;
}
</style>

<head>
		<ul class="headmenu">
			<li><a class="li_first_menu" href="/home.html" class="menu">Arlk</a></li>
			<li><a class="li_first_menu" href="/musique/musique.php" class="menu">Musique</a></li>
			<li><a class="li_first_menu" href="/actualité/actualité.html" class="menu">Acualité</a></li>
			<li><a class="li_first_menu" href="/get_login.php" class="menu">Password Manager</a></li>
<?php
session_start();
if(count($_SESSION) === 0){
	echo '<li style="float:right"><a class="li_first_menu" href="/login.php" class="menu">Sign in</a></li>';
	echo '<li style="float:right"><a class="li_first_menu" href="/register.php" class="menu">Register</a></li>';
}
elseif($_SESSION["user"]["role"] === 0){
	echo '<li style="float:right"><a class="li_first_menu" href="/disconnect.php" class="menu">Disconnect</a></li>';
    echo '<li style="float:right"><a class="li_first_menu" href="/profil.php" class="menu">'.$_SESSION['user']['name']."</a></li>";
}
elseif($_SESSION['user']["role"] === 1){
	echo '<li style="float:right"><a class="li_first_menu" href="/disconnect.php" class="menu">Disconnect</a></li>';
    echo '<li style="float:right"><a class="li_first_menu" href="/profil.php" class="menu">'.$_SESSION['user']['name']."</a></li>";
	echo '<li style="float:right"><a class="li_first_menu" href="/admin.php" class="menu">Admin</a></li>';
}
?>
		</ul>
</head>
