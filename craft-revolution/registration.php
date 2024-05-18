<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width = device-width, 
	initial-scale = 1, shrink-to-fit = no">
	<link rel="icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
	<title>Регистрация "Строительная революция"</title>
</head>
<body class="body body_main">
	<?php
        session_start();
        echo "<script>console.log('Session started!');</script>";
    ?>
    <?php include 'php/connectdb.php';
    ?>
    <div class="llogo">
        <a href="index.php" class="llogo_a"><img src="img/logo2.svg"></a>
        <a href="index.php" class="llogo_a"><h2>Строительная</br>революция</h2></a>
    </div>
    <form action="" method="POST" class="myform"> 
        <input type="text" name="sname" placeholder="Фамилия" class="myinput" required="required"> 
        <input type="text" name="name" placeholder="Имя" class="myinput" required="required">
        <input type="text" name="mname" placeholder="Отчество" class="myinput" required="required"> 
        <input type="text" name="phone" placeholder="Телефон" class="myinput" required="required" id="phone">
        <input type="email" name="email" placeholder="Почта" class="myinput" required="required">
        <input type="password" name="pass" placeholder="Пароль" class="myinput" required="required">
        <input type="submit" name="submit" value="Зарегистрироваться" class="mysubmit">
        <p class="alert" id="alid">Извините, введённый вами телефон уже зарегистрирован. Введите другой телефон.</p>
    </form>
    <div class="reg">
    <p class="p-reg">Уже есть аккаунт? <a href="login.php" class="a-reg">Авторизуйтесь!</a></p>
    </div>
    <?php
if(isset($_POST['submit'])){
    if (empty($phone) or empty($pass))
    {
       echo "<script>warn('Извините, введённый вами телефон уже зарегистрирован. Введите другой телефон.')</script>";
    }
    if (isset($_POST['sname'])) 
        { 
            $sname = $_POST['sname'];
            if ($sname == '') { unset($sname);} 
        }
    if (isset($_POST['name'])) 
        { 
            $name = $_POST['name'];
            if ($name == '') { unset($name);} 
        }
    if (isset($_POST['mname'])) 
        { 
            $mname = $_POST['mname'];
            if ($mname == '') { unset($mname);} 
        }
    if (isset($_POST['phone'])) 
        { 
            $phone = $_POST['phone'];
            if ($phone == '') { unset($phone);} 
        }
    if (isset($_POST['email'])) 
        { 
            $email = $_POST['email'];
            if ($email == '') { unset($email);} 
        }
    if (isset($_POST['pass'])) 
        { $pass=$_POST['pass']; 
            if ($pass =='') { unset($pass);} 
        }
    $result = $mysqli->query("SELECT ID FROM User WHERE Phone = '$phone'"); 
    $myrow = $result->fetch_assoc();
    if (!empty($myrow['ID'])) {
    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                        var element = document.getElementById('alid');
                        if (element) {
                        element.style.display = 'flex';
                        }
                        });
                    </script>";
    exit();
    }
    $pass=password_hash($pass, PASSWORD_DEFAULT);
    $result2 = $mysqli->query ("INSERT INTO User (SurName, FirName, MidName, Phone, Email, Password) VALUES('$sname', '$name', '$mname', '$phone','$email', '$pass')");
    if ($result2 != FALSE)
    {
      header("Location: index.php");
      echo "Ошибка: " . $mysqli->error;
    }
     else {
    echo "Ошибка! Вы не зарегистрированы.";
    echo "Ошибка: " . $mysqli->error;
    }}
    ?>
    <script>
function mask(event) {
    event.keyCode && (keyCode = event.keyCode);
    var pos = this.selectionStart;
    if (pos < 1) event.preventDefault();
    var matrix = "8__________",
        i = 0,
        def = matrix.replace(/\D/g, ""),
        val = this.value.replace(/\D/g, ""),
        new_value = matrix.replace(/[_\d]/g, function(a) {
            return i < val.length ? val.charAt(i++) || def.charAt(i) : a
        });
    i = new_value.indexOf("_");
    if (i != -1) {
        i < 2 && (i = 1);
        new_value = new_value.slice(0, i)
    }
    var reg = matrix.substr(0, this.value.length).replace(/_+/g,
        function(a) {
            return "\\d{1," + a.length + "}"
        }).replace(/[+()]/g, "\\$&");
    reg = new RegExp("^" + reg + "$");
    if (!reg.test(this.value) || this.value.length < 2 || keyCode > 47 && keyCode < 58) this.value = new_value;
    if (event.type == "blur" && this.value.length < 2)  this.value = ""
}

window.onload = function() {
    document.getElementById('phone').addEventListener('input', mask);
    document.getElementById('phone').addEventListener('blur', mask);
}
</script>
</body>
</html>