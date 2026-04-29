<?php
include('check_session.php'); // ensure admin is logged in
include('../db_con.php');

$msg = "";
$success = "";

if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current admin password
    $stmt = mysqli_prepare($db, "SELECT admin_password FROM admins WHERE admin_email = ?");
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['admin_login']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashed_password);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (password_verify($old_password, $hashed_password)) {
        if ($new_password === $confirm_password) {
            $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_stmt = mysqli_prepare($db, "UPDATE admins SET admin_password = ? WHERE admin_email = ?");
            mysqli_stmt_bind_param($update_stmt, "ss", $new_hashed_password, $_SESSION['admin_login']);
            if (mysqli_stmt_execute($update_stmt)) {
                $success = "Password changed successfully! <a href='admin_logout.php' class='underline text-[#512DA8]'>Logout</a>";
            } else {
                $msg = "An error occurred. Please try again.";
            }
            mysqli_stmt_close($update_stmt);
        } else {
            $msg = "New password and confirm password do not match.";
        }
    } else {
        $msg = "Old password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../src/output.css">
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
            pointer-events: none;
            color: #512DA8;
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

        .error_info {
            color: red;
            font-size: 0.8rem;
            margin: 10px 0;
            font-weight: 600;
            text-align: center;
        }

        .success_info {
            color: green;
            font-size: 0.9rem;
            margin: 10px 0;
            font-weight: 600;
            text-align: center;
        }

        #change_password_btn {
            transition: 0.2s;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-[#decff8] text-[#512DA8] font-poppins">

    <?php include('./admin_parts/header.php'); ?>
    <?php include('./admin_parts/sidebar.php'); ?>

    <main class="flex-1 p-4 overflow-y-auto flex items-center justify-center">
        <form action="" method="post" class="p-5 w-[90%] md:w-[60%] lg:w-[40%] rounded-xl bg-white shadow-lg text-[#512DA8]">
            <h2 class="font-bold text-2xl mb-6 text-center">Change Password</h2>

            <?php if ($msg) { ?>
                <div class="error_info"><?php echo $msg; ?></div>
            <?php } ?>
            <?php if ($success) { ?>
                <div class="success_info"><?php echo $success; ?></div>
            <?php } ?>

            <div class="mb-4 relative">
                <i class="fa-solid fa-lock field-icon"></i>
                <input type="password" name="old_password" id="old_password" class="input" placeholder=" " required>
                <label for="old_password" class="label">Old Password</label>
                <i class="fa-solid fa-eye toggle-icon" onclick="togglePassword('old_password', this)"></i>
            </div>

            <div class="mb-4 relative">
                <i class="fa-solid fa-lock field-icon"></i>
                <input type="password" name="new_password" id="new_password" class="input" placeholder=" " required>
                <label for="new_password" class="label">New Password</label>
                <i class="fa-solid fa-eye toggle-icon" onclick="togglePassword('new_password', this)"></i>
            </div>

            <div class="mb-4 relative">
                <i class="fa-solid fa-lock field-icon"></i>
                <input type="password" name="confirm_password" id="confirm_password" class="input" placeholder=" " required>
                <label for="confirm_password" class="label">Confirm New Password</label>
                <i class="fa-solid fa-eye toggle-icon" onclick="togglePassword('confirm_password', this)"></i>
            </div>

            <input type="submit" name="change_password" id="change_password_btn" value="Change Password"
                class="w-full border border-[#512DA8] bg-[#512DA8] text-white py-2 px-4 rounded-lg hover:bg-transparent hover:text-[#512DA8] transition-all">
        </form>
    </main>

    <?php include('./admin_parts/footer.php'); ?>

    <script>
        function togglePassword(id, icon) {
            const input = document.getElementById(id);
            const isVisible = input.type === 'text';
            input.type = isVisible ? 'password' : 'text';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>
</body>

</html>