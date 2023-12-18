<?php
$dbname='test.db';

if(!empty($_POST)){
    if(isset($_POST['name'], $_POST['password']) && !empty($_POST['name']) && !empty($_POST['password'])){
       $name = strip_tags($_POST['name']);
       $password = password_hash($_POST['password'], PASSWORD_ARGON2ID);
       $db = new SQLite3($dbname);
       $db->exec("INSERT INTO user(name, pass, type) VALUES('$name', '$password', 0)");
	   header('Location:  profil.php');
    }
    else{
    	echo "<p style='color:red;text-align:center;'>Please Complete the form</p>";
    }
}


?>
<!DOCTYPE html>
<style>
html {
	background-color: rgb(30,30,30);
}
div{
	background-color: rgb(49,49,49);
	border-radius: 10px;
	padding: 2%;
	margin: 15%;
	margin-top: 0%;
}
input[type=text],input[type=password]{
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  opacity: 200%;
}
label{
	color: white;
	padding: right;
}
button{
  width: 100%;
  background-color: rgb(35,134,54);
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  opacity: 100%;
}
button:hover{
	background-color: rgb(46,160,67);
}
h1{
	text-align: center;
	color: white;
}
</style>
<h1>Register</h1>
<div>
	<form  method="post">
		<label for='name'>User name</label>
		<input type="text" name="name" id='name' />
		<label for='password'>Password</label>
		<input type="password" name="password" id='password'/>
		<button type="submit" value="OK">Register</button></div>
	</form>
</div>
</html>


