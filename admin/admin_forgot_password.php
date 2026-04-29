<?php
include('../db_con.php');

session_start();
$error = "";

if (isset($_POST['reset_request'])) {
    $email = mysqli_real_escape_string($db, $_POST['admin_email']);

    $stmt = mysqli_prepare($db, "SELECT admin_id FROM admins WHERE admin_email = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            $_SESSION['reset_email'] = $email;
            header("Location: reset_password.php");
            exit;
        } else {
            $error = "Email Not Found!";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Query error: " . mysqli_error($db);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../src/output.css">
    <style>
        .field-icon {
            position: absolute;
            top: 50%;
            left: 0.5rem;
            transform: translateY(-50%);
            color: #512DA8;
            pointer-events: none;
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
            outline: none;
            font-weight: 500;
        }

        .input:focus {
            border-bottom-color: #512DA8;
        }

        .input:focus~.label,
        .input:not(:placeholder-shown)~.label {
            font-weight: 500;
            color: #512DA8;
            transform: translateY(-1.3rem) scale(0.9);
            margin-left: -4px;
        }

        .error_info {
            color: red;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 15px;
        }

        body {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>

<body class="bg-[#decff8] text-[#512DA8] font-poppins">

    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-500">
        <div class="w-12 h-12 border-4 border-[#512DA8] border-t-transparent rounded-full animate-spin"></div>
    </div>

    <div class="form h-screen flex items-center justify-center px-10">
        <form method="post" class="p-5 w-[90%] md:w-[70%] lg:w-[40%] rounded-xl bg-transparent border-2 border-[#512DA8] shadow-gray-600 shadow-lg">

            <h1 class="font-bold text-2xl mb-2 text-[#512DA8]">
                <img src="../images/Asopalav Logo.avif" alt="Logo" class="w-[30%] mx-auto">
            </h1>
            <h2 class="font-medium text-md mb-6 text-center">Forgot Password</h2>

            <div class="mb-6 group">
                <div class="relative z-0 w-full">
                    <i class="fa-solid fa-envelope field-icon"></i>
                    <input type="email" name="admin_email" id="email" class="input" placeholder=" " required />
                    <label for="email" class="label">Email Address</label>
                </div>
            </div>

            <?php if ($error): ?>
                <div class="error_info"><?= $error ?></div>
            <?php endif; ?>

            <div class="mb-4 group">
                <input type="submit" name="reset_request" value="Reset Password"
                    class="w-full border hover:text-[#512DA8] hover:bg-transparent border-[#512DA8] py-2 px-4 font-semibold rounded-lg bg-[#512DA8] text-white cursor-pointer transition">
            </div>

            <div class="text-center text-sm text-[#512DA8] hover:text-purple-700 active:text-purple-900">
                <a href="admin_login.php">Back to Login</a>
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
    </script>
</body>

</html>