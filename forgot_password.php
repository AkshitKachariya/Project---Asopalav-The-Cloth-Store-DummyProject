<?php

include('./db_con.php');

$msg = "";
$show_reset_form = false;
$user_email = "";

if (isset($_POST['reset_password'])) {
    $email = $_POST['user_email'];
    $password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $msg = "New passwords do not match.";
        $show_reset_form = true;
        $user_email = htmlspecialchars($email);
    } elseif (strlen($password) < 8) {
        $msg = "Password must be at least 8 characters long.";
        $show_reset_form = true;
        $user_email = htmlspecialchars($email);
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $update_query = "UPDATE users SET user_password = '$hashed_password' WHERE user_email = '$email'";
        $update = mysqli_query($db, $update_query);

        if ($update) {
            header("Location: login.php");
            exit();
        } else {
            $msg = "Password reset failed. Please try again.";
            $show_reset_form = true;
            $user_email = htmlspecialchars($email);
        }
    }
} elseif (isset($_POST['check_email'])) {
    $email = $_POST['user_email'];

    $check_query = "SELECT * FROM users WHERE user_email = '$email'";
    $check_user = mysqli_query($db, $check_query);

    if (mysqli_num_rows($check_user) > 0) {
        $show_reset_form = true;
        $user_email = htmlspecialchars($email);
    } else {
        $msg = "User Not Found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Asopalav.in</title>
    <script src="./jquery-3.7.1.min.js"></script>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
    <style>
        /* Your existing styles from login.php and register.php */
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

        #check_btn,
        #reset_btn {
            transition: 0.2s;
            cursor: pointer;
            background-color: var(--main-color);
        }

        #check_btn:hover,
        #reset_btn:hover {
            background-color: transparent;
            color: var(--main-color);
        }

        .reset {
            border: 2px solid #333333;
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
                Forgot Password?
            </h2>
            <p class="text-gray-500 text-sm mb-10">
                <?php if ($show_reset_form) : ?>
                    Enter your new password below.
                <?php else : ?>
                    Enter your email to reset your password.
                <?php endif; ?>
            </p>

            <?php if (!empty($msg)) : ?>
                <div class="text-red-500 text-center text-base mb-6">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <?php if ($show_reset_form) : ?>
                <form action="" method="post" id="resetPasswordForm">
                    <div class="space-y-6 text-left text-gray-700">
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
                    <input type="hidden" name="user_email" value="<?php echo $user_email; ?>">
                    <div class="mt-6">
                        <input type="submit" id="reset_btn" name="reset_password" value="Reset Password"
                            class="w-full text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-101 shadow-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 text-sm cursor-pointer reset">
                    </div>
                </form>
            <?php else : ?>
                <form action="" method="post" id="forgotPasswordForm">
                    <div class="space-y-6 text-left text-gray-700">
                        <div>
                            <div class="input-wrapper group">
                                <i class="fas fa-envelope field-icon text-lg text-[#2e2e2e]"></i>
                                <input type="email" name="user_email" id="email" class="input" placeholder=" " />
                                <label for="email" class="label">Email Address</label>
                            </div>
                            <div class="text-red-500 text-sm mt-1" id="email-error"></div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <input type="submit" id="check_btn" name="check_email" value="Check Email"
                            class="w-full text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform text-sm cursor-pointer border-[#333333] border-2">
                    </div>
                </form>
            <?php endif; ?>

            <div class=" text-center font-medium text-sm mt-4">
                <a href="login.php" class="text-[var(--main-color)] hover:text-[var(--hover-color)]">
                    <u class="text-[#c28e5c] hover:text-[#a5784a]">Back to Login</u>
                </a>
            </div>
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
            // Validation for the email submission form
            $('#forgotPasswordForm').on('submit', function(e) {
                let isValid = true;
                const email = $('#email').val().trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                $('.text-red-500').text('');

                if (email === '') {
                    $('#email-error').text('Email is required.');
                    isValid = false;
                } else if (!emailRegex.test(email)) {
                    $('#email-error').text('Please enter a valid email address.');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Validation for the new password form
            $('#resetPasswordForm').on('submit', function(e) {
                let isValid = true;

                $('.text-red-500').text('');

                const password = $('#new_password').val().trim();
                const confirmPassword = $('#confirm_password').val().trim();

                if (password === '') {
                    $('#new-password-error').text('Password is required.');
                    isValid = false;
                } else if (password.length < 8) {
                    $('#new-password-error').text('Password must be at least 8 characters long.');
                    isValid = false;
                }

                if (confirmPassword === '') {
                    $('#confirm-password-error').text('Confirm Password is required.');
                    isValid = false;
                } else if (password !== confirmPassword) {
                    $('#confirm-password-error').text('Passwords do not match.');
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