<?php

include('./db_con.php');

$msg = "";

if (isset($_REQUEST['signup'])) {

    $name = $_REQUEST['user_name'];
    $email = $_REQUEST['user_email'];
    $phone = $_REQUEST['user_phone'];
    $password = $_REQUEST['user_password'];
    $confirm_password = $_REQUEST['confirm_password'];

    // Server-side validation
    if ($password !== $confirm_password) {
        $msg = "Passwords do not match.";
    } else {
        $check_email = mysqli_query($db, "SELECT * FROM users WHERE user_email = '$email'");
        $check_phone = mysqli_query($db, "SELECT * FROM users WHERE user_phone = '$phone'");

        if (mysqli_num_rows($check_email) > 0) {
            $msg = "This email is already registered. Please use a different email.";
        } elseif (mysqli_num_rows($check_phone) > 0) {
            $msg = "This phone number is already registered. Please use a different phone number.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $insert = mysqli_query($db, "INSERT INTO users (user_name, user_email, user_phone, user_password) VALUES ('$name', '$email', '$phone', '$hashed_password')");

            if ($insert) {
                header('location: login.php');
            } else {
                $msg = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Asopalav.in</title>
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

        #signup_btn {
            transition: 0.2s;
            cursor: pointer;
            background-color: var(--main-color);
            border-color: var(--main-color);
        }

        #signup_btn:hover {
            background-color: transparent;
            color: var(--main-color);
            border-color: var(--main-color);
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
                Sign Up
            </h2>
            <p class="text-gray-500 text-sm mb-6">
                Create your account to get started.
            </p>

            <form action="" method="post" id="signupForm">
                <div class="space-y-6 text-left text-gray-700">

                    <div>
                        <div class="input-wrapper group">
                            <i class="fas fa-user field-icon text-lg text-[#2e2e2e]"></i>
                            <input type="text" name="user_name" id="username" class="input" placeholder=" " />
                            <label for="username" class="label">Username</label>
                        </div>
                        <div class="text-red-500 text-sm mt-1" id="username-error"></div>
                    </div>

                    <div>
                        <div class="input-wrapper group">
                            <i class="fas fa-envelope field-icon text-lg text-[#2e2e2e]"></i>
                            <input type="text" name="user_email" id="email" class="input" placeholder=" " />
                            <label for="email" class="label">Email Address</label>
                        </div>
                        <div class="text-red-500 text-sm mt-1" id="email-error"></div>
                    </div>

                    <div>
                        <div class="input-wrapper group">
                            <i class="fas fa-phone field-icon text-lg text-[#2e2e2e]"></i>
                            <input type="tel" name="user_phone" id="phone" class="input" placeholder=" " />
                            <label for="phone" class="label">Phone Number</label>
                        </div>
                        <div class="text-red-500 text-sm mt-1" id="phone-error"></div>
                    </div>

                    <div>
                        <div class="input-wrapper group">
                            <i class="fas fa-lock field-icon text-lg text-[#2e2e2e]"></i>
                            <input type="password" name="user_password" id="password" class="input" placeholder=" " />
                            <label for="password" class="label">Password</label>
                            <i class="fa-solid fa-eye-slash toggle-icon" onclick="togglePassword('password', this)"></i>
                        </div>
                        <div class="text-red-500 text-sm mt-1" id="password-error"></div>
                    </div>

                    <div>
                        <div class="input-wrapper group">
                            <i class="fas fa-lock field-icon text-lg text-[#2e2e2e]"></i>
                            <input type="password" name="confirm_password" id="confirm_password" class="input" placeholder=" " />
                            <label for="confirm_password" class="label">Confirm Password</label>
                            <i class="fa-solid fa-eye-slash toggle-icon" onclick="togglePassword('confirm_password', this)"></i>
                        </div>
                        <div class="text-red-500 text-sm mt-1" id="confirm-password-error"></div>
                    </div>
                </div>

                <?php if (!empty($msg)) : ?>
                    <div class="text-red-500 text-center text-base mt-6">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-6">
                    <input type="submit" id="signup_btn" name="signup" value="Create Account"
                        class="w-full text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform text-sm cursor-pointer border-[#333333] border-2 hover:scale-101 ">
                </div>
            </form>

            <div class="text-center font-medium text-sm mt-4">
                <a href="login.php" class="text-[var(--main-color)] hover:text-[var(--hover-color)]">
                    Already have an account? <u class="text-[#c28e5c] hover:text-[#a5784a]">Sign In</u>
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
            $('#signupForm').on('submit', function(e) {
                let isValid = true;

                $('.text-red-500').text('');

                const username = $('#username').val().trim();
                const email = $('#email').val().trim();
                const phone = $('#phone').val().trim();
                const password = $('#password').val().trim();
                const confirmPassword = $('#confirm_password').val().trim();

                const usernameRegex = /^[a-zA-Z\s]+$/;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const phoneRegex = /^[0-9]{10}$/;

                if (username === '') {
                    $('#username-error').text('Username is required.');
                    isValid = false;
                } else if (username.length < 2) {
                    $('#username-error').text('Username must be at least 2 characters long.');
                    isValid = false;
                } else if (!usernameRegex.test(username)) {
                    $('#username-error').text('Username can only contain letters and spaces.');
                    isValid = false;
                }

                if (email === '') {
                    $('#email-error').text('Email is required.');
                    isValid = false;
                } else if (!emailRegex.test(email)) {
                    $('#email-error').text('Please enter a valid email address.');
                    isValid = false;
                }

                if (phone === '') {
                    $('#phone-error').text('Phone number is required.');
                    isValid = false;
                } else if (!phoneRegex.test(phone)) {
                    $('#phone-error').text('Please enter a valid 10-digit phone number.');
                    isValid = false;
                }

                if (password === '') {
                    $('#password-error').text('Password is required.');
                    isValid = false;
                } else if (password.length < 8) {
                    $('#password-error').text('Password must be at least 8 characters long.');
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