<?php
if(!$app){header("HTTP/1.0 403 Forbidden");exit;}
$authByKey = false;
if(strlen($_GET['key']) == 32)
	$authByKey = true;
if($core->isAuth() && !$authByKey){echo '<script type="text/javascript">location.href="/account"</script>';die('Forbidden');}
$key = $_GET['key'];

function removeKey($k,&$mysqli){
	$query = $mysqli->query("UPDATE `users` SET AuthKey = '' WHERE AuthKey = '$k'");
}
if($authByKey){
	$query = $mysqli->query("SELECT * FROM `users` WHERE AuthKey = '$key'");
	removeKey($key, $mysqli);
	
	if(!$query)die;
	$res = mysqli_fetch_array($query);
	if(empty($res['id']))die;
	$core->auth($res['id'], $res['email'], $res['password']);
	header('Refresh: 0; url=/account');
}
if(isset($_POST['query'])){//Если запрос послан
	//Обрабатываем данные
	$email = $mysqli->real_escape_string(htmlspecialchars(trim($_POST['email'])));
	$password = md5(md5(trim($_POST['password'])));
	
	$query = $mysqli->query("SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'");
	if($query){
		$res = mysqli_fetch_array($query);
		if(!empty($res['id'])){
			$core->auth($res['id'], $res['email'], $res['password']);
			header('Refresh: 0; url=/account');
		}else{
			$core->showError('Пользователя с такой связкой "E-mail - пароль не существует".');
		}
	}else{
		$core->showError('Ошибка запроса');
	}
}else{
?>
<div class="accountWrap">
	<a href="/" class="accountLogo">
	</a>
	<div class="shadowWrap">
		<div class="accountMenu">
			<div class="left">
				<a href="/resetPassword">Забыли пароль?</a>
			</div>
			<div class="right">
				<a href="/signup">Зарегистрироваться</a>
			</div>
		</div>
		<div class="accountUploads">
			<form action="#" method="POST" name="regForm" class="regForm">
				<input type="hidden" name="query">
				<input type="text" name="email" placeholder="E-Mail">
				<br><input type="password" name="password" placeholder="Пароль">
				<br><input type="submit" name="submit" value="Вход">
			</form>
		</div>
	</div>
</div>
<?php
}
$mysqli->close();
?>