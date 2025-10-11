<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FundGuardian Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary-gradient: linear-gradient(135deg, #0ea5e9 0%, #1d4ed8 100%);
            --secondary-gradient: linear-gradient(135deg, #1e3a8a 0%, #0b2a6f 100%);
            --success-gradient: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%);
            --bg-primary: #ffffff;
            --bg-secondary: #f3f6fb;
            --bg-tertiary: #f3f6fb;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border-color: #dbe3f3;
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.08);
            --shadow-md: 0 4px 12px rgba(15, 23, 42, 0.1);
            --shadow-lg: 0 10px 40px rgba(2, 6, 23, 0.08);
            --shadow-xl: 0 20px 60px rgba(2, 6, 23, 0.12);
            --accent: #0ea5e9;
            --accent-blue: #0ea5e9;
            --accent-cyan: #06b6d4;
        }

        [data-theme="dark"] {
            --bg-primary: #0b1220;
            --bg-secondary: #0a1020;
            --bg-tertiary: #0a1020;
            --text-primary: #e6f0ff;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-color: #1e293b;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.4);
            --shadow-xl: 0 20px 60px rgba(0, 0, 0, 0.6);
            --accent: #38bdf8;
            --accent-blue: #38bdf8;
            --accent-cyan: #60a5fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-secondary);
            color: var(--text-primary);
            transition: background 0.3s ease, color 0.3s ease;
        }

        .navbar {
            background: var(--primary-gradient);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-lg);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .stat-card {
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-lg);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }

        .stat-card.income {
            background: var(--success-gradient);
        }

        .stat-card.expense {
            background: var(--secondary-gradient);
        }

        .stat-card.balance {
            background: var(--primary-gradient);
        }

        .stat-card .icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            margin-bottom: 1rem;
        }

        .stat-card .icon-wrapper i {
            font-size: 1.8rem;
        }

        .stat-card h6 {
            font-weight: 600;
            opacity: 1;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.95);
        }

        .stat-card h2 {
            font-weight: 800;
            font-size: 2.25rem;
            margin-top: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #ffffff;
        }

        .stat-card .trend {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.95);
        }

        .chart-container {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .chart-container:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .chart-container h5 {
            font-weight: 700;
            font-size: 1.125rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-primary);
        }

        .chart-container h5 i {
            color: var(--accent);
        }

        .chart-container h6 {
            color: var(--text-primary);
            font-weight: 600;
        }

        [data-theme="dark"] .chart-container h5,
        [data-theme="dark"] .chart-container h6 {
            color: var(--text-primary);
        }

        .transaction-item {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            color: var(--text-primary);
        }

        .transaction-item:hover {
            transform: translateX(4px);
            box-shadow: var(--shadow-md);
            border-color: var(--accent);
        }

        .transaction-item strong {
            color: var(--text-primary);
        }

        .transaction-item small {
            color: var(--text-secondary);
        }

        .transaction-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-right: 1rem;
        }

        .transaction-icon.income {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .transaction-icon.expense {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .income-badge, .expense-badge {
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.875rem;
            box-shadow: var(--shadow-sm);
        }

        .income-badge {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .expense-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-glow {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.4);
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(14, 165, 233, 0.5);
            filter: brightness(1.1);
        }

        .btn-outline-custom {
            border: 2px solid var(--accent);
            color: var(--accent);
            background: transparent;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: var(--accent);
            color: white;
            transform: translateY(-2px);
        }

        .sidebar-nav {
            position: sticky;
            top: 1rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
            border-radius: 12px;
            overflow: hidden;
        }

        .nav-link-custom {
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            border-radius: 12px;
        }

        .nav-link-custom:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateX(4px);
        }

        .nav-link-custom i {
            width: 24px;
            text-align: center;
        }

        [data-theme="dark"] .nav-link-custom {
            color: var(--text-primary);
        }

        [data-theme="dark"] .nav-link-custom:hover {
            color: white;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid var(--border-color);
            padding: 0.75rem 1rem;
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
        }

        [data-theme="dark"] .form-control::placeholder {
            color: var(--text-muted);
            opacity: 1;
        }

        .input-group-text {
            background: var(--bg-primary);
            border: 2px solid var(--border-color);
            color: var(--text-secondary);
            border-radius: 12px 0 0 12px;
        }

        [data-theme="dark"] .input-group-text {
            background: var(--bg-secondary);
            color: var(--text-secondary);
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .quick-stat-item {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.25rem;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .quick-stat-item:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .quick-stat-item i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .quick-stat-item h4 {
            color: var(--text-primary);
            font-weight: 700;
            margin: 0.5rem 0;
        }

        .quick-stat-item p {
            color: var(--text-secondary);
            margin: 0;
        }

        .budget-item {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .budget-item:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .budget-progress {
            flex: 1;
            margin: 0 1rem;
        }

        .budget-progress .progress-custom {
            height: 8px;
            margin-top: 0.5rem;
        }

        .budget-status {
            font-size: 0.875rem;
            font-weight: 600;
        }

        .budget-status.under {
            color: var(--success-gradient);
            background: linear-gradient(135deg, #10b981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .budget-status.over {
            color: #ef4444;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-slide-up {
            animation: slideInUp 0.6s ease-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-tertiary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        .progress-custom {
            height: 12px;
            border-radius: 999px;
            background: var(--bg-tertiary);
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .progress-bar-custom {
            height: 100%;
            background: var(--primary-gradient);
            border-radius: 999px;
            transition: width 0.6s ease;
        }

        .skeleton {
            background: linear-gradient(90deg, var(--bg-tertiary) 25%, var(--bg-primary) 50%, var(--bg-tertiary) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        [data-theme="dark"] .text-muted {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] small {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] p {
            color: var(--text-primary);
        }

        [data-theme="dark"] .modal-content {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        [data-theme="dark"] .modal-body {
            color: var(--text-primary);
        }

        [data-theme="dark"] .btn-outline-custom {
            color: var(--accent);
            border-color: var(--accent);
        }

        [data-theme="dark"] .btn-outline-custom:hover {
            background: var(--accent);
            color: white;
        }
        @media (max-width: 768px) {
            .stat-card h2 {
                font-size: 1.75rem;
            }
            
            .chart-container {
                padding: 1rem;
            }
        }

        .theme-toggle-btn {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(180deg);
        }

        @media print {
            body * {
                visibility: hidden;
            }
            .col-lg-10, .col-lg-10 * {
                visibility: visible;
            }
            .col-lg-10 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .navbar, .sidebar-nav, .modal, button:not(.btn-glow):not(.btn-outline-custom), input, select, .d-none {
                display: none !important;
            }
            .stat-card, .chart-container {
                box-shadow: none !important;
                border: 1px solid #000 !important;
                page-break-inside: avoid;
                background: white !important;
                color: black !important;
                border-radius: 0 !important;
            }
            .stat-card {
                background: #f0f0f0 !important;
                color: black !important;
            }
            .stat-card h2, .stat-card h6 {
                color: black !important;
            }
            .transaction-item {
                box-shadow: none !important;
                border: 1px solid #000 !important;
                background: white !important;
                color: black !important;
            }
            canvas {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            body {
                background: white !important;
                color: black !important;
                font-size: 12pt;
            }
            .row {
                margin: 0 !important;
            }
            .col-md-4, .col-md-8, .col-md-6, .col-md-12 {
                padding: 0 5px !important;
                margin-bottom: 10px !important;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                <i class="fas fa-chart-line"></i> FundGuardian
            </span>
            <div class="d-flex align-items-center gap-3 text-white">
                <span class="d-none d-md-inline">Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></span>
                <button class="theme-toggle-btn" id="themeToggle" title="Toggle theme">
                    <i class="fas fa-moon"></i>
                </button>
                <button class="btn btn-outline-light btn-sm" onclick="logout()">
                    <i class="fas fa-sign-out-alt"></i> <span class="d-none d-md-inline">Logout</span>
                </button>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4 px-4">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-2 d-none d-lg-block">
                <div class="sidebar-nav">
                    <div class="chart-container animate-fade-in">
                        <h6 class="mb-3"><i class="fas fa-compass me-2"></i>Navigation</h6>
                        <div class="nav-item">
                            <a href="#" class="nav-link-custom" id="navOverview">
                                <i class="fas fa-home"></i>
                                <span>Overview</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="#" class="nav-link-custom" id="navTransactions">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Transactions</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="#" class="nav-link-custom" id="navBudgets">
                                <i class="fas fa-piggy-bank"></i>
                                <span>Budgets</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="#" class="nav-link-custom" id="navReports">
                                <i class="fas fa-chart-bar"></i>
                                <span>Reports</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a href="#" class="nav-link-custom" id="navSettings">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="chart-container mt-3 animate-fade-in" style="animation-delay: 0.1s;">
                        <h6 class="mb-3"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-glow" id="quickIncome">
                                <i class="fas fa-plus-circle me-2"></i>Add Income
                            </button>
                            <button class="btn-outline-custom btn" id="quickExpense">
                                <i class="fas fa-minus-circle me-2"></i>Add Expense
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10">
                <!-- Toolbar -->
                <div class="chart-container animate-slide-up">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="searchInput" class="form-control" placeholder="Search transactions...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="filterType" class="form-select">
                                <option value="">All Types</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filterCategory" class="form-select">
                                <option value="">All Categories</option>
                                <option value="Salary">Salary</option>
                                <option value="Food">Food</option>
                                <option value="Transport">Transport</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Shopping">Shopping</option>
                                <option value="Bills">Bills</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-custom w-100" id="exportCsv">
                                <i class="fas fa-download me-2"></i>Export
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-card income animate-slide-up" style="animation-delay: 0.1s;">
                            <div class="icon-wrapper">
                                <i class="fas fa-arrow-trend-up"></i>
                            </div>
                            <h6>Total Income</h6>
                            <h2 id="totalIncome">Rs. 0.00</h2>
                            <div class="trend">
                                <i class="fas fa-arrow-up"></i>
                                <span>This month</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card expense animate-slide-up" style="animation-delay: 0.2s;">
                            <div class="icon-wrapper">
                                <i class="fas fa-arrow-trend-down"></i>
                            </div>
                            <h6>Total Expenses</h6>
                            <h2 id="totalExpense">Rs. 0.00</h2>
                            <div class="trend">
                                <i class="fas fa-arrow-down"></i>
                                <span>This month</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card balance animate-slide-up" style="animation-delay: 0.3s;">
                            <div class="icon-wrapper">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <h6>Current Balance</h6>
                            <h2 id="balance">Rs. 0.00</h2>
                            <div class="trend">
                                <i class="fas fa-equals"></i>
                                <span>Net balance</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Add Transaction Form -->
                    <div class="col-md-4">
                        <div class="chart-container animate-slide-up" id="addTransactionCard" style="animation-delay: 0.4s;">
                            <h5><i class="fas fa-plus-circle"></i> New Transaction</h5>
                            <form id="transactionForm">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description" placeholder="Enter description" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Amount (Rs.)</label>
                                    <input type="number" class="form-control" name="amount" step="0.01" placeholder="0.00" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Type</label>
                                    <select class="form-select" name="type" required>
                                        <option value="income">Income</option>
                                        <option value="expense">Expense</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select class="form-select" name="category" required>
                                        <option value="Salary">Salary</option>
                                        <option value="Food">Food</option>
                                        <option value="Transport">Transport</option>
                                        <option value="Entertainment">Entertainment</option>
                                        <option value="Shopping">Shopping</option>
                                        <option value="Bills">Bills</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-glow w-100">
                                    <i class="fas fa-check me-2"></i>Add Transaction
                                </button>
                            </form>
                        </div>

                        <!-- Recent Transactions -->
                        <div class="chart-container animate-slide-up" style="animation-delay: 0.5s;">
                            <h5><i class="fas fa-history"></i> Recent Activity</h5>
                            <div id="transactionsList" style="max-height: 450px; overflow-y: auto;"></div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart-container animate-slide-up" style="animation-delay: 0.6s;">
                                    <h5><i class="fas fa-chart-pie"></i> Income vs Expenses</h5>
                                    <canvas id="pieChart"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container animate-slide-up" style="animation-delay: 0.7s;">
                                    <h5><i class="fas fa-chart-donut"></i> Category Breakdown</h5>
                                    <canvas id="doughnutChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart-container animate-slide-up" style="animation-delay: 0.8s;">
                                    <h5><i class="fas fa-chart-line"></i> Monthly Trend</h5>
                                    <canvas id="lineChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart-container animate-slide-up" style="animation-delay: 0.9s;">
                                    <h5><i class="fas fa-chart-bar"></i> Expense Comparison</h5>
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart-container animate-slide-up" style="animation-delay: 1s;">
                                    <h5><i class="fas fa-radar"></i> Spending Profile</h5>
                                    <canvas id="radarChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="miniModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: var(--shadow-xl);">
                <div class="modal-header" style="background: var(--primary-gradient); color: white; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h6 class="modal-title" id="miniModalTitle"></h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="miniModalBody"></div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let transactions = [];
let filtered = [];
let budgets = JSON.parse(localStorage.getItem('budgets')) || [];
let pieChart, doughnutChart, lineChart, barChart, radarChart;

// Initialize dashboard
document.addEventListener('DOMContentLoaded', () => {
    loadTransactions();
    initCharts();
    wireDashboardUI();
    initAnimations();
});

// Handle transaction form submission
document.getElementById('transactionForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    // Add loading state
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('api.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'add_transaction',
                ...Object.fromEntries(formData)
            })
        });
        const data = await response.json();
        
        if (data.success) {
            e.target.reset();
            loadTransactions();
            showNotification('Transaction added successfully!', 'success');
        } else {
            showNotification(data.message || 'Failed to add transaction', 'error');
        }
    } catch (error) {
        showNotification('Failed to add transaction', 'error');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

// Load transactions from API
async function loadTransactions() {
    try {
        const response = await fetch('api.php?action=get_transactions');
        const data = await response.json();
        
        if (data.success) {
            transactions = data.transactions;
            filtered = [...transactions];
            updateStats();
            updateCharts();
            displayTransactions();
        }
    } catch (error) {
        console.error('Failed to load transactions');
        showNotification('Failed to load transactions', 'error');
    }
}

// Update statistics with animations
function updateStats() {
    const income = filtered
        .filter(t => t.type === 'income')
        .reduce((sum, t) => sum + parseFloat(t.amount), 0);
    
    const expense = filtered
        .filter(t => t.type === 'expense')
        .reduce((sum, t) => sum + parseFloat(t.amount), 0);
    
    const balance = income - expense;
    
    animateValue('totalIncome', 0, income, 1000, 'Rs. ');
    animateValue('totalExpense', 0, expense, 1000, 'Rs. ');
    animateValue('balance', 0, balance, 1000, 'Rs. ');
}

// Animate number counting
function animateValue(id, start, end, duration, prefix = '') {
    const element = document.getElementById(id);
    if (!element) return;
    
    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;
    
    const timer = setInterval(() => {
        current += increment;
        if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
            current = end;
            clearInterval(timer);
        }
        element.textContent = prefix + current.toFixed(2);
    }, 16);
}

// Display transactions list
function displayTransactions() {
    const list = document.getElementById('transactionsList');
    const recent = filtered.slice(-10).reverse();
    
    if (recent.length === 0) {
        list.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                <p>No transactions yet</p>
            </div>
        `;
        return;
    }
    
    list.innerHTML = recent.map((t, index) => `
        <div class="transaction-item" style="animation-delay: ${index * 0.05}s;">
            <div class="d-flex align-items-center flex-grow-1">
                <div class="transaction-icon ${t.type}">
                    <i class="fas fa-${t.type === 'income' ? 'arrow-up' : 'arrow-down'}"></i>
                </div>
                <div>
                    <strong style="color: var(--text-primary);">${t.description}</strong>
                    <br>
                    <small class="text-muted">
                        <i class="fas fa-tag me-1"></i>${t.category} • 
                        <i class="fas fa-calendar me-1"></i>${formatDate(t.date)}
                    </small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="${t.type}-badge">
                    ${t.type === 'income' ? '+' : '-'}Rs.${parseFloat(t.amount).toFixed(2)}
                </span>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteTransaction(${t.id})" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `).join('');
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { month: 'short', day: 'numeric', year: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

// Delete transaction with confirmation
async function deleteTransaction(id) {
    if (!confirm('Are you sure you want to delete this transaction?')) return;
    
    try {
        const response = await fetch('api.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'delete_transaction',
                id: id
            })
        });
        const data = await response.json();
        
        if (data.success) {
            loadTransactions();
            showNotification('Transaction deleted successfully', 'success');
        } else {
            showNotification(data.message || 'Failed to delete transaction', 'error');
        }
    } catch (error) {
        showNotification('Failed to delete transaction', 'error');
    }
}

// Budget Management Functions
function getSpentForCategory(category) {
    return filtered
        .filter(t => t.type === 'expense' && t.category === category)
        .reduce((sum, t) => sum + parseFloat(t.amount), 0);
}

function getBudgetForCategory(category) {
    return budgets.find(b => b.category === category);
}

function calculateBudgetProgress(budget) {
    const spent = getSpentForCategory(budget.category);
    const progress = (spent / budget.limit) * 100;
    const status = progress < 100 ? 'under' : 'over';
    return { spent, progress, status };
}

function renderBudgetItem(budget) {
    const { spent, progress, status } = calculateBudgetProgress(budget);
    const overUnder = status === 'under' ? '+' : '';
    return `
        <div class="budget-item" data-category="${budget.category}">
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>${budget.category}</strong>
                        <br>
                        <small class="text-muted">Spent: Rs. ${spent.toFixed(2)} / ${budget.limit.toFixed(2)}</small>
                    </div>
                    <div class="budget-status ${status}">${status === 'under' ? 'Under Budget' : 'Over Budget'}</div>
                </div>
                <div class="budget-progress">
                    <div class="progress-custom">
                        <div class="progress-bar-custom" style="width: ${Math.min(progress, 100)}%;"></div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary" onclick="editBudget('${budget.category}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteBudget('${budget.category}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
}

function renderBudgetsList() {
    if (budgets.length === 0) {
        return `
            <div class="text-center py-4">
                <i class="fas fa-piggy-bank fa-3x mb-3" style="color: var(--accent); opacity: 0.3;"></i>
                <p class="text-muted">No budgets set yet</p>
                <p class="text-muted small">Add a budget to start tracking your spending limits</p>
            </div>
        `;
    }
    return budgets.map(b => renderBudgetItem(b)).join('');
}

function renderBudgetForm(editCategory = null) {
    const isEdit = !!editCategory;
    const budget = isEdit ? budgets.find(b => b.category === editCategory) : null;
    const title = isEdit ? 'Edit Budget' : 'Add New Budget';
    const categoryOptions = ['Salary', 'Food', 'Transport', 'Entertainment', 'Shopping', 'Bills', 'Other']
        .map(cat => `<option value="${cat}" ${budget && budget.category === cat ? 'selected' : ''}>${cat}</option>`)
        .join('');
    const limitValue = budget ? budget.limit : '';
    return `
        <div class="budget-form">
            <h6>${title}</h6>
            <form id="budgetForm">
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category" required ${isEdit ? 'disabled' : ''}>
                        ${categoryOptions}
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Monthly Limit (Rs.)</label>
                    <input type="number" step="0.01" class="form-control" name="limit" value="${limitValue}" placeholder="0.00" required min="0">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-glow">
                        <i class="fas fa-check me-2"></i>${isEdit ? 'Update Budget' : 'Set Budget'}
                    </button>
                    ${isEdit ? `<button type="button" class="btn btn-outline-secondary" onclick="cancelBudgetEdit()">Cancel</button>` : ''}
                </div>
                ${isEdit ? `<input type="hidden" name="editCategory" value="${editCategory}">` : ''}
            </form>
        </div>
    `;
}

function handleBudgetFormSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const category = formData.get('category');
    const limit = parseFloat(formData.get('limit'));
    const editCategory = formData.get('editCategory');

    if (editCategory) {
        // Edit existing
        const index = budgets.findIndex(b => b.category === editCategory);
        if (index !== -1) {
            budgets[index].limit = limit;
        }
    } else {
        // Add new
        if (budgets.find(b => b.category === category)) {
            showNotification('Budget for this category already exists!', 'warning');
            return;
        }
        budgets.push({ category, limit });
    }

    saveBudgets();
    const modalBody = document.getElementById('miniModalBody');
    modalBody.innerHTML = renderBudgetForm() + '<hr>' + renderBudgetsList();
    bindBudgetForm();
    showNotification(`${editCategory ? 'Updated' : 'Added'} budget successfully!`, 'success');
}

function bindBudgetForm() {
    const form = document.getElementById('budgetForm');
    if (form) {
        form.removeEventListener('submit', handleBudgetFormSubmit); // Prevent duplicates
        form.addEventListener('submit', handleBudgetFormSubmit);
    }
}

function addBudget() {
    const modalBody = document.getElementById('miniModalBody');
    modalBody.innerHTML = renderBudgetForm();
    bindBudgetForm();
}

function editBudget(category) {
    const modalBody = document.getElementById('miniModalBody');
    modalBody.innerHTML = renderBudgetForm(category);
    bindBudgetForm();
}

function deleteBudget(category) {
    if (!confirm(`Delete budget for ${category}?`)) return;
    budgets = budgets.filter(b => b.category !== category);
    saveBudgets();
    const modalBody = document.getElementById('miniModalBody');
    modalBody.innerHTML = renderBudgetForm() + '<hr>' + renderBudgetsList();
    showNotification('Budget deleted successfully!', 'success');
}

function cancelBudgetEdit() {
    const modalBody = document.getElementById('miniModalBody');
    modalBody.innerHTML = renderBudgetForm() + '<hr>' + renderBudgetsList();
    bindBudgetForm();
}

function saveBudgets() {
    localStorage.setItem('budgets', JSON.stringify(budgets));
}
// Initialize Charts
function initCharts() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textColor = isDark ? '#cbd5e1' : '#475569';
    const gridColor = isDark ? '#1e293b' : '#dbe3f3';
    
    const chartDefaults = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                labels: { color: textColor, font: { size: 12, weight: '600' } }
            }
        }
    };

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Income', 'Expenses'],
            datasets: [{
                data: [0, 0],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            ...chartDefaults,
            plugins: {
                ...chartDefaults.plugins,
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': Rs.' + context.parsed.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // Doughnut Chart
    const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
    doughnutChart = new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgba(14, 165, 233, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(96, 165, 250, 0.8)',
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(6, 182, 212, 0.8)',
                    'rgba(168, 85, 247, 0.8)'
                ],
                borderWidth: 2,
                borderColor: isDark ? '#0b1220' : '#ffffff'
            }]
        },
        options: {
            ...chartDefaults,
            cutout: '65%',
            plugins: {
                ...chartDefaults.plugins,
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': Rs.' + context.parsed.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // Line Chart
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Income',
                data: [],
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgba(16, 185, 129, 1)'
            }, {
                label: 'Expenses',
                data: [],
                borderColor: 'rgba(239, 68, 68, 1)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgba(239, 68, 68, 1)'
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { 
                        color: textColor,
                        callback: function(value) {
                            return 'Rs.' + value;
                        }
                    }
                },
                x: {
                    grid: { color: gridColor },
                    ticks: { color: textColor }
                }
            }
        }
    });

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Expenses by Category',
                data: [],
                backgroundColor: 'rgba(14, 165, 233, 0.8)',
                borderColor: 'rgba(14, 165, 233, 1)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { 
                        color: textColor,
                        callback: function(value) {
                            return 'Rs.' + value;
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: textColor }
                }
            }
        }
    });

    // Radar Chart
    const radarCtx = document.getElementById('radarChart')?.getContext('2d');
    if (radarCtx) {
        radarChart = new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: ['Food', 'Transport', 'Entertainment', 'Shopping', 'Bills', 'Other'],
                datasets: [{
                    label: 'Spending Profile',
                    data: [0, 0, 0, 0, 0, 0],
                    borderColor: 'rgba(14, 165, 233, 1)',
                    backgroundColor: 'rgba(14, 165, 233, 0.2)',
                    borderWidth: 2,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgba(14, 165, 233, 1)'
                }]
            },
            options: {
                ...chartDefaults,
                scales: {
                    r: {
                        angleLines: { color: gridColor },
                        grid: { color: gridColor },
                        pointLabels: { color: textColor, font: { size: 12 } },
                        ticks: { 
                            color: textColor,
                            backdropColor: 'transparent',
                            callback: function(value) {
                                return 'Rs.' + value;
                            }
                        }
                    }
                }
            }
        });
    }
}

// Update all charts
function updateCharts() {
    updatePieChart();
    updateDoughnutChart();
    updateLineChart();
    updateBarChart();
    updateRadarChart();
}

function updatePieChart() {
    const income = filtered
        .filter(t => t.type === 'income')
        .reduce((sum, t) => sum + parseFloat(t.amount), 0);
    
    const expense = filtered
        .filter(t => t.type === 'expense')
        .reduce((sum, t) => sum + parseFloat(t.amount), 0);
    
    pieChart.data.datasets[0].data = [income, expense];
    pieChart.update('active');
}

function updateDoughnutChart() {
    const categoryData = {};
    
    filtered
        .filter(t => t.type === 'expense')
        .forEach(t => {
            categoryData[t.category] = (categoryData[t.category] || 0) + parseFloat(t.amount);
        });
    
    doughnutChart.data.labels = Object.keys(categoryData);
    doughnutChart.data.datasets[0].data = Object.values(categoryData);
    doughnutChart.update('active');
}

function updateLineChart() {
    const monthlyData = {};
    
    filtered.forEach(t => {
        const month = t.date.substring(0, 7);
        if (!monthlyData[month]) {
            monthlyData[month] = { income: 0, expense: 0 };
        }
        monthlyData[month][t.type] += parseFloat(t.amount);
    });
    
    const months = Object.keys(monthlyData).sort().slice(-6);
    const incomeData = months.map(m => monthlyData[m].income);
    const expenseData = months.map(m => monthlyData[m].expense);
    
    lineChart.data.labels = months;
    lineChart.data.datasets[0].data = incomeData;
    lineChart.data.datasets[1].data = expenseData;
    lineChart.update('active');
}

function updateBarChart() {
    const categoryData = {};
    
    filtered
        .filter(t => t.type === 'expense')
        .forEach(t => {
            categoryData[t.category] = (categoryData[t.category] || 0) + parseFloat(t.amount);
        });
    
    barChart.data.labels = Object.keys(categoryData);
    barChart.data.datasets[0].data = Object.values(categoryData);
    barChart.update('active');
}

function updateRadarChart() {
    if (!radarChart) return;
    const categories = ['Food', 'Transport', 'Entertainment', 'Shopping', 'Bills', 'Other'];
    const totals = categories.map(cat => filtered
        .filter(t => t.type === 'expense' && t.category === cat)
        .reduce((sum, t) => sum + parseFloat(t.amount || 0), 0));
    radarChart.data.labels = categories;
    radarChart.data.datasets[0].data = totals;
    radarChart.update('active');
}

window.applyThemeToCharts = function() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textColor = isDark ? '#cbd5e1' : '#475569';
    const gridColor = isDark ? '#1e293b' : '#dbe3f3';
    
    const charts = [pieChart, doughnutChart, lineChart, barChart, radarChart];
    charts.forEach(chart => {
        if (!chart) return;
        
        if (chart.options.plugins?.legend?.labels) {
            chart.options.plugins.legend.labels.color = textColor;
        }
        
        if (chart.options.scales) {
            Object.keys(chart.options.scales).forEach(scaleKey => {
                const scale = chart.options.scales[scaleKey];
                if (scale.ticks) scale.ticks.color = textColor;
                if (scale.grid) scale.grid.color = gridColor;
                if (scale.pointLabels) scale.pointLabels.color = textColor;
            });
        }
        
        chart.update();
    });
};

// Logout function
async function logout() {
    try {
        await fetch('auth.php', {
            method: 'POST',
            body: new URLSearchParams({ action: 'logout' })
        });
        window.location.href = 'index.php';
    } catch (error) {
        window.location.href = 'index.php';
    }
}

// UI wiring- filters, export, quick actions
function wireDashboardUI() {
    const search = document.getElementById('searchInput');
    const typeSel = document.getElementById('filterType');
    const catSel = document.getElementById('filterCategory');
    const exportBtn = document.getElementById('exportCsv');
    const quickIncome = document.getElementById('quickIncome');
    const quickExpense = document.getElementById('quickExpense');
    const navOverview = document.getElementById('navOverview');
    const navTransactions = document.getElementById('navTransactions');
    const navBudgets = document.getElementById('navBudgets');
    const navReports = document.getElementById('navReports');
    const navSettings = document.getElementById('navSettings');

    const applyFilters = () => {
        const q = (search && search.value ? search.value : '').toLowerCase();
        const type = (typeSel && typeSel.value) || '';
        const cat = (catSel && catSel.value) || '';
        filtered = (transactions || []).filter(t => {
            const matchesQ = !q || (t.description || '').toLowerCase().includes(q);
            const matchesType = !type || t.type === type;
            const matchesCat = !cat || t.category === cat;
            return matchesQ && matchesType && matchesCat;
        });
        updateStats();
        updateCharts();
        displayTransactions();
    };

    search && search.addEventListener('input', applyFilters);
    typeSel && typeSel.addEventListener('change', applyFilters);
    catSel && catSel.addEventListener('change', applyFilters);
    exportBtn && exportBtn.addEventListener('click', () => exportToCsv(filtered));

    quickIncome && quickIncome.addEventListener('click', () => prefillTransaction('income'));
    quickExpense && quickExpense.addEventListener('click', () => prefillTransaction('expense'));

    // Sidebar navigation
    navOverview && navOverview.addEventListener('click', (e) => {
        e.preventDefault();
        openMiniModal('Dashboard Overview', `
            <div class="p-3">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="quick-stat-item">
                            <i class="fas fa-list"></i>
                            <h4>${transactions.length}</h4>
                            <p class="text-muted mb-0">Total Transactions</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="quick-stat-item">
                            <i class="fas fa-calendar"></i>
                            <h4>${new Date().toLocaleDateString('en-US', { month: 'short' })}</h4>
                            <p class="text-muted mb-0">Current Month</p>
                        </div>
                    </div>
                </div>
            </div>
        `);
    });

    navTransactions && navTransactions.addEventListener('click', (e) => {
        e.preventDefault();
        openMiniModal('Add Transaction', miniTransactionForm());
        bindMiniTransactionForm();
    });

    navBudgets && navBudgets.addEventListener('click', (e) => {
        e.preventDefault();
        openMiniModal('Budget Management', renderBudgetForm() + '<hr>' + renderBudgetsList());
        bindBudgetForm();
        document.getElementById('miniModal').addEventListener('click', handleBudgetModalClicks, { once: false });
    });

    navReports && navReports.addEventListener('click', (e) => {
        e.preventDefault();
        openMiniModal('Reports & Export', `
            <div class="d-grid gap-3">
                <button class="btn btn-glow" onclick="exportToCsv(filtered)">
                    <i class="fas fa-file-csv me-2"></i>Export to CSV
                </button>
                <button class="btn btn-outline-custom" onclick="printDashboard()">
                    <i class="fas fa-print me-2"></i>Print Dashboard
                </button>
                <button class="btn btn-outline-custom" onclick="generatePDFReport()">
                    <i class="fas fa-file-pdf me-2"></i>Generate PDF Report
                </button>
            </div>
            <div class="mt-3 p-3 bg-light rounded" style="background: rgba(255,255,255,0.5) !important; border: 1px solid var(--border-color);">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    <strong>Print Dashboard:</strong> Opens the print dialog with optimized dashboard view (hides sidebar/nav).<br>
                    <strong>Generate PDF:</strong> Downloads a text-based report with stats and recent transactions.
                </small>
            </div>
        `);
    });

    navSettings && navSettings.addEventListener('click', (e) => {
        e.preventDefault();
        openMiniModal('Settings', `
            <div class="p-3">
                <h6 class="mb-3">Appearance</h6>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="miniThemeToggle" ${document.documentElement.getAttribute('data-theme')==='dark'?'checked':''}>
                    <label class="form-check-label" for="miniThemeToggle">Dark Mode</label>
                </div>
                <hr>
                <h6 class="mb-3">Preferences</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="animationsToggle" checked>
                    <label class="form-check-label" for="animationsToggle">Enable Animations</label>
                </div>
            </div>
        `);
        const toggle = document.getElementById('miniThemeToggle');
        toggle && toggle.addEventListener('change', () => {
            const next = toggle.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            window.applyThemeToCharts();
        });
    });
}

function handleBudgetModalClicks(e) {
    if (e.target.matches('[onclick*="addBudget"]') || e.target.closest('button[onclick*="addBudget"]')) {
        e.preventDefault();
        addBudget();
    } else if (e.target.matches('[onclick*="editBudget"]') || e.target.closest('button[onclick*="editBudget"]')) {
        e.preventDefault();
        const category = e.target.closest('.budget-item').dataset.category;
        editBudget(category);
    } else if (e.target.matches('[onclick*="deleteBudget"]') || e.target.closest('button[onclick*="deleteBudget"]')) {
        e.preventDefault();
        const category = e.target.closest('.budget-item').dataset.category;
        deleteBudget(category);
    }
}

// Print Dashboard Function
function printDashboard() {
    window.print();
    showNotification('Print dialog opened. Use your browser\'s print options to save or print the dashboard.', 'info');
}

// Export to CSV
function exportToCsv(rows) {
    if (!rows || !rows.length) {
        showNotification('No data to export', 'warning');
        return;
    }
    const header = ['ID','Description','Amount','Type','Category','Date'];
    const csv = [header.join(',')].concat(rows.map(r => {
        const out = header.map(h => {
            const key = h.toLowerCase();
            let val = r[key] ?? '';
            if (key === 'date') {
                val = formatDateISO(val);
            }
            return JSON.stringify(val);
        });
        return out.join(',');
    })).join('\n');
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'transactions_' + new Date().toISOString().split('T')[0] + '.csv';
    a.click();
    URL.revokeObjectURL(url);
    showNotification('CSV exported successfully!', 'success');
}

function formatDateISO(input) {
    if (!input) return '';
    if (/^\d{4}-\d{2}-\d{2}$/.test(input)) return input;
    const d = new Date(input);
    if (isNaN(d.getTime())) return String(input);
    const y = d.getFullYear();
    const m = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    return `${y}-${m}-${day}`;
}

function prefillTransaction(type) {
    const form = document.getElementById('transactionForm');
    if (!form) return;
    form.querySelector('select[name="type"]').value = type;
    form.querySelector('input[name="description"]').focus();
    const card = document.getElementById('addTransactionCard');
    if (card) {
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Modal helpers
function openMiniModal(title, html) {
    const titleEl = document.getElementById('miniModalTitle');
    const bodyEl = document.getElementById('miniModalBody');
    if (!titleEl || !bodyEl) return;
    titleEl.innerHTML = '<i class="fas fa-bolt me-2"></i>' + title;
    bodyEl.innerHTML = html;
    const modalEl = document.getElementById('miniModal');
    if (!modalEl) return;
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}

function miniTransactionForm() {
    return `
        <form id="miniTxForm" class="p-3">
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input class="form-control" name="description" placeholder="Enter description" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Amount (Rs.)</label>
                <input type="number" step="0.01" class="form-control" name="amount" placeholder="0.00" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select class="form-select" name="type" required>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-select" name="category" required>
                    <option value="Salary">Salary</option>
                    <option value="Food">Food</option>
                    <option value="Transport">Transport</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Shopping">Shopping</option>
                    <option value="Bills">Bills</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="d-grid">
                <button class="btn btn-glow" type="submit">
                    <i class="fas fa-check me-2"></i>Save Transaction
                </button>
            </div>
        </form>
    `;
}

function bindMiniTransactionForm() {
    const form = document.getElementById('miniTxForm');
    if (!form) return;
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const fd = new FormData(form);
        try {
            const res = await fetch('api.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'add_transaction',
                    ...Object.fromEntries(fd)
                })
            });
            const data = await res.json();
            if (data.success) {
                const modalEl = document.getElementById('miniModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal && modal.hide();
                loadTransactions();
                showNotification('Transaction added successfully!', 'success');
            } else {
                showNotification(data.message || 'Failed to add', 'error');
            }
        } catch (err) {
            showNotification('Failed to add transaction', 'error');
        }
    });
}

// Generate PDF Report
function generatePDFReport() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    let yPos = 20;

    // Title
    doc.setFontSize(20);
    doc.text('Budget Dashboard Report', 20, yPos);
    yPos += 15;

    // Stats
    doc.setFontSize(12);
    const income = filtered.filter(t => t.type === 'income').reduce((sum, t) => sum + parseFloat(t.amount), 0);
    const expense = filtered.filter(t => t.type === 'expense').reduce((sum, t) => sum + parseFloat(t.amount), 0);
    const balance = income - expense;

    doc.text(`Total Income: Rs. ${income.toFixed(2)}`, 20, yPos);
    yPos += 10;
    doc.text(`Total Expenses: Rs. ${expense.toFixed(2)}`, 20, yPos);
    yPos += 10;
    doc.text(`Current Balance: Rs. ${balance.toFixed(2)}`, 20, yPos);
    yPos += 20;

    // Recent Transactions
    doc.text('Recent Transactions:', 20, yPos);
    yPos += 10;

    const recent = filtered.slice(-10).reverse();
    recent.forEach(t => {
        if (yPos > 270) {
            doc.addPage();
            yPos = 20;
        }
        const typeIcon = t.type === 'income' ? '+' : '-';
        doc.text(`${typeIcon} Rs. ${parseFloat(t.amount).toFixed(2)} - ${t.description} (${t.category}) - ${formatDate(t.date)}`, 20, yPos);
        yPos += 8;
    });

    // Footer
    yPos += 10;
    doc.setFontSize(10);
    doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 20, yPos);

    doc.save('budget_report.pdf');
    showNotification('PDF report generated and downloaded successfully!', 'success');
}

// Show notification toast
function showNotification(message, type = 'info') {
    const colors = {
        success: 'linear-gradient(135deg, #10b981, #059669)',
        error: 'linear-gradient(135deg, #ef4444, #dc2626)',
        warning: 'linear-gradient(135deg, #f59e0b, #d97706)',
        info: 'linear-gradient(135deg, #0ea5e9, #1d4ed8)'
    };
    
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${colors[type] || colors.info};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        animation: slideInRight 0.3s ease-out;
        max-width: 400px;
    `;
    
    notification.innerHTML = `
        <i class="fas ${icons[type] || icons.info} fa-lg"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Initialize animations
function initAnimations() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
    `;
    document.head.appendChild(style);
}

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('searchInput')?.focus();
    }
    
    // Ctrl/Cmd + N for new transaction
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        document.getElementById('quickIncome')?.click();
    }
});

        // Theme toggle
        (function() {
            const html = document.documentElement;
            const saved = localStorage.getItem('theme') || 'light';
            html.setAttribute('data-theme', saved);
            
            const toggleBtn = document.getElementById('themeToggle');
            const setIcon = () => {
                const i = toggleBtn.querySelector('i');
                i.className = (html.getAttribute('data-theme') === 'light') ? 'fas fa-moon' : 'fas fa-sun';
            };
            
            setIcon();
            
            toggleBtn.addEventListener('click', () => {
                const next = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
                html.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);
                setIcon();
                if (window.applyThemeToCharts) window.applyThemeToCharts();
            });
        })();

        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.chart-container, .stat-card').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>