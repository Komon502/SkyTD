<?php
// SkyTrade Routing System
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/DashboardController.php';
require_once __DIR__ . '/../app/Controllers/TradeController.php';
require_once __DIR__ . '/../app/Controllers/AdminController.php';

// Get the requested path
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = strtok($request_uri, '?'); // Remove query string
$path = rtrim($request_uri, '/') ?: '/';

// Initialize controllers
$authController = new AuthController();
$dashboardController = new DashboardController();
$tradeController = new TradeController();
$adminController = new AdminController();

// Route definitions
switch ($path) {
    // Home page
    case '/':
        if (User::isLoggedIn()) {
            header('Location: /dashboard');
            exit;
        }
        include __DIR__ . '/../app/Views/home.php';
        break;
        
    // Authentication routes
    case '/login':
        $authController->showLogin();
        break;
        
    case '/login/post':
        $authController->login();
        break;
        
    case '/register':
        $authController->showRegister();
        break;
        
    case '/register/post':
        $authController->register();
        break;

    case '/forgot-password':
        $authController->showForgotPassword();
        break;
        
    case '/forgot-password/post':
        $authController->forgotPassword();
        break;
        
    case '/logout':
        $authController->logout();
        break;
        
    // Dashboard routes
    case '/dashboard':
        $dashboardController->index();
        break;
        
    case '/profile':
        $dashboardController->profile();
        break;
        
    case '/deposit':
        $dashboardController->deposit();
        break;
        
    // Trading routes
    case '/trade':
        $tradeController->showTrade();
        break;
        
    case '/trade/mt5':
        $mt5Controller = new MT5Controller();
        $mt5Controller->index();
        break;
        
    case '/trade/mt5/execute':
        $mt5Controller = new MT5Controller();
        $mt5Controller->execute();
        break;
        
    case '/trade/execute':
        $tradeController->executeTrade();
        break;
        
    case '/trade/history':
        $tradeController->history();
        break;
        
    case '/trade/select-mode':
        $tradeController->selectMode();
        break;
        
    case '/trade/view':
        $tradeId = $_GET['id'] ?? 0;
        $tradeController->viewTrade($tradeId);
        break;
        
    // API routes for trading
    case '/api/pending-trades':
        $tradeController->getPendingTrades();
        break;
        
    case '/api/update-prices':
        $tradeController->updatePrices();
        break;
        
    // Admin routes
    case '/admin':
        $adminController->dashboard();
        break;
        
    case '/admin/users':
        $adminController->manageUsers();
        break;
        
    case '/admin/forex':
        $adminController->manageForex();
        break;
        
    case '/admin/slips':
        $adminController->approveSlip();
        break;
        
    case '/admin/trades':
        $adminController->viewTrades();
        break;
        
    case '/admin/transactions':
        $adminController->viewTransactions();
        break;
        
    case '/admin/settings':
        $adminController->settings();
        break;
        
    // API Routes
    case '/api/trade-history':
        $apiController = new ApiController();
        $apiController->getTradeHistory();
        break;
        
    case '/api/update-prices':
        $apiController = new ApiController();
        $apiController->updatePrices();
        break;
        
    // 404 - Page not found
    default:
        http_response_code(404);
        include __DIR__ . '/../app/Views/errors/404.php';
        break;
}
