<!DOCTYPE html>
<html lang="th">

<head>
    <?php $title = 'SkyTrade Terminal'; include __DIR__ . '/../partials/head.php'; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.js"></script>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-base: #0a0c0f;
            --bg-panel: #111418;
            --bg-card: #181c22;
            --bg-hover: #1e242d;
            --bg-active: #232b36;
            --border: rgba(255, 255, 255, 0.06);
            --border-bright: rgba(255, 255, 255, 0.12);
            --text-primary: #e8eaf0;
            --text-secondary: #8892a4;
            --text-muted: #4a5568;
            --accent-blue: #3b82f6;
            --accent-green: #22c55e;
            --accent-red: #ef4444;
            --accent-amber: #f59e0b;
            --accent-cyan: #06b6d4;
            --glow-green: rgba(34, 197, 94, 0.15);
            --glow-red: rgba(239, 68, 68, 0.15);
            --glow-blue: rgba(59, 130, 246, 0.15);
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --font-mono: 'JetBrains Mono', monospace;
            --font-ui: 'Syne', sans-serif;
        }

        html,
        body {
            height: 100%;
            background: var(--bg-base);
            color: var(--text-primary);
            font-family: var(--font-ui);
            overflow: hidden;
        }

        /* ─── Scrollbar ─── */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-bright);
            border-radius: 2px;
        }

        /* ─── Layout ─── */
        #app {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* ─── Top Bar ─── */
        #topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            height: 44px;
            background: var(--bg-panel);
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: var(--text-primary);
        }

        .brand-icon {
            width: 26px;
            height: 26px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            font-family: var(--font-mono);
        }

        .menu-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 12px;
            font-family: var(--font-ui);
            padding: 4px 8px;
            border-radius: var(--radius-sm);
            transition: color 0.15s, background 0.15s;
        }

        .menu-btn:hover {
            color: var(--text-primary);
            background: var(--bg-hover);
        }

        .action-btns {
            display: flex;
            gap: 4px;
        }

        .action-btn {
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            font-size: 11px;
            font-family: var(--font-mono);
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.15s;
        }

        .btn-quotes {
            background: rgba(59, 130, 246, 0.15);
            color: var(--accent-blue);
        }

        .btn-trade {
            background: rgba(34, 197, 94, 0.15);
            color: var(--accent-green);
        }

        .btn-history {
            background: rgba(168, 85, 247, 0.15);
            color: #a855f7;
        }

        .btn-graph {
            background: rgba(245, 158, 11, 0.15);
            color: var(--accent-amber);
        }

        .action-btn:hover {
            filter: brightness(1.3);
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent-green);
            box-shadow: 0 0 6px var(--accent-green);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        .status-text {
            font-size: 11px;
            color: var(--accent-green);
            font-family: var(--font-mono);
        }

        .time-display {
            font-size: 11px;
            color: var(--text-secondary);
            font-family: var(--font-mono);
        }

        /* ─── Body ─── */
        #body {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* ─── Left Sidebar ─── */
        #left-sidebar {
            width: 200px;
            flex-shrink: 0;
            background: var(--bg-panel);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .panel-label {
            padding: 8px 12px 6px;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        .market-list {
            overflow-y: auto;
            flex: 1;
        }

        .market-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 12px;
            cursor: pointer;
            border-bottom: 1px solid var(--border);
            transition: background 0.12s;
            position: relative;
        }

        .market-item:hover {
            background: var(--bg-hover);
        }

        .market-item.active {
            background: var(--bg-active);
        }

        .market-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--accent-blue);
        }

        .pair-symbol {
            font-size: 12px;
            font-family: var(--font-mono);
            font-weight: 500;
        }

        .pair-price {
            font-size: 11px;
            font-family: var(--font-mono);
            color: var(--text-primary);
            text-align: right;
        }

        .pair-change {
            font-size: 10px;
            color: var(--accent-green);
            text-align: right;
        }

        .nav-section {
            border-top: 1px solid var(--border);
            padding: 8px;
        }

        .nav-item {
            padding: 6px 8px;
            font-size: 11px;
            color: var(--text-secondary);
            cursor: pointer;
            border-radius: var(--radius-sm);
            transition: all 0.12s;
        }

        .nav-item:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
        }

        .nav-item.active {
            background: var(--bg-active);
            color: var(--text-primary);
        }

        /* ─── Center Chart ─── */
        #chart-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--bg-base);
            overflow: hidden;
        }

        .chart-toolbar {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            background: var(--bg-panel);
            border-bottom: 1px solid var(--border);
        }

        #chartSymbol {
            background: var(--bg-card);
            color: var(--text-primary);
            border: 1px solid var(--border-bright);
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-family: var(--font-mono);
            cursor: pointer;
            outline: none;
        }

        .tf-group {
            display: flex;
            gap: 2px;
        }

        .tf-btn {
            padding: 3px 7px;
            font-size: 10px;
            font-family: var(--font-mono);
            background: none;
            border: 1px solid var(--border);
            color: var(--text-secondary);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.12s;
        }

        .tf-btn:hover,
        .tf-btn.active {
            background: var(--bg-active);
            color: var(--text-primary);
            border-color: var(--border-bright);
        }

        #chart-canvas-wrap {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        #priceChart {
            width: 100% !important;
            height: 100% !important;
        }

        .chart-overlay {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(17, 20, 24, 0.85);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border-bright);
            border-radius: var(--radius-md);
            padding: 10px 14px;
            font-family: var(--font-mono);
        }

        .overlay-symbol {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .overlay-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            font-size: 11px;
        }

        .overlay-label {
            color: var(--text-muted);
        }

        .overlay-val {
            color: var(--text-primary);
        }

        .overlay-spread {
            color: var(--accent-amber);
        }

        .chart-statusbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 12px;
            background: var(--bg-panel);
            border-top: 1px solid var(--border);
            font-size: 10px;
            font-family: var(--font-mono);
            color: var(--text-muted);
        }

        /* ─── Right Panel ─── */
        #right-panel {
            width: 260px;
            flex-shrink: 0;
            background: var(--bg-panel);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ─── Trade Form ─── */
        .trade-section {
            padding: 12px;
            border-bottom: 1px solid var(--border);
        }

        .form-field {
            margin-bottom: 10px;
        }

        .field-label {
            display: block;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .field-input {
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 7px 10px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-family: var(--font-mono);
            outline: none;
            transition: border-color 0.15s;
        }

        .field-input:focus {
            border-color: var(--accent-blue);
        }

        .trade-btns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 12px;
        }

        .buy-btn,
        .sell-btn {
            padding: 12px;
            border: none;
            border-radius: var(--radius-md);
            font-family: var(--font-mono);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }

        .buy-btn {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.35);
            color: var(--accent-green);
        }

        .buy-btn:hover {
            background: rgba(34, 197, 94, 0.25);
            box-shadow: 0 0 20px var(--glow-green);
        }

        .sell-btn {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: var(--accent-red);
        }

        .sell-btn:hover {
            background: rgba(239, 68, 68, 0.25);
            box-shadow: 0 0 20px var(--glow-red);
        }

        .btn-label {
            font-size: 14px;
            font-weight: 700;
        }

        .btn-price {
            font-size: 10px;
            opacity: 0.7;
        }

        /* ─── Positions ─── */
        .positions-list {
            flex: 1;
            overflow-y: auto;
        }

        .position-item {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
        }

        .pos-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 4px;
        }

        .pos-symbol {
            font-size: 12px;
            font-family: var(--font-mono);
            font-weight: 600;
        }

        .pos-badge {
            font-size: 9px;
            font-family: var(--font-mono);
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 3px;
            background: rgba(245, 158, 11, 0.15);
            color: var(--accent-amber);
        }

        .pos-detail {
            font-size: 10px;
            color: var(--text-secondary);
            font-family: var(--font-mono);
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            color: var(--text-muted);
            font-size: 11px;
            text-align: center;
            gap: 8px;
        }

        .empty-icon {
            font-size: 28px;
            opacity: 0.3;
        }

        /* ─── Account Info ─── */
        .account-section {
            border-top: 1px solid var(--border);
            padding: 12px;
        }

        .account-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .account-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 10px;
        }

        .account-label {
            font-size: 9px;
            color: var(--text-muted);
            font-family: var(--font-mono);
            letter-spacing: 0.08em;
            margin-bottom: 3px;
        }

        .account-value {
            font-size: 12px;
            font-family: var(--font-mono);
            font-weight: 500;
            color: var(--text-primary);
        }

        /* ─── Panels (Quotes / History / Graph) ─── */
        .dynamic-panel {
            flex: 1;
            overflow-y: auto;
            display: none;
        }

        .dynamic-panel.visible {
            display: block;
        }

        .quote-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            transition: background 0.12s;
        }

        .quote-item:hover {
            background: var(--bg-hover);
        }

        .quote-sym {
            font-size: 12px;
            font-family: var(--font-mono);
            font-weight: 500;
        }

        .quote-name {
            font-size: 10px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .quote-price {
            font-size: 12px;
            font-family: var(--font-mono);
            text-align: right;
        }

        .quote-chg {
            font-size: 10px;
            color: var(--accent-green);
            text-align: right;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
        }

        .hist-sym {
            font-size: 12px;
            font-family: var(--font-mono);
            font-weight: 500;
        }

        .hist-meta {
            font-size: 10px;
            color: var(--text-muted);
            font-family: var(--font-mono);
            margin-top: 2px;
        }

        .hist-result {
            font-size: 11px;
            font-family: var(--font-mono);
            text-align: right;
        }

        .hist-pnl {
            font-size: 12px;
            font-family: var(--font-mono);
            font-weight: 500;
            text-align: right;
        }

        .win {
            color: var(--accent-green);
        }

        .loss {
            color: var(--accent-red);
        }

        .graph-wrap {
            padding: 12px;
        }

        .graph-canvas-wrap {
            height: 200px;
            margin-bottom: 10px;
        }

        .graph-btns {
            display: flex;
            gap: 6px;
        }

        .graph-btn {
            flex: 1;
            padding: 6px;
            font-size: 10px;
            font-family: var(--font-mono);
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.12s;
        }

        .graph-btn:hover {
            background: var(--bg-active);
            color: var(--text-primary);
        }

        /* ─── Duration Selector ─── */
        .duration-group {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .dur-btn {
            flex: 1;
            min-width: 40px;
            padding: 5px 4px;
            font-size: 10px;
            font-family: var(--font-mono);
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.12s;
            text-align: center;
        }

        .dur-btn:hover,
        .dur-btn.active {
            background: var(--bg-active);
            color: var(--text-primary);
            border-color: var(--border-bright);
        }

        /* ─── Mode Toggle ─── */
        .mode-toggle {
            display: flex;
            gap: 4px;
            margin-bottom: 12px;
        }

        .mode-btn {
            flex: 1;
            padding: 5px;
            font-size: 10px;
            font-family: var(--font-mono);
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-muted);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.15s;
            text-align: center;
        }

        .mode-btn.demo.active {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.4);
            color: var(--accent-blue);
        }

        .mode-btn.real.active {
            background: rgba(34, 197, 94, 0.15);
            border-color: rgba(34, 197, 94, 0.4);
            color: var(--accent-green);
        }

        /* ─── Scrollable panels ─── */
        .panel-scroll {
            overflow-y: auto;
        }

        /* ─── Responsive ─── */
        @media (max-width: 1024px) {
            #left-sidebar {
                display: none;
            }

            #right-panel {
                width: 220px;
            }
        }

        @media (max-width: 768px) {
            #right-panel {
                width: 200px;
            }

            .trade-btns .buy-btn,
            .trade-btns .sell-btn {
                padding: 9px;
            }
        }

        /* Extra small screens - stack panels vertically and allow scrolling */
        @media (max-width: 480px) {
            html, body { overflow: auto; }
            #app { height: auto; }
            #body { flex-direction: column; overflow: visible; }
            #left-sidebar { display: none; }
            #right-panel { width: 100%; order: 2; border-left: none; border-top: 1px solid var(--border); }
            #chart-area { order: 1; height: 60vh; }
            #chart-canvas-wrap { height: 100%; }
            .panel-scroll { max-height: 28vh; overflow-y: auto; }
            .trade-btns { grid-template-columns: 1fr; }
            .chart-overlay { position: static; margin: 8px; backdrop-filter: none; }
            .menu-btn { display: none; }
            .brand { font-size: 12px; }
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../partials/user_navbar.php'; ?>
    <div id="app">

        <!-- ════════ TOP BAR ════════ -->
        <div id="topbar">
            <div class="topbar-left">
                <div class="brand">
                    <div class="brand-icon">ST</div>
                    SkyTrade
                </div>
                <div style="display:flex; gap:2px;">
                    <button class="menu-btn">File</button>
                    <button class="menu-btn">View</button>
                    <button class="menu-btn">Tools</button>
                    <button class="menu-btn">Window</button>
                    <button class="menu-btn">Help</button>
                </div>
                <div class="action-btns">
                    <button class="action-btn btn-quotes" onclick="showPanel('quotes')">Quotes</button>
                    <button class="action-btn btn-trade" onclick="showPanel('trade')">Buy/Sell</button>
                    <button class="action-btn btn-history" onclick="showPanel('history')">History</button>
                    <button class="action-btn btn-graph" onclick="showPanel('graph')">Graph</button>
                </div>
            </div>
            <div class="topbar-right">
                <div class="status-dot"></div>
                <span class="status-text">ONLINE</span>
                <span class="time-display" id="clockDisplay"><?php echo date('H:i:s'); ?></span>
            </div>
        </div>

        <!-- ════════ BODY ════════ -->
        <div id="body">

            <!-- ── LEFT SIDEBAR ── -->
            <div id="left-sidebar">
                <div class="panel-label">Market Watch</div>
                <div class="market-list">
                    <?php foreach ($forexPairs as $i => $pair): ?>
                        <div class="market-watch-item market-item <?php echo $i === 0 ? 'active' : ''; ?>"
                            data-symbol="<?php echo $pair->symbol; ?>"
                            data-price="<?php echo $pair->current_price; ?>"
                            data-id="<?php echo $pair->id; ?>">
                            <div>
                                <div class="pair-symbol"><?php echo htmlspecialchars($pair->symbol); ?></div>
                            </div>
                            <div>
                                <div class="pair-price"><?php echo number_format($pair->current_price, 5); ?></div>
                                <div class="pair-change">+0.00012</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="nav-section">
                    <div class="panel-label" style="padding:0 0 6px; border:none;">Navigator</div>
                    <div class="nav-item active">Demo Account</div>
                    <div class="nav-item">Real Account</div>
                </div>
            </div>

            <!-- ── CHART AREA ── -->
            <div id="chart-area">
                <div class="chart-toolbar">
                    <select id="chartSymbol">
                        <?php foreach ($forexPairs as $pair): ?>
                            <option value="<?php echo $pair->id; ?>" data-price="<?php echo $pair->current_price; ?>">
                                <?php echo htmlspecialchars($pair->symbol); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="tf-group">
                        <button class="tf-btn active">M1</button>
                        <button class="tf-btn">M5</button>
                        <button class="tf-btn">M15</button>
                        <button class="tf-btn">H1</button>
                        <button class="tf-btn">D1</button>
                    </div>
                    <div class="tf-group" style="margin-left:auto;">
                        <button class="tf-btn">Bar</button>
                        <button class="tf-btn active">Line</button>
                        <button class="tf-btn">Candle</button>
                    </div>
                </div>

                <div id="chart-canvas-wrap">
                    <canvas id="priceChart"></canvas>
                    <div class="chart-overlay">
                        <div class="overlay-symbol" id="chartSymbolDisplay">
                            <?php echo htmlspecialchars($forexPairs[0]->symbol ?? 'EUR/USD'); ?>
                        </div>
                        <div class="overlay-row">
                            <span class="overlay-label">Bid</span>
                            <span class="overlay-val" id="bidPrice">0.00000</span>
                        </div>
                        <div class="overlay-row">
                            <span class="overlay-label">Ask</span>
                            <span class="overlay-val" id="askPrice">0.00000</span>
                        </div>
                        <div class="overlay-row">
                            <span class="overlay-label">Spread</span>
                            <span class="overlay-spread">1.1</span>
                        </div>
                    </div>
                </div>

                <div class="chart-statusbar">
                    <span>Connected &nbsp;|&nbsp; Real-time data</span>
                    <span id="lastUpdate">Last: <?php echo date('H:i:s'); ?></span>
                    <span id="modeLabel">Account: Demo</span>
                </div>
            </div>

            <!-- ── RIGHT PANEL ── -->
            <div id="right-panel">

                <!-- QUICK TRADE (default) -->
                <div id="panel-trade" class="dynamic-panel visible">
                    <div class="panel-label">Quick Trade</div>
                    <div class="trade-section">
                        <form action="/trade/mt5/execute" method="POST">
                            <input type="hidden" name="forex_pair_id" id="selectedPairId" value="<?php echo $forexPairs[0]->id ?? ''; ?>">
                            <input type="hidden" name="direction" id="selectedDirection">

                            <div class="mode-toggle">
                                <div class="mode-btn demo active" onclick="setMode('demo',this)">DEMO</div>
                                <div class="mode-btn real" onclick="setMode('real',this)">REAL</div>
                            </div>
                            <input type="hidden" name="mode" id="modeInput" value="<?php echo ($_SESSION['trade_mode'] ?? 'demo'); ?>">

                            <div class="form-field">
                                <label class="field-label">Volume (฿)</label>
                                <input type="number" name="amount" class="field-input" min="10" step="1" placeholder="100.00" required>
                            </div>
                            <div class="form-field">
                                <label class="field-label">Stop Loss</label>
                                <input type="number" step="0.00001" class="field-input" placeholder="0.00000">
                            </div>
                            <div class="form-field">
                                <label class="field-label">Take Profit</label>
                                <input type="number" step="0.00001" class="field-input" placeholder="0.00000">
                            </div>
                            <div class="form-field">
                                <label class="field-label">Duration</label>
                                <div class="duration-group">
                                    <div class="dur-btn active" onclick="setDuration(30,this)">30s</div>
                                    <div class="dur-btn" onclick="setDuration(60,this)">1m</div>
                                    <div class="dur-btn" onclick="setDuration(120,this)">2m</div>
                                    <div class="dur-btn" onclick="setDuration(300,this)">5m</div>
                                </div>
                                <input type="hidden" name="duration" id="durationInput" value="30">
                            </div>

                            <div class="trade-btns">
                                <button type="button" class="buy-btn" onclick="submitTrade('buy')">
                                    <span class="btn-label">BUY</span>
                                    <span class="btn-price" id="buyPrice">↑</span>
                                </button>
                                <button type="button" class="sell-btn" onclick="submitTrade('sell')">
                                    <span class="btn-label">SELL</span>
                                    <span class="btn-price" id="sellPrice">↓</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Positions -->
                    <div class="panel-label">Open Positions</div>
                    <div class="panel-scroll">
                        <?php if (!empty($pending_trades)): ?>
                            <?php foreach ($pending_trades as $trade): ?>
                                <div class="position-item">
                                    <div class="pos-header">
                                        <span class="pos-symbol"><?php echo htmlspecialchars($trade->symbol); ?></span>
                                        <span class="pos-badge">PENDING</span>
                                    </div>
                                    <div class="pos-detail">
                                        <?php echo $trade->direction === 'up' ? 'BUY' : 'SELL'; ?>
                                        &nbsp;฿<?php echo number_format($trade->amount, 2); ?>
                                        &nbsp;@ <?php echo number_format($trade->entry_price, 5); ?>
                                    </div>
                                    <div class="pos-detail" style="margin-top:2px;">
                                        Exp: <?php echo date('H:i:s', strtotime($trade->expires_at)); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <div class="empty-icon">◫</div>
                                No open positions
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- QUOTES PANEL -->
                <div id="panel-quotes" class="dynamic-panel">
                    <div class="panel-label">Live Quotes</div>
                    <?php foreach ($forexPairs as $pair): ?>
                        <div class="quote-item"
                            data-symbol="<?php echo $pair->symbol; ?>"
                            data-price="<?php echo $pair->current_price; ?>"
                            data-id="<?php echo $pair->id; ?>">
                            <div>
                                <div class="quote-sym"><?php echo htmlspecialchars($pair->symbol); ?></div>
                                <div class="quote-name"><?php echo htmlspecialchars($pair->name ?? ''); ?></div>
                            </div>
                            <div>
                                <div class="quote-price"><?php echo number_format($pair->current_price, 5); ?></div>
                                <div class="quote-chg">+0.00012</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- HISTORY PANEL -->
                <div id="panel-history" class="dynamic-panel">
                    <div class="panel-label">Trade History</div>
                    <?php
                    $tradeHistory = Trade::getByUser($currentUser->id, 50);
                    $hasHistory = false;
                    foreach ($tradeHistory as $t):
                        if ($t->result !== 'pending'):
                            $hasHistory = true;
                    ?>
                            <div class="history-item">
                                <div>
                                    <div class="hist-sym"><?php echo htmlspecialchars($t->symbol); ?></div>
                                    <div class="hist-meta">
                                        <?php echo $t->direction === 'up' ? 'BUY' : 'SELL'; ?>
                                        &nbsp;<?php echo date('d/m H:i', strtotime($t->created_at)); ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="hist-result <?php echo $t->result === 'win' ? 'win' : 'loss'; ?>">
                                        <?php echo strtoupper($t->result); ?>
                                    </div>
                                    <div class="hist-pnl <?php echo ($t->profit_loss ?? 0) >= 0 ? 'win' : 'loss'; ?>">
                                        <?php echo ($t->profit_loss ?? 0) >= 0 ? '+' : ''; ?><?php echo number_format($t->profit_loss ?? 0, 2); ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endif;
                    endforeach;
                    if (!$hasHistory): ?>
                        <div class="empty-state">
                            <div class="empty-icon">◫</div>
                            No trade history
                        </div>
                    <?php endif; ?>
                </div>

                <!-- GRAPH PANEL -->
                <div id="panel-graph" class="dynamic-panel">
                    <div class="panel-label">P&amp;L Graph</div>
                    <div class="graph-wrap">
                        <div class="graph-canvas-wrap">
                            <canvas id="tradeGraph"></canvas>
                        </div>
                        <div class="graph-btns">
                            <button class="graph-btn" onclick="changeGraphType('line')">Line</button>
                            <button class="graph-btn" onclick="changeGraphType('bar')">Bar</button>
                        </div>
                    </div>
                </div>

                <!-- ACCOUNT INFO (always visible bottom) -->
                <div class="account-section">
                    <div class="panel-label" style="padding:0 0 8px; border:none;">Account</div>
                    <div class="account-grid">
                        <div class="account-card">
                            <div class="account-label">Balance</div>
                            <div class="account-value">฿<?php echo number_format(User::getBalance($currentUser->id, 'demo'), 2); ?></div>
                        </div>
                        <div class="account-card">
                            <div class="account-label">Equity</div>
                            <div class="account-value">฿<?php echo number_format(User::getBalance($currentUser->id, 'demo'), 2); ?></div>
                        </div>
                        <div class="account-card">
                            <div class="account-label">Margin</div>
                            <div class="account-value">0.00</div>
                        </div>
                        <div class="account-card">
                            <div class="account-label">Free Margin</div>
                            <div class="account-value">฿<?php echo number_format(User::getBalance($currentUser->id, 'demo'), 2); ?></div>
                        </div>
                    </div>
                </div>

            </div><!-- /right-panel -->
        </div><!-- /body -->
    </div><!-- /app -->

    <script>
        // ─── Chart setup ───────────────────────────────────────────────
        const priceCtx = document.getElementById('priceChart').getContext('2d');
        const priceChart = new Chart(priceCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Price',
                    data: [],
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,0.05)',
                    tension: 0.2,
                    fill: true,
                    borderWidth: 1.5,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 300
                },
                interaction: {
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#111418',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        titleColor: '#e8eaf0',
                        bodyColor: '#8892a4',
                        titleFont: {
                            family: 'JetBrains Mono',
                            size: 11
                        },
                        bodyFont: {
                            family: 'JetBrains Mono',
                            size: 10
                        },
                        callbacks: {
                            label: ctx => ctx.parsed.y.toFixed(5)
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255,255,255,0.04)'
                        },
                        ticks: {
                            color: '#4a5568',
                            maxTicksLimit: 8,
                            font: {
                                family: 'JetBrains Mono',
                                size: 9
                            }
                        }
                    },
                    y: {
                        position: 'right',
                        grid: {
                            color: 'rgba(255,255,255,0.04)'
                        },
                        ticks: {
                            color: '#4a5568',
                            font: {
                                family: 'JetBrains Mono',
                                size: 9
                            },
                            callback: v => v.toFixed(5)
                        }
                    }
                }
            }
        });

        let tradeGraph = null;

        // ─── Price update ────────────────────────────────────────────────
        function updatePriceChart() {
            const sel = document.getElementById('chartSymbol');
            const opt = sel.options[sel.selectedIndex];
            const base = parseFloat(opt?.dataset?.price || 1.0);
            const prices = [],
                labels = [];
            for (let i = 120; i >= 0; i--) {
                prices.push(base + (Math.random() - 0.5) * base * 0.003);
                labels.push('');
            }
            priceChart.data.labels = labels;
            priceChart.data.datasets[0].data = prices;
            priceChart.update('none');
            const bid = prices[prices.length - 1];
            document.getElementById('bidPrice').textContent = bid.toFixed(5);
            document.getElementById('askPrice').textContent = (bid + 0.00011).toFixed(5);
            document.getElementById('buyPrice').textContent = (bid + 0.00011).toFixed(5);
            document.getElementById('sellPrice').textContent = bid.toFixed(5);
        }

        updatePriceChart();
        setInterval(() => {
            updatePriceChart();
            const now = new Date().toLocaleTimeString('th-TH');
            document.getElementById('lastUpdate').textContent = 'Last: ' + now;
            document.getElementById('clockDisplay').textContent = now;
        }, 2000);

        document.getElementById('chartSymbol').addEventListener('change', () => {
            const sel = document.getElementById('chartSymbol');
            const opt = sel.options[sel.selectedIndex];
            document.getElementById('chartSymbolDisplay').textContent = opt.textContent;
            updatePriceChart();
        });

        // ─── Panel switching ─────────────────────────────────────────────
        function showPanel(name) {
            ['trade', 'quotes', 'history', 'graph'].forEach(p => {
                document.getElementById('panel-' + p).classList.remove('visible');
            });
            document.getElementById('panel-' + name).classList.add('visible');
            if (name === 'graph' && !tradeGraph) initTradeGraph();
        }

        // ─── Market watch click ───────────────────────────────────────────
        document.querySelectorAll('.market-watch-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.market-watch-item').forEach(el => el.classList.remove('active'));
                this.classList.add('active');
                const {
                    symbol,
                    price,
                    id
                } = this.dataset;
                document.getElementById('chartSymbolDisplay').textContent = symbol;
                document.getElementById('selectedPairId').value = id;
                const sel = document.getElementById('chartSymbol');
                for (let opt of sel.options) {
                    if (opt.value == id) {
                        sel.value = id;
                        break;
                    }
                }
                updatePriceChart();
            });
        });

        document.querySelectorAll('.quote-item').forEach(item => {
            item.addEventListener('click', function() {
                const {
                    symbol,
                    id
                } = this.dataset;
                document.getElementById('chartSymbolDisplay').textContent = symbol;
                document.getElementById('selectedPairId').value = id;
                const sel = document.getElementById('chartSymbol');
                for (let opt of sel.options) {
                    if (opt.value == id) {
                        sel.value = id;
                        break;
                    }
                }
                updatePriceChart();
                showPanel('trade');
            });
        });

        // ─── Trade submission ─────────────────────────────────────────────
        function submitTrade(dir) {
            document.getElementById('selectedDirection').value = dir === 'buy' ? 'up' : 'down';
            document.querySelector('form').submit();
        }

        // ─── Mode toggle ─────────────────────────────────────────────────
        function setMode(mode, el) {
            document.querySelectorAll('.mode-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('modeInput').value = mode;
            document.getElementById('modeLabel').textContent = 'Account: ' + mode.charAt(0).toUpperCase() + mode.slice(1);
        }

        // ─── Duration ────────────────────────────────────────────────────
        function setDuration(val, el) {
            document.querySelectorAll('.dur-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('durationInput').value = val;
        }

        // ─── TF buttons ──────────────────────────────────────────────────
        document.querySelectorAll('.tf-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const group = this.closest('.tf-group');
                group.querySelectorAll('.tf-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // ─── Trade graph ─────────────────────────────────────────────────
        function initTradeGraph() {
            const ctx = document.getElementById('tradeGraph').getContext('2d');
            tradeGraph = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'P/L',
                        data: [],
                        backgroundColor: ctx2 => ctx2.dataset.data[ctx2.dataIndex] >= 0 ? 'rgba(34,197,94,0.6)' : 'rgba(239,68,68,0.6)',
                        borderColor: ctx2 => ctx2.dataset.data[ctx2.dataIndex] >= 0 ? '#22c55e' : '#ef4444',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255,255,255,0.04)'
                            },
                            ticks: {
                                color: '#4a5568',
                                font: {
                                    family: 'JetBrains Mono',
                                    size: 9
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255,255,255,0.04)'
                            },
                            ticks: {
                                color: '#4a5568',
                                font: {
                                    family: 'JetBrains Mono',
                                    size: 9
                                },
                                callback: v => '฿' + v.toFixed(0)
                            }
                        }
                    }
                }
            });
            fetch('/api/trade-history')
                .then(r => r.json())
                .then(data => {
                    let cum = 0;
                    tradeGraph.data.labels = data.map((_, i) => 'T' + (i + 1));
                    tradeGraph.data.datasets[0].data = data.map(t => {
                        cum += (t.profit_loss || 0);
                        return cum;
                    });
                    tradeGraph.update();
                }).catch(() => {});
        }

        function changeGraphType(type) {
            if (!tradeGraph) return;
            tradeGraph.config.type = type;
            tradeGraph.update();
        }
    </script>
</body>

</html>