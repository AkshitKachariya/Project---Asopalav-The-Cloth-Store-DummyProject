<?php

include('../db_con.php');

session_start();

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($db, $_POST['admin_email']);
    $password = $_POST['admin_password'];

    $stmt = mysqli_prepare($db, "SELECT admin_password FROM admins WHERE admin_email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        mysqli_stmt_bind_result($stmt, $hashed_password);
        mysqli_stmt_fetch($stmt);

        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_login'] = $email;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid Information!";
        }
    } else {
        $error = "Admin account not found!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/./asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../src/./output.css">
    <link rel="stylesheet" href=".././css/./all.css">
    <style>
        .toggle-icon {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
            transition: color 0.3s ease;
            color: #512DA8;
        }

        .field-icon {
            position: absolute;
            top: 50%;
            left: 0.5rem;
            transform: translateY(-50%);
            transition: color 0.3s ease;
            pointer-events: none;
            color: #512DA8;
        }

        .error {
            color: red;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            font-weight: 500;
            text-align: right;
        }

        .error_info {
            color: red;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 15px;
        }

        .input {
            padding-left: 2rem;
            padding-right: 2.5rem;
            padding-top: 0.625rem;
            padding-bottom: 0.625rem;
            width: 100%;
            font-size: 0.875rem;
            background-color: transparent;
            color: #111827;
            border: none;
            border-bottom: 2px solid #512DA8;
            appearance: none;
            outline: none;
            font-weight: 500;
        }

        .input:focus {
            border-bottom-color: #512DA8;
        }

        .label {
            position: absolute;
            left: 2rem;
            top: 0.75rem;
            font-size: 0.875rem;
            color: #6b7280;
            pointer-events: none;
            transition: 0.3s ease;
        }

        .input:focus~.label,
        .input:not(:placeholder-shown)~.label {
            font-weight: 500;
            color: #512DA8;
            transform: translateY(-1.3rem) scale(0.9);
            margin-left: -4px;
        }

        body {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        #login_btn {
            transition: 0.2s;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-[#decff8] text-[#512DA8] font-poppins">
    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-500">
        <div class="w-12 h-12 border-4 border-[#512DA8] border-t-transparent rounded-full animate-spin"></div>
    </div>

    <div class="form h-screen flex items-center justify-center px-10">
        <form action="" method="post" class="p-5 w-[90%] md:w-[70%] lg:w-[60%] xl:w-[40%] rounded-xl bg-transparent border-2 border-[#512DA8] shadow-gray-600 shadow-lg" id="registerForm" onsubmit="return validateForm()">

            <h1 class="font-bold text-2xl mb-2 text-[#512DA8] flex items-center justify-center">
                <img src="../images/./Asopalav Logo.avif" alt="" class="w-[30%]">
            </h1>

            <h2 class="font-medium text-lg mb-7 text-center">Login To Admin Panel</h2>
            <div class="mb-6 group">
                <div class="relative z-0 w-full">
                    <i class="fa-solid fa-envelope field-icon"></i>
                    <input type="text" name="admin_email" id="email" class="input" placeholder=" " required />
                    <label for="email" class="label">Email Address</label>
                </div>
            </div>

            <div class="mb-6 group">
                <div class="relative z-0 w-full">
                    <i class="fa-solid fa-lock field-icon"></i>
                    <input type="password" name="admin_password" id="password" class="input" placeholder=" " required />
                    <label for="password" class="label">Password</label>
                    <i class="fa-solid fa-eye toggle-icon" onclick="togglePassword('password', this)"></i>
                </div>
            </div>

            <div class="error_info">
                <?php
                if (isset($error)) {
                    echo $error;
                }
                ?>
            </div>

            <div class="mb-4 group">
                <input type="submit" id="login_btn" value="Login" class="w-full border hover:text-[#512DA8] hover:bg-transparent border-[#512DA8] py-2 px-4 font-semibold rounded-lg bg-[#512DA8] text-white" name="login">
            </div>

            <div class="forgot text-center font-medium text-sm text-[#512DA8] hover:text-purple-700 active:text-purple-900">
                <a href="admin_forgot_password.php">Forgot Password?</a>
            </div>
        </form>
    </div>

    <script>
        window.addEventListener("load", function() {
            const preloader = document.getElementById("preloader");
            preloader.classList.add("opacity-0");
            document.body.style.opacity = "1";
            setTimeout(() => {
                preloader.style.display = "none";
            }, 100);
        });

        function togglePassword(id, icon) {
            const input = document.getElementById(id);
            const isVisible = input.type === 'text';
            input.type = isVisible ? 'password' : 'text';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }

        function validateField(input) {
            const value = input.value.trim();
            const id = input.id + '_error';
            const errorElement = document.getElementById(id);
            if (value === '') {
                errorElement.innerText = `${input.id.charAt(0).toUpperCase() + input.id.slice(1)} is required`;
                return false;
            } else {
                errorElement.innerText = '';
                return true;
            }
        }

        function validateForm() {
            const email = document.getElementById("email");
            const password = document.getElementById("password");
            const isEmailValid = validateField(email);
            const isPasswordValid = validateField(password);
            return isEmailValid && isPasswordValid;
        }
    </script>

</body>

</html>