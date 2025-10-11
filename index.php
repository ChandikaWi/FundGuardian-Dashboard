<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FundGuardian - Smart Financial Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
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
        }

        [data-theme="dark"] {
            --bg-primary: #0b1220; 
            --bg-secondary: #0a1020; 
            --text-primary: #e6f0ff; 
            --text-secondary: #cbd5e1; 
            --border-color: #1e293b;
            --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            --hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
        }

        body {
            background: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
            pointer-events: none;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .auth-container {
            display: flex;
            max-width: 1200px;
            width: 95%;
            margin: 20px;
            background: var(--bg-primary);
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .auth-left {
            flex: 1;
            padding: 60px;
            background: var(--primary-gradient);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .auth-left-content {
            position: relative;
            z-index: 1;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            animation: slideInLeft 0.6s ease-out;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            backdrop-filter: blur(10px);
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .auth-right {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
        }

        .theme-toggle:hover {
            transform: rotate(180deg);
            background: rgba(255, 255, 255, 0.3);
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 40px;
            color: var(--text-primary);
        }

        .logo i {
            margin-right: 12px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 40px;
            padding: 4px;
            background: var(--bg-secondary);
            border-radius: 12px;
        }

        .auth-tab {
            flex: 1;
            padding: 12px;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .auth-tab.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-primary);
            font-size: 14px;
        }

        .form-control {
            height: 54px;
            border-radius: 12px;
            border: 2px solid var(--border-color);
            padding: 0 20px;
            font-size: 15px;
            transition: all 0.3s;
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: var(--bg-primary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }
        [data-theme="dark"] .form-control::placeholder { color: #9fb3d1; opacity: 1; }
        [data-theme="dark"] .input-icon { color: var(--text-secondary); }
        [data-theme="dark"] .password-toggle { color: var(--text-secondary); }
        [data-theme="dark"] .text-muted { color: var(--text-secondary) !important; }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            z-index: 10;
        }

        .form-control.with-icon {
            padding-left: 50px;
        }

        .btn-primary {
            height: 54px;
            border-radius: 12px;
            background: var(--primary-gradient);
            border: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            cursor: pointer;
            z-index: 10;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 40px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            display: block;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 8px;
        }

        @media (max-width: 992px) {
            .auth-container {
                flex-direction: column;
            }
            .auth-left {
                padding: 40px;
            }
            .auth-right {
                padding: 40px;
            }
        }

        .loading {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-left">
            <button class="theme-toggle" onclick="toggleTheme()">
                <i class="fas fa-moon" id="themeIcon"></i>
            </button>
            <div class="auth-left-content">
                <h1 style="font-size: 42px; font-weight: 800; margin-bottom: 20px;">Welcome to FundGuardian</h1>
                <p style="font-size: 18px; opacity: 0.9; margin-bottom: 40px;">Take control of your finances with intelligent insights and beautiful visualizations.</p>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line fa-lg"></i>
                    </div>
                    <div>
                        <h5 style="margin: 0; font-weight: 700;">Advanced Analytics</h5>
                        <p style="margin: 0; opacity: 0.9;">Real-time charts and insights</p>
                    </div>
                </div>

                <div class="feature-item" style="animation-delay: 0.1s;">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt fa-lg"></i>
                    </div>
                    <div>
                        <h5 style="margin: 0; font-weight: 700;">Secure & Private</h5>
                        <p style="margin: 0; opacity: 0.9;">Your data is encrypted and safe</p>
                    </div>
                </div>

                <div class="feature-item" style="animation-delay: 0.2s;">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt fa-lg"></i>
                    </div>
                    <div>
                        <h5 style="margin: 0; font-weight: 700;">Multi-Device</h5>
                        <p style="margin: 0; opacity: 0.9;">Access anywhere, anytime</p>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">10+</span>
                        <span class="stat-label">Active Users</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">$1M+</span>
                        <span class="stat-label">Tracked</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">4.9★</span>
                        <span class="stat-label">Rating</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-right">
            <div class="logo">
                <i class="fas fa-wallet"></i>
                FundGuardian
            </div>

            <div class="auth-tabs">
                <button class="auth-tab active" onclick="switchTab('login', event)">Sign In</button>
                <button class="auth-tab" onclick="switchTab('register', event)">Sign Up</button>
            </div>

            <div id="alertContainer"></div>

            <!-- Login Form -->
            <div id="loginForm" class="auth-form">
                <form onsubmit="handleLogin(event)">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-control with-icon" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control with-icon" name="password" id="loginPassword" placeholder="Enter your password" required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword('loginPassword')"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <span class="btn-text">Sign In</span>
                        <div class="loading">
                            <div class="spinner"></div>
                        </div>
                    </button>
                </form>
            </div>

            <!-- Register Form -->
            <div id="registerForm" class="auth-form" style="display: none;">
                <form onsubmit="handleRegister(event)">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <div class="input-group">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-control with-icon" name="name" placeholder="Enter your full name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-control with-icon" name="email" placeholder="Enter your email" required autocomplete="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control with-icon" name="password" id="registerPassword" placeholder="Create a strong password" required minlength="6" autocomplete="new-password" oninput="updateStrength(event)">
                            <i class="fas fa-eye password-toggle" onclick="togglePassword('registerPassword')"></i>
                        </div>
                        <div class="mt-2" aria-live="polite">
                            <div id="strengthBar" style="height: 8px; border-radius: 6px; background: #e5e7eb; overflow: hidden;">
                                <div id="strengthFill" style="height: 100%; width: 0%; background: #ef4444; transition: width 0.3s ease, background 0.3s ease;"></div>
                            </div>
                            <small id="strengthLabel" class="text-muted">Password strength: -</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control with-icon" id="registerConfirm" placeholder="Re-enter your password" required autocomplete="new-password">
                            <i class="fas fa-eye password-toggle" onclick="togglePassword('registerConfirm')"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <span class="btn-text">Create Account</span>
                        <div class="loading">
                            <div class="spinner"></div>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        const savedTheme = localStorage.getItem('theme') || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', savedTheme);
        document.getElementById('themeIcon').className = savedTheme === 'light' ? 'fas fa-moon' : 'fas fa-sun';

        // Switch between tabs
        function switchTab(tab, evt) {
            const tabs = document.querySelectorAll('.auth-tab');
            tabs.forEach(t => t.classList.remove('active'));
            if (evt && evt.target) evt.target.classList.add('active');

            document.getElementById('loginForm').style.display = tab === 'login' ? 'block' : 'none';
            document.getElementById('registerForm').style.display = tab === 'register' ? 'block' : 'none';
        }

        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = event.target;
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Show alert
        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            alertContainer.innerHTML = `
                <div class="alert ${alertClass} alert-dismissible fade show">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    ${message}
                </div>
            `;
            setTimeout(() => alertContainer.innerHTML = '', 5000);
        }

        // Handle login
        async function handleLogin(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            const btnText = btn.querySelector('.btn-text');
            const loading = btn.querySelector('.loading');
            
            btnText.style.opacity = '0';
            loading.style.display = 'block';
            
            const formData = new FormData(e.target);
            
            try {
                const response = await fetch('auth.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'login',
                        ...Object.fromEntries(formData)
                    })
                });
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Login successful! Redirecting...', 'success');
                    setTimeout(() => window.location.href = 'dashboard.php', 1000);
                } else {
                    showAlert(data.message, 'error');
                    btnText.style.opacity = '1';
                    loading.style.display = 'none';
                }
            } catch (error) {
                showAlert('Login failed. Please try again.', 'error');
                btnText.style.opacity = '1';
                loading.style.display = 'none';
            }
        }

        // Password strength
        function updateStrength(e) {
            const pwd = e.target.value || '';
            const score = computeStrength(pwd);
            const percent = Math.min(100, score * 25);
            const fill = document.getElementById('strengthFill');
            const label = document.getElementById('strengthLabel');
            fill.style.width = percent + '%';
            let color = '#ef4444', text = 'Weak';
            if (score >= 3) { color = '#f59e0b'; text = 'Medium'; }
            if (score >= 4) { color = '#10b981'; text = 'Strong'; }
            fill.style.background = color;
            label.textContent = 'Password strength: ' + (pwd ? text : '-');
        }

        function computeStrength(pwd) {
            let s = 0;
            if (pwd.length >= 6) s++;
            if (/[A-Z]/.test(pwd)) s++;
            if (/[0-9]/.test(pwd)) s++;
            if (/[^A-Za-z0-9]/.test(pwd)) s++;
            return s;
        }

        // Handle register
        async function handleRegister(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            const btnText = btn.querySelector('.btn-text');
            const loading = btn.querySelector('.loading');
            
            btnText.style.opacity = '0';
            loading.style.display = 'block';
            
            const formData = new FormData(e.target);
            const confirm = document.getElementById('registerConfirm').value;
            const pwd = formData.get('password') || '';
            if (pwd !== confirm) {
                showAlert('Passwords do not match.', 'error');
                btnText.style.opacity = '1';
                loading.style.display = 'none';
                return;
            }
            
            try {
                const response = await fetch('auth.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'register',
                        ...Object.fromEntries(formData)
                    })
                });
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Registration successful! Please sign in.', 'success');
                    e.target.reset();
                    setTimeout(() => {
                        document.querySelectorAll('.auth-tab')[0].click();
                    }, 1500);
                } else {
                    showAlert(data.message, 'error');
                }
                btnText.style.opacity = '1';
                loading.style.display = 'none';
            } catch (error) {
                showAlert('Registration failed. Please try again.', 'error');
                btnText.style.opacity = '1';
                loading.style.display = 'none';
            }
        }
    </script>
</body>
</html>