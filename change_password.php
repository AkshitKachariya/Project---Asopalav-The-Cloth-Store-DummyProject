<?php
session_start();
include('./db_con.php');

if (!$_SESSION['session']) {
    header('location:login.php');
    die;
}

$session = $_SESSION['session'];
$data = mysqli_query($db, "select * from users where user_email='$session'");
$array = mysqli_fetch_array($data);

$msg = "";
$success = "";

if (isset($_REQUEST['change_password'])) {
    $old_password = $_REQUEST['old_password'];
    $new_password = $_REQUEST['new_password'];
    $confirm_password = $_REQUEST['confirm_password'];

    if (password_verify($old_password, $array['user_password'])) {
        if ($new_password === $confirm_password) {
            $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update = mysqli_query($db, "UPDATE users SET user_password = '$hashed_new_password' WHERE user_email = '$session'");

            if ($update) {
                $success = "Password changed successfully! <a href='logout.php' class='underline text-[#c28e5c]'>Logout</a>";
            } else {
                $msg = "An error occurred. Please try again.";
            }
        } else {
            $abc = "New password and confirm password do not match.";
        }
    } else {
        $abc = "Old password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | Asopalav.in</title>
    <script src="./jquery-3.7.1.min.js"></script>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
    <style>
        :root {
            --main-color: #333333;
            --hover-color: #1a1a1a;
        }

        .toggle-icon {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
            transition: color 0.3s ease;
            color: var(--main-color);
        }

        .field-icon {
            position: absolute;
            top: 50%;
            left: 0.5rem;
            transform: translateY(-50%);
            transition: color 0.3s ease;
            pointer-events: none;
            color: var(--main-color);
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            height: 45px;
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
            border-bottom: 2px solid var(--main-color);
            appearance: none;
            outline: none;
            font-weight: 500;
        }

        .input:focus {
            border-bottom-color: var(--hover-color);
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
            color: var(--main-color);
            transform: translateY(-1.3rem) scale(0.9);
            margin-left: -4px;
        }

        #change_password_btn {
            transition: 0.2s;
            cursor: pointer;
            background-color: var(--main-color);
        }

        #change_password_btn:hover {
            background-color: transparent;
            color: var(--main-color);
        }
    </style>
</head>

<body>
    <header class="sticky top-0 z-10">
        <?php include('./main_header.php'); ?>
    </header>

    <main class="py-10 lg:px-20 px-5 flex flex-col items-center justify-center min-h-[50vh]">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm max-w-md w-full text-center transform transition-all duration-500 shadow-gray-800">
            <h2 class="text-2xl font-playfair font-semibold text-[#c28e5c] mb-1">
                Change Password
            </h2>
            <p class="text-gray-500 text-sm mb-10">
                Please enter your old and new passwords.
            </p>

            <form action="" method="post" id="changePasswordForm">
                <div class="space-y-6 text-left text-gray-700">

                    <div>
                        <div class="input-wrapper group">
                            <i class="fas fa-envelope field-icon text-lg text-[#2e2e2e]"></i>
                            <input type="email" name="user_email" id="user_email" class="input" value="<?php echo $array['user_email']; ?>" placeholder=" " readonly />
                            <label for="user_email" class="label">Email</label>
                        </div>
                    </div>

                    <div>
                        <div class="input-wrapper group">
                            <i class="fas fa-lock field-icon text-lg text-[#2e2e2e]"></i>
                            <input type="password" name="old_password" id="old_password" class="input" placeholder=" " />
                            <label for="old_password" class="label">Old Password</label>
                            <i class="fa-solid fa-eye-slash toggle-icon" onclick="togglePassword('old_password', this)"></i>
                        </div>
                        <div class="text-red-500 text-sm mt-1" id="old-password-error"></div>
                    </div>
                    <div>
                        <div class="input-wrapper group">
                            <i class="fas fa-lock field-icon text-lg text-[#2e2e2e]"></i>
                            <input type="password" name="new_password" id="new_password" class="input" placeholder=" " />
                            <label for="new_password" class="label">New Password</label>
                            <i class="fa-solid fa-eye-slash toggle-icon" onclick="togglePassword('new_password', this)"></i>
                        </div>
                        <div class="text-red-500 text-sm mt-1" id="new-password-error"></div>
                    </div>
                    <div>
                        <div class="input-wrapper group">
                            <i class="fas fa-lock field-icon text-lg text-[#2e2e2e]"></i>
                            <input type="password" name="confirm_password" id="confirm_password" class="input" placeholder=" " />
                            <label for="confirm_password" class="label">Confirm New Password</label>
                            <i class="fa-solid fa-eye-slash toggle-icon" onclick="togglePassword('confirm_password', this)"></i>
                        </div>
                        <div class="text-red-500 text-sm mt-1" id="confirm-password-error"></div>
                    </div>
                </div>

                <?php if (!empty($msg)): ?>
                    <div class="text-red-500 text-center text-base mt-6">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="text-green-500 text-center text-base mt-6">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-6">
                    <input type="submit" id="change_password_btn" name="change_password" value="Change Password"
                        class="w-full text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform text-sm cursor-pointer border-[#333333] border-2 hover:scale-101 ">
                </div>
            </form>
        </div>
    </main>

    <footer class="mb-10 lg:mb-0">
        <?php include('main_footer.php'); ?>
    </footer>

    <script>
        function togglePassword(id, icon) {
            const input = document.getElementById(id);
            const isVisible = input.type === 'text';
            input.type = isVisible ? 'password' : 'text';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }

        $(document).ready(function() {
            $('#changePasswordForm').on('submit', function(e) {
                let isValid = true;
                $('.text-red-500').text('');

                const oldPassword = $('#old_password').val().trim();
                const newPassword = $('#new_password').val().trim();
                const confirmPassword = $('#confirm_password').val().trim();

                if (oldPassword === '') {
                    $('#old-password-error').text('Old password is required.');
                    isValid = false;
                }

                if (newPassword === '') {
                    $('#new-password-error').text('New password is required.');
                    isValid = false;
                } else if (newPassword.length < 8) {
                    $('#new-password-error').text('Password must be at least 8 characters long.');
                    isValid = false;
                }

                if (confirmPassword === '') {
                    $('#confirm-password-error').text('Confirming new password is required.');
                    isValid = false;
                } else if (newPassword !== confirmPassword) {
                    $('#confirm-password-error').text('Passwords do not match.');
                    isValid = false;
                }

                if (oldPassword !== '' && newPassword !== '' && oldPassword === newPassword) {
                    $('#new-password-error').text('New password cannot be the same as the old password.');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>

</html>