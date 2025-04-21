<?php
session_start();
$redirect_url = 'index.php?request_site=login'; // التوجيه دائمًا لصفحة login أولاً
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التطوير الذكي - نظام الحضور الذكي</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            color: white;
        }

        .splash-container {
            text-align: center;
            position: relative;
        }

        .logo {
            width: 180px;
            height: 180px;
            margin: 0 auto;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: zoomIn 1s ease-out, float 3s ease-in-out infinite;
            padding: 10px;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            animation: spin 4s linear infinite, pulse 2s infinite alternate;
        }

        h1 {
            margin-top: 20px;
            font-size: 2.5rem;
            animation: fadeIn 1.5s ease-out;
        }

        .progress-container {
            width: 300px;
            height: 8px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            margin: 30px auto;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            background-color: white;
            animation: progress 3s ease-in-out forwards;
            border-radius: 4px;
        }

        .loading-text {
            margin-top: 15px;
            font-size: 1rem;
            opacity: 0.8;
            animation: fadeIn 2s ease-out;
        }

        .version {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* Animations */
        @keyframes zoomIn {
            from {
                transform: scale(0.5);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes pulse {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.05);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes progress {
            0% {
                width: 0;
            }

            100% {
                width: 100%;
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="splash-container">
        <div class="logo">
            <img src="/Face/resources/pages/logo.JPG" alt="شعار التطوير الذكي">
        </div>
        <h1>التحضير الذكي</h1>
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
        <div class="loading-text">جاري تحميل النظام...</div>
        <div class="version">الإصدار 1.0</div>
    </div>

    <script>
        const messages = [
            "جاري تهيئة النظام...",
            "جاري تحميل البيانات...",
            "جاري التحقق من الصلاحيات...",
            "جاري إعداد الواجهة..."
        ];

        const loadingText = document.querySelector('.loading-text');
        let counter = 0;

        const changeMessage = () => {
            loadingText.textContent = messages[counter % messages.length];
            counter++;
        };

        setInterval(changeMessage, 2000);


        setTimeout(function() {
            window.location.href = "<?php echo $redirect_url; ?>";
        }, 9000);

        // تخطي الشاشة بالنقر
        document.addEventListener('click', function() {
            window.location.href = "<?php echo $redirect_url; ?>";
        });
    </script>
</body>

</html>