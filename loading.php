<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FundGuardian - Loading</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-gradient: linear-gradient(135deg, #0ea5e9 0%, #1d4ed8 100%);
            --secondary-gradient: linear-gradient(135deg, #1e3a8a 0%, #0b2a6f 100%);
            --success-gradient: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%);
            --bg-primary: #ffffff;
            --bg-secondary: #f3f6fb;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --border-color: #dbe3f3;
            --card-shadow: 0 10px 40px rgba(2, 6, 23, 0.08);
            --hover-shadow: 0 20px 60px rgba(2, 6, 23, 0.12);
            --accent: #0ea5e9;
        }

        [data-theme="dark"] {
            --bg-primary: #0b1220;
            --bg-secondary: #0a1020;
            --text-primary: #e6f0ff;
            --text-secondary: #cbd5e1;
            --border-color: #1e293b;
            --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            --hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            --accent: #38bdf8;
        }

        body {
            background: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            transition: background 0.3s ease, color 0.3s ease;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
            pointer-events: none;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-50px) scale(1.1);
            }
        }

        .loading-container {
            text-align: center;
            position: relative;
            z-index: 10;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-wrapper {
            margin-bottom: 3rem;
            animation: scaleIn 0.8s ease-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.5);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .logo-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            background: var(--primary-gradient);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 60px rgba(14, 165, 233, 0.4);
            animation: pulse 2s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 20px 60px rgba(14, 165, 233, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 25px 70px rgba(14, 165, 233, 0.6);
            }
        }

        .logo-icon i {
            font-size: 4rem;
            color: white;
            position: relative;
            z-index: 1;
        }

        .logo-text {
            font-size: 3rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }

        .tagline {
            font-size: 1.25rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 3rem;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .spinner-wrapper {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
        }

        .spinner {
            width: 80px;
            height: 80px;
            border: 4px solid rgba(14, 165, 233, 0.1);
            border-top-color: var(--accent);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
            animation: fadeIn 1s ease-out 0.7s both;
        }

        .progress-container {
            width: 300px;
            height: 6px;
            background: rgba(14, 165, 233, 0.1);
            border-radius: 999px;
            margin: 0 auto 1.5rem;
            overflow: hidden;
            animation: fadeIn 1s ease-out 0.9s both;
        }

        .progress-bar {
            height: 100%;
            background: var(--primary-gradient);
            border-radius: 999px;
            animation: progressAnimation 2s ease-in-out infinite;
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.5);
        }

        @keyframes progressAnimation {
            0% {
                width: 0%;
                transform: translateX(0);
            }
            50% {
                width: 70%;
            }
            100% {
                width: 100%;
                transform: translateX(0);
            }
        }

        .loading-status {
            font-size: 0.875rem;
            color: var(--text-secondary);
            animation: fadeIn 1s ease-out 1.1s both;
        }

        .dots {
            display: inline-block;
        }

        .dots span {
            animation: blink 1.4s infinite;
        }

        .dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes blink {
            0%, 80%, 100% { opacity: 0; }
            40% { opacity: 1; }
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 3rem;
            flex-wrap: wrap;
            animation: fadeIn 1s ease-out 1.3s both;
        }

        .feature-pill {
            padding: 0.5rem 1.25rem;
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.2);
            border-radius: 999px;
            color: var(--text-primary);
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .feature-pill i {
            color: var(--accent);
        }

        .feature-pill:hover {
            transform: translateY(-2px);
            background: rgba(14, 165, 233, 0.15);
            border-color: rgba(14, 165, 233, 0.3);
        }

        .theme-toggle {
            position: fixed;
            top: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.2);
            color: var(--text-primary);
            font-size: 1.25rem;
            cursor: pointer;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }

        .theme-toggle:hover {
            transform: rotate(180deg);
            background: rgba(14, 165, 233, 0.2);
        }

        @media (max-width: 576px) {
            .logo-text {
                font-size: 2rem;
            }
            .tagline {
                font-size: 1rem;
            }
            .progress-container {
                width: 250px;
            }
            .features {
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Theme Toggle -->
    <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- Main Loading Container -->
    <div class="loading-container">
        <div class="logo-wrapper">
            <div class="logo-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h1 class="logo-text">FundGuardian</h1>
            <p class="tagline">Smart Financial Management</p>
        </div>

        <div class="spinner-wrapper">
            <div class="spinner"></div>
        </div>

        <div class="loading-text">Preparing your dashboard</div>

        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>

        <div class="loading-status">
            Loading<span class="dots"><span>.</span><span>.</span><span>.</span></span>
        </div>

        <div class="features">
            <div class="feature-pill">
                <i class="fas fa-shield-check"></i>
                <span>Secure</span>
            </div>
            <div class="feature-pill">
                <i class="fas fa-bolt"></i>
                <span>Fast</span>
            </div>
            <div class="feature-pill">
                <i class="fas fa-sparkles"></i>
                <span>Intelligent</span>
            </div>
        </div>
    </div>

    <script>
        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', newTheme);
            document.getElementById('themeIcon').className = newTheme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
            localStorage.setItem('theme', newTheme);
        }

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        document.getElementById('themeIcon').className = savedTheme === 'light' ? 'fas fa-moon' : 'fas fa-sun';

        // Show loading and redirect
        window.addEventListener('load', () => {
            // Redirect to index.php (login page) after 3 seconds
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 3000);
        });

        // Show loading percentage
        let progress = 0;
        const statusText = document.querySelector('.loading-status');
        const loadingMessages = [
            'Initializing security protocols',
            'Loading dashboard components',
            'Preparing analytics engine',
            'Almost ready'
        ];
        let messageIndex = 0;

        const updateStatus = setInterval(() => {
            progress += 25;
            messageIndex = Math.min(messageIndex + 1, loadingMessages.length - 1);
            
            if (loadingMessages[messageIndex]) {
                const dots = '<span class="dots"><span>.</span><span>.</span><span>.</span></span>';
                statusText.innerHTML = loadingMessages[messageIndex] + dots;
            }
            
            if (progress >= 100) {
                clearInterval(updateStatus);
                statusText.innerHTML = 'Complete! Redirecting' + '<span class="dots"><span>.</span><span>.</span><span>.</span></span>';
            }
        }, 750);
    </script>
</body>
</html>