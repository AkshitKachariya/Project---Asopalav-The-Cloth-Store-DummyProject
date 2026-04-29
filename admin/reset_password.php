<?php
include('../db_con.php');
session_start();

// Prevent direct access
if (!isset($_SESSION['reset_email'])) {
    header("Location: admin_login.php");
    exit;
}

$error = $success = "";
$email = $_SESSION['reset_email'];

if (isset($_POST['reset_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (strlen($new_password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($db, "UPDATE admins SET admin_password = ? WHERE admin_email = ?");
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);
        if (mysqli_stmt_execute($stmt)) {
            unset($_SESSION['reset_email']);
            session_write_close();
            $success = "Password changed successfully.";
        } else {
            $error = "Failed to reset password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password | Asopalav.in</title>
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

        .success_info {
            color: green;
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
    <div class="form h-screen flex items-center justify-center px-10">
        <form method="post" class="p-5 w-[90%] md:w-[70%] lg:w-[40%] rounded-xl bg-transparent border-2 border-[#512DA8] shadow-gray-600 shadow-lg">
            <h1 class="font-bold text-2xl mb-2 text-[#512DA8]">
                <img src="../images/Asopalav Logo.avif" alt="Logo" class="w-[30%] mx-auto">
            </h1>
            <h2 class="font-medium text-md mb-6 text-center">Reset Password</h2>

            <?php if ($success): ?>
                <div class="success_info"><?= $success ?></div>
                <div class="text-center mt-4">
                    <a href="admin_login.php" class="inline-block px-5 py-2 bg-[#512DA8] text-white font-semibold rounded-lg hover:bg-transparent hover:text-[#512DA8] border border-[#512DA8] transition">Go to Login</a>
                </div>
            <?php else: ?>
                <div class="mb-6 group">
                    <div class="relative z-0 w-full">
                        <i class="fa-solid fa-lock field-icon"></i>
                        <input type="password" name="new_password" id="new_password" class="input" placeholder=" " required />
                        <label for="new_password" class="label">New Password</label>
                    </div>
                </div>

                <div class="mb-6 group">
                    <div class="relative z-0 w-full">
                        <i class="fa-solid fa-lock field-icon"></i>
                        <input type="password" name="confirm_password" id="confirm_password" class="input" placeholder=" " required />
                        <label for="confirm_password" class="label">Confirm Password</label>
                    </div>
                </div>

                <?php if ($error): ?>
                    <div class="error_info"><?= $error ?></div>
                <?php endif; ?>

                <div class="mb-4 group">
                    <input type="submit" name="reset_password" value="Reset Password"
                        class="w-full border hover:text-[#512DA8] hover:bg-transparent border-[#512DA8] py-2 px-4 font-semibold rounded-lg bg-[#512DA8] text-white cursor-pointer transition">
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script>
        document.body.style.opacity = 0;
        window.addEventListener("load", function() {
            document.body.style.opacity = 1;
        });
    </script>
</body>

</html>