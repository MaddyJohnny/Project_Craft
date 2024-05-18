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
	<title>Вход в аккаунт "Строительная революция"</title>
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
	    <input type="text" name="phone" placeholder="Телефон" class="myinput" required="required" id="phone"> 
	    <input type="password" name="pass" placeholder="Пароль" class="myinput" required="required"> 
	    <input type="submit" name="submit" class="mysubmit"> 
        <p class="alert" id="alid">Извините, введённый вами логин или пароль неверный.</p> 
	</form>
    <div class="reg">
    <p class="p-reg">Еще не зарегистрированы? <a href="registration.php" class="a-reg">Зарегистрируйтесь!</a></p>
    </div>
	<?php
session_start();
if(isset($_POST['submit'])){
    if (isset($_POST['phone'])) { 
        $phone = $_POST['phone']; 
        if ($phone == '') { unset($phone);} 
    }
    if (isset($_POST['pass'])) { 
        $pass= $_POST['pass']; 
        if ($pass =='') { unset($pass);} 
    }
    if (!empty($phone) and !empty($pass)) {
        $stmt = $mysqli->prepare("SELECT * FROM User WHERE phone=?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === FALSE) {
            error_log("Ошибка выполнения запроса: " . $mysqli->error);
            echo "Произошла ошибка. Пожалуйста, попробуйте еще раз.";
        } else {
            $myrow = $result->fetch_assoc();
            if (empty($myrow['Phone'])) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                        var element = document.getElementById('alid');
                        if (element) {
                        element.style.display = 'flex';
                        }
                        });
                    </script>";
            } else {
                if (password_verify($pass, $myrow['Password'])) {
                    $_SESSION['phone']=$myrow['Phone'];
                    $_SESSION['id']=$myrow['ID'];
                    header("Location: index.php");
                } else {
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                        var element = document.getElementById('alid');
                        if (element) {
                        element.style.display = 'flex';
                        }
                        });
                    </script>";
                }
            }
        }
    }
    if (empty($phone) or empty($pass)) {
        echo "<script>window.alert('Вы ввели не всю информацию, вернитесь назад и заполните все поля!')</script>";
    }
}
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