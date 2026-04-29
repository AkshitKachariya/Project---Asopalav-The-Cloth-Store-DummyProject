<?php

session_start();

include('./db_con.php');

$msg = "";

if (isset($_REQUEST['signin'])) {
    $email = $_REQUEST['user_email'];
    $password = $_REQUEST['user_password'];

    $check = mysqli_query($db, "select * from users where user_email='$email'");

    if (mysqli_num_rows($check)) {
        $result = mysqli_fetch_array($check);
        $user_password = password_verify($password, $result['user_password']);

        if ($user_password == 1) {
            $_SESSION['session'] = $email;
            header("Location:user_information.php");
        } else {
            $msg = "Invalid Password. <a href='forgot_password.php' class='underline text-[#c28e5c]'>Forgot Password?</a>";
        }
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
    <title>Login | Asopalav.in</title>
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

        #login_btn {
            transition: 0.2s;
            cursor: pointer;
            background-color: var(--main-color);
            border-color: var(--main-color);
        }

        #login_btn:hover {
            background-color: transparent;
            color: var(--main-color);
            border-color: var(--main-color);
        }

        .forgot a {
            color: var(--main-color);
        }

        .forgot a:hover {
            color: var(--hover-color);
        }

        .forgot a:active {
            color: #000000;
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
                Sign In
            </h2>
            <p class="text-gray-500 text-sm mb-10">
                Welcome back! Please log in to your account.
            </p>

            <form action="" method="post" id="loginForm">

                <div class="space-y-6 text-left text-gray-700">
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
                            <i class="fas fa-lock field-icon text-lg text-[#2e2e2e]"></i>
                            <input type="password" name="user_password" id="password" class="input" placeholder=" " />
                            <label for="password" class="label">Password</label>
                            <i class="fa-solid fa-eye-slash toggle-icon" onclick="togglePassword('password', this)"></i>
                        </div>
                        <div class="text-red-500 text-sm mt-1" id="password-error"></div>
                    </div>
                </div>

                <?php if (!empty($msg)): ?>
                    <div class="text-red-500 text-center text-base mt-6">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-6">
                    <input type="submit" id="login_btn" name="signin" value="Login"
                        class="w-full text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform text-sm cursor-pointer border-[#333333] border-2 hover:scale-101 ">
                </div>
            </form>

            <div class=" text-center font-medium text-sm mt-4">
                <a href="register.php" class="text-[var(--main-color)] hover:text-[var(--hover-color)]">
                    Don't have an account? <u class="text-[#c28e5c] hover:text-[#a5784a]">Sign Up</u>
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
            $('#loginForm').on('submit', function(e) {
                let isValid = true;

                $('.text-red-500').text('');

                const email = $('#email').val().trim();
                const password = $('#password').val().trim();

                if (email === '') {
                    $('#email-error').text('Email is required.');
                    isValid = false;
                }

                if (password === '') {
                    $('#password-error').text('Password is required.');
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