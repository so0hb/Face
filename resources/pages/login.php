<?php

//handle user login logics 



$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $userType = $_POST['user_type'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if (empty($password)) {
        $errors['password'] = 'Password cannot be empty';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        exit();
    }
    if ($userType == "administrator") {
        $stmt = $pdo->prepare("SELECT * FROM tbladmin WHERE emailAddress = :email");
    } elseif ($userType == "lecture") {
        $stmt = $pdo->prepare("SELECT * FROM tbllecture WHERE emailAddress = :email");
    }
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();


    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = [
            'id' => $user['Id'],
            'email' => $user['emailAddress'],
            'name' => $user['firstName'],
            'role' => $userType,
        ];

        header('Location: home');
        exit();
    } else {
        $errors['login'] = 'Invalid email or password';
        $_SESSION['errors'] = $errors;
    }
}
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
}


function display_error($error, $is_main = false)
{
    global $errors;
    if (isset($errors["{$error}"])) {

        echo '<div class="' . ($is_main ? 'error-main' : 'error') . '">
                  <p>' . $errors["{$error}"] . '</p>
           </div>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>النظام الذكي - تسجيل الدخول</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="resources/assets/css/login_styles.css">
    <style>
        .logo-header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* تعديل حجم الصورة هنا */
        .logo-header img {
            height: 120px;
            /* زيادة من 80px إلى 120px */
            width: auto;
            /* للحفاظ على التناسب */
            max-width: 100%;
            /* للتأكد من عدم تجاوز الحجم */
            margin-bottom: 15px;
            object-fit: contain;
            /* للحفاظ على جودة الصورة */
        }

        .system-title {
            font-size: 30px;
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .system-subtitle {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    <div class="container" id="signIn">
        <!-- إضافة شعار النظام بحجم أكبر -->
        <div class="logo-header">
            <img src="/Face/resources/pages/logo.JPG" alt="شعار النظام الذكي">
            <div class="system-title">التحضير الذكي</div>
            <div class="system-subtitle">نظام إدارة الحضور والانصراف</div>
        </div>

        <!-- باقي الكود كما هو -->
        <?php display_error('login', true); ?>

        <form method="POST" action="">
            <div class="input-group">
                <i class="fas fa-user-tie"></i>
                <select name="user_type" id="" required>
                    <option value="">اختر نوع المستخدم</option>
                    <option value="lecture">دكتور</option>
                    <option value="administrator">مدير النظام</option>
                </select>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="البريد الإلكتروني" required>
                <?php display_error('email'); ?>
            </div>
            <div class="input-group password">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="كلمة المرور" required>
                <i id="eye" class="fa fa-eye"></i>
                <?php display_error('password'); ?>
            </div>
            <p class="recover">
                <a href="#">استعادة كلمة المرور</a>
            </p>
            <input type="submit" class="btn" value="تسجيل الدخول" name="login">
        </form>

        <p class="or">
            ---------- أو ----------
        </p>

        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
        </div>
    </div>

    <script src="resources/assets/javascript/script.js"></script>
</body>

</html>