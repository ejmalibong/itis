<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/nbc_bg.jpg" type="image/x-icon" />
    <title>Login</title>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../style/bootstrap.min.css"/>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("../images/estetik_bg.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }

        .navbar {
            height: 80px;
        }

        .login-container {
            max-width: 400px;
            margin: 35vh auto;
            padding: 20px;
            background-color: #f7f7f7;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            /* margin-top: 0 auto; */
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-form-group {
            margin-bottom: 15px;
        }

        .login-form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .login-form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-form-group button {
            width: 100%;
            padding: 10px;
            background-color: #3275b9;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form-group button:hover {
            background-color: #195b8e;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-body-tertiary sticky-top" style="background-color: #f7f7f7;">
        <div class="container-fluid">
            <div>
                <a class="navbar-brand m-2" style="vertical-align: middle;"><img src="../images/nbc_bg.jpg" alt="NBC Logo" height="45"></a>
                <a class="navbar-brand m-1 h2" style="vertical-align: middle; color: #3275b9; cursor: default;"><strong>IT Inventory System</strong></a>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="login_process.php">
            <div class="login-form-group">
                <label for="password">ID Number</label>
                <input type="username" id="password" name="password" required>
            </div>
            <div class="login-form-group">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
