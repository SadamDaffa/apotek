<?php
session_start();
require_once 'functions/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Buat koneksi langsung
    $conn = mysqli_connect('localhost', 'root', '', 'apotek_kalangsari');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query untuk memeriksa apakah username dan password cocok dalam database
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $user, $pass);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        // Username dan password cocok dalam database
        $row = mysqli_fetch_assoc($result);
        
        // Login berhasil, set session
        $_SESSION['level'] = $row['level'];
        echo "Login berhasil. Redirect ke index.php"; // Output pesan sukses
        header('Location: index.php'); // Redirect ke halaman setelah login berhasil
        exit;
    } else {
        // Username atau password tidak cocok
        echo "Login gagal. Username atau password salah.";
    }

    // Tutup koneksi
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Login Admin</title>
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<style type="text/css">
		body {
			background: rgb(28, 36, 0);
		}
		form{
			min-height: 80vh;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}

		.kotak {
			padding: 10px 30px;
			background: rgb(28, 36, 0);
			background: linear-gradient(127deg, rgba(28, 36, 0, 1) 0%, rgba(71, 121, 9, 1) 31%, rgba(93, 137, 8, 1) 48%, rgba(149, 188, 16, 1) 75%, rgba(249, 255, 0, 1) 100%);
			color: #fff;
			border: 2px solid rgba(255, 255, 255, 0.5);
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
		}

		.kotak .input-group {
			margin-bottom: 20px;
		}
	</style>
</head>

<body>
	<div class="container-fluid">
		<h1 class="text-center " style="color: white">SISTEM INFORMASI APOTEK</h1>
		<form action="" method="post">
			<div class="col-md-3 kotak">
				<h3 class="text-center">Login</h3>
				<?php if (isset($error)) : ?>
					<p style="color: red;font-style: italic; float: right">Username / Password Salah!</p>
					<p style="color: red;font-style: italic; float: right"><?php echo $message ?></p>
				<?php endif; ?>
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" autofocus />
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off">
				</div>
				<div class="form-group">
					<input type="submit" name="login" class="btn btn-primary form-control" value="Login">
				</div>
				<br>
				<center>
					<p>belum punya akun? <a href="register.php">register</a></p>
				</center>
			</div>
		</form>
	</div>
</body>

</html>