<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found | Delicious Cafe</title>
    
    <!-- Absolute paths for Live Server (starts with / ) -->
    <link rel="stylesheet" type="text/css" href="/asset/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="/style.css">
    <link rel="icon" type="image/png" href="/asset/image/Gemini_Generated_Image_y86qlny86qlny86q-removebg-preview.png">
    
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .error-container {
            text-align: center;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(242, 165, 70, 0.15);
            border: 1px solid rgba(242, 165, 70, 0.3);
            max-width: 600px;
            width: 90%;
            position: relative;
        }

        .error-code {
            font-family: 'Playfair Display', serif;
            font-size: 120px;
            font-weight: 800;
            color: #d4870a;
            line-height: 1;
            margin-bottom: 20px;
            text-shadow: 4px 4px 0px rgba(242, 165, 70, 0.2);
        }

        .error-icon {
            font-size: 80px;
            color: #ffc107;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        .error-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .error-message {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }

        .btn-home {
            background: linear-gradient(135deg, #a95103 0%, #5a2a02 100%);
            color: #ffffff;
            border: none;
            padding: 15px 35px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 30px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(169, 81, 3, 0.3);
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(169, 81, 3, 0.4);
            color: #ffffff;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        
        .bg-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(242, 165, 70, 0.1);
            animation: pulse 6s infinite alternate;
        }
        
        .shape-1 { width: 300px; height: 300px; top: -100px; left: -100px; }
        .shape-2 { width: 200px; height: 200px; bottom: -50px; right: -50px; animation-delay: 2s; }

        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }
    </style>
</head>
<body>

    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <div class="error-container">
        <div class="error-icon">
            <i class="fa-solid fa-mug-hot"></i>
        </div>
        <div class="error-code">404</div>
        <div class="error-title">Oops! Spilled Coffee?</div>
        <div class="error-message">
            We can't seem to find the page you're looking for. The link might be broken, or the page may have been removed.
        </div>
        <!-- Link redirects to root level -->
        <a href="/" class="btn-home">
            <i class="fa-solid fa-arrow-left"></i> Return to Homepage
        </a>
    </div>

</body>
</html>