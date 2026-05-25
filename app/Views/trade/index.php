<?php

/**
 * app/Views/trade/index.php  — เขียนใหม่ทั้งหมด
 */
require_once __DIR__ . '/../../Models/User.php';

// Get current user if not already set by controller
if (!isset($currentUser)) {
  $currentUser = User::getCurrentUser();
}

$activePage = 'trade';
$username   = htmlspecialchars($currentUser->username ?? 'User');
$isAdmin    = isset($currentUser->role) && $currentUser->role === 'admin';
$tradeMode  = $_SESSION['trade_mode'] ?? 'demo';
$balDemo    = isset($currentUser) ? (float)(User::getBalance($currentUser->id, 'demo') ?? 5000) : 5000;
$balReal    = isset($currentUser) ? (float)(User::getBalance($currentUser->id, 'real') ?? 0)    : 0;
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <?php $title = 'SkyTrade — Terminal'; include __DIR__ . '/../partials/head.php'; ?>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Sarabun:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            sky: {
              50: '#f0f9ff',
              100: '#e0f2fe',
              200: '#bae6fd',
              300: '#7dd3fc',
              400: '#38bdf8',
              500: '#0ea5e9',
              600: '#0284c7',
              700: '#0369a1',
              800: '#075985',
              900: '#0c4a6e',
            }
          }
        }
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script>
    // Fallback if Chart.js fails to load
    if (typeof Chart === 'undefined') {
      console.error('Chart.js failed to load from CDN');
      // Try alternative CDN
      const script = document.createElement('script');
      script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js';
      script.onerror = () => console.error('Alternative Chart.js CDN also failed');
      document.head.appendChild(script);
    }
  </script>

<style>
    /* ═══════════════════════════════════════════
       CSS VARIABLES — Design Tokens
    ═══════════════════════════════════════════ */
    :root {
      /* Backgrounds */
      --base:   #070a10;
      --panel:  #0c1018;
      --card:   #101520;
      --hover:  rgba(255,255,255,.035);
      --act:    rgba(56,189,248,.08);
      /* Borders */
      --b0: rgba(255,255,255,.055);
      --b1: rgba(255,255,255,.10);
      --b2: rgba(255,255,255,.18);
      /* Text */
      --t0: #e4ecf8;
      --t1: #8fa5c0;
      --t2: #3d5470;
      /* Green */
      --G:  #10b981;
      --Gd: rgba(16,185,129,.12);
      --Gb: rgba(16,185,129,.28);
      /* Red */
      --R:  #f43f5e;
      --Rd: rgba(244,63,94,.12);
      --Rb: rgba(244,63,94,.28);
      /* Amber */
      --A:  #f59e0b;
      --Ad: rgba(245,158,11,.12);
      --Ab: rgba(245,158,11,.28);
      /* Blue accent */
      --B:  #38bdf8;
      --Bd: rgba(56,189,248,.12);
      --Bb: rgba(56,189,248,.28);
      /* Sky brand */
      --sky: #0284c7;
      /* Typography */
      --mono: 'JetBrains Mono', monospace;
      --sans: 'Sarabun', sans-serif;
      /* Topbar + navbar heights */
      --nav-h:  40px;
      --top-h:  36px;
    }

    /* ═══════════════════════════════════════════
       RESET & BASE
    ═══════════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; }

    html, body {
      margin: 0; padding: 0;
      height: 100%;
      overflow: hidden;
      background: var(--base);
      color: var(--t0);
      font-family: var(--sans);
      font-size: 13px;
      -webkit-font-smoothing: antialiased;
    }

    /* ═══════════════════════════════════════════
       APP SHELL — Critical layout
    ═══════════════════════════════════════════ */
    #app {
      display: flex;
      flex-direction: column;
      height: calc(100vh - var(--nav-h));
      overflow: hidden;
    }

    /* ── TOPBAR ── */
    #topbar {
      height: var(--top-h);
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 10px;
      background: var(--panel);
      border-bottom: 1px solid var(--b0);
      gap: 4px;
    }

    .tp-l, .tp-r {
      display: flex;
      align-items: center;
      gap: 5px;
      flex-shrink: 0;
    }
    .tp-r { margin-left: auto; }

    .tp-brand {
      font-size: 11px;
      font-family: var(--mono);
      font-weight: 700;
      color: var(--t0);
      letter-spacing: .05em;
      margin-right: 6px;
      white-space: nowrap;
    }

    .tp-m {
      background: none;
      border: none;
      color: var(--t2);
      font-size: 10px;
      font-family: var(--sans);
      cursor: pointer;
      padding: 3px 6px;
      border-radius: 3px;
      transition: background .1s, color .1s;
      white-space: nowrap;
    }
    .tp-m:hover { background: var(--hover); color: var(--t1); }

    .tab-strip {
      display: flex;
      gap: 2px;
      margin-left: 6px;
    }

    .tab-btn {
      padding: 3px 9px;
      font-size: 9px;
      font-family: var(--mono);
      font-weight: 700;
      letter-spacing: .06em;
      background: var(--card);
      border: 1px solid var(--b0);
      color: var(--t2);
      border-radius: 3px;
      cursor: pointer;
      transition: all .12s;
      white-space: nowrap;
    }
    .tab-btn:hover  { background: var(--hover); color: var(--t1); border-color: var(--b1); }
    .tab-btn.active { background: var(--act); color: var(--B); border-color: var(--Bb); }

    /* API pill */
    .ap {
      font-size: 9px;
      font-family: var(--mono);
      font-weight: 600;
      padding: 2px 8px;
      border-radius: 3px;
      white-space: nowrap;
    }
    .ap.ok      { background: var(--Gd); color: var(--G); border: 1px solid var(--Gb); }
    .ap.fail    { background: var(--Rd); color: var(--R); border: 1px solid var(--Rb); }
    .ap.loading { background: var(--Ad); color: var(--A); border: 1px solid var(--Ab); }

    /* Live dot */
    .live-p { display: flex; align-items: center; gap: 4px; }
    .live-d  {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--G);
      animation: livePulse 1.8s ease-in-out infinite;
    }
    .live-t  { font-size: 9px; font-family: var(--mono); color: var(--G); letter-spacing: .08em; }

    @keyframes livePulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.85)} }

    #clk {
      font-size: 11px;
      font-family: var(--mono);
      color: var(--t1);
      letter-spacing: .04em;
      min-width: 72px;
      text-align: right;
    }

    /* ── BODY (3-column) ── */
    #body {
      display: flex;
      flex-direction: row;
      flex: 1;
      min-height: 0;       /* CRITICAL */
      overflow: hidden;
    }

    /* ═══════════════════════════════════════════
       LEFT — Market Watch
    ═══════════════════════════════════════════ */
    #sl {
      width: 200px;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      background: var(--panel);
      border-right: 1px solid var(--b0);
      overflow: hidden;
    }

    .s-hdr {
      flex-shrink: 0;
      padding: 7px 11px;
      font-size: 8px;
      font-weight: 700;
      letter-spacing: .15em;
      text-transform: uppercase;
      color: var(--t2);
      border-bottom: 1px solid var(--b0);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .s-badge {
      font-size: 8px;
      font-family: var(--mono);
      background: var(--Bd);
      color: var(--B);
      border: 1px solid var(--Bb);
      border-radius: 3px;
      padding: 1px 5px;
    }

    #mwList { flex: 1; overflow-y: auto; }
    #mwList::-webkit-scrollbar { width: 3px; }
    #mwList::-webkit-scrollbar-track { background: transparent; }
    #mwList::-webkit-scrollbar-thumb { background: var(--b1); border-radius: 2px; }

    .cat-hdr {
      padding: 4px 11px;
      font-size: 7px;
      letter-spacing: .14em;
      text-transform: uppercase;
      color: var(--t2);
      background: rgba(255,255,255,.015);
      border-bottom: 1px solid var(--b0);
    }

    .mw-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 11px;
      cursor: pointer;
      border-bottom: 1px solid var(--b0);
      position: relative;
      transition: background .1s;
    }
    .mw-row:hover { background: var(--hover); }
    .mw-row.sel   { background: var(--act); }
    .mw-row.sel::before {
      content: '';
      position: absolute;
      left: 0; top: 0; bottom: 0;
      width: 2px;
      background: var(--sky);
      box-shadow: 0 0 8px rgba(2,132,199,.6);
    }

    .mw-sym { font-size: 10px; font-family: var(--mono); font-weight: 600; color: var(--t0); }
    .mw-sub { font-size: 7px; color: var(--t2); margin-top: 1px; }
    .mw-r   { text-align: right; }
    .mw-px  { font-size: 10px; font-family: var(--mono); color: var(--t0); }
    .mw-ch  { font-size: 8px;  font-family: var(--mono); margin-top: 1px; }
    .cu { color: var(--G); }
    .cd { color: var(--R); }

    /* Navigator */
    .nav-sec {
      border-top: 1px solid var(--b0);
      padding: 7px;
      flex-shrink: 0;
    }
    .nav-it {
      padding: 5px 8px;
      font-size: 11px;
      color: var(--t2);
      border-radius: 3px;
      cursor: pointer;
      transition: all .1s;
      font-weight: 500;
    }
    .nav-it:hover { background: var(--hover); color: var(--t1); }
    .nav-it.on    { background: var(--act); color: var(--t0); }
    .nav-it.on::before { content: '▸ '; color: var(--sky); font-size: 9px; }

    /* ═══════════════════════════════════════════
       CENTER — Chart
    ═══════════════════════════════════════════ */
    #cc {
      flex: 1;
      min-width: 0;
      display: flex;
      flex-direction: column;
      background: var(--base);
      overflow: hidden;
    }

    #alertBox { flex-shrink: 0; }
    .a-ok {
      display: flex; gap: 8px; align-items: center;
      background: var(--Gd); border: 1px solid var(--Gb); color: var(--G);
      padding: 6px 12px; font-size: 11px; margin: 5px 10px; border-radius: 6px;
      animation: fadeIn .2s ease;
    }
    .a-err {
      display: flex; gap: 8px; align-items: center;
      background: var(--Rd); border: 1px solid var(--Rb); color: var(--R);
      padding: 6px 12px; font-size: 11px; margin: 5px 10px; border-radius: 6px;
      animation: fadeIn .2s ease;
    }
    @keyframes fadeIn { from{opacity:0;transform:translateY(-4px)} to{opacity:1;transform:none} }

    /* Chart toolbar */
    .chart-bar {
      flex-shrink: 0;
      display: flex;
      align-items: center;
      gap: 7px;
      padding: 5px 10px;
      background: var(--panel);
      border-bottom: 1px solid var(--b0);
    }

    #cSym {
      background: var(--card);
      color: var(--t0);
      border: 1px solid var(--b1);
      padding: 4px 9px;
      border-radius: 3px;
      font-size: 11px;
      font-family: var(--mono);
      outline: none;
      cursor: pointer;
      transition: border-color .15s;
    }
    #cSym:focus { border-color: var(--sky); }
    #cSym option { background: var(--panel); }

    .vsep { width: 1px; height: 16px; background: var(--b1); flex-shrink: 0; }

    .tf-grp, .ct-grp { display: flex; gap: 2px; }
    .ct-grp { margin-left: auto; }

    .tf-btn {
      padding: 3px 8px;
      font-size: 9px;
      font-family: var(--mono);
      font-weight: 600;
      letter-spacing: .05em;
      background: none;
      border: 1px solid var(--b0);
      color: var(--t2);
      border-radius: 3px;
      cursor: pointer;
      transition: all .12s;
    }
    .tf-btn:hover { background: var(--hover); color: var(--t1); border-color: var(--b1); }
    .tf-btn.on    { background: var(--act);   color: var(--t0); border-color: var(--b2); }

    /* Chart wrapper — fills remaining height */
    #cWrap {
      flex: 1;
      min-height: 0;
      position: relative;
      overflow: hidden;
    }
    #cWrap canvas {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      width: 100% !important;
      height: 100% !important;
      display: block;
    }

    /* Overlay card */
    .c-ov {
      position: absolute;
      top: 10px; left: 10px;
      pointer-events: none;
      background: rgba(7,10,16,.92);
      backdrop-filter: blur(8px);
      border: 1px solid var(--b2);
      border-radius: 10px;
      padding: 10px 14px;
      font-family: var(--mono);
      min-width: 150px;
      z-index: 2;
    }
    .ov-sym  { font-size: 12px; font-weight: 700; margin-bottom: 8px; color: var(--t0); }
    .ov-row  { display: flex; justify-content: space-between; gap: 14px; font-size: 10px; margin-bottom: 3px; }
    .ov-lbl  { color: var(--t2); font-size: 9px; }
    .ov-val  { color: var(--t0); font-weight: 600; }
    .ov-sprd { color: var(--A);  font-weight: 600; }
    .ov-div  { height: 1px; background: var(--b1); margin: 6px 0; }

    /* Price markers */
    .c-pm {
      position: absolute;
      right: 10px; top: 10px;
      display: flex; flex-direction: column; gap: 4px;
      pointer-events: none;
      z-index: 2;
    }
    .pm-tag {
      font-size: 9px; font-family: var(--mono); font-weight: 700;
      padding: 2px 8px; border-radius: 3px;
    }
    .pm-buy  { background: var(--Gd); color: var(--G); border: 1px solid var(--Gb); }
    .pm-sell { background: var(--Rd); color: var(--R); border: 1px solid var(--Rb); }

    /* Status bar */
    .c-status {
      flex-shrink: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 3px 10px;
      background: var(--panel);
      border-top: 1px solid var(--b0);
    }
    .cs-it {
      font-size: 9px; font-family: var(--mono); color: var(--t2);
      display: flex; align-items: center; gap: 4px;
    }
    .cs-dot {
      width: 5px; height: 5px; border-radius: 50%; background: var(--G);
      animation: livePulse 1.8s ease-in-out infinite;
    }

    /* ═══════════════════════════════════════════
       RIGHT — Panels
    ═══════════════════════════════════════════ */
    #sr {
      width: 258px;
      flex-shrink: 0;
      background: var(--panel);
      border-left: 1px solid var(--b0);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }
    #sr.collapsed { display: none !important; }

    .rpanel { flex: 1; min-height: 0; overflow-y: auto; display: none; flex-direction: column; }
    .rpanel.show  { display: flex; }
    .rpanel::-webkit-scrollbar { width: 3px; }
    .rpanel::-webkit-scrollbar-thumb { background: var(--b1); border-radius: 2px; }

    /* ── TRADE PANEL ── */
    .trade-hdr {
      padding: 10px 12px 10px;
      border-bottom: 1px solid var(--b0);
      flex-shrink: 0;
    }

    .mode-row { display: flex; gap: 5px; margin-bottom: 10px; }
    .mode-pill {
      flex: 1; padding: 6px; text-align: center; border-radius: 7px;
      font-size: 10px; font-family: var(--mono); font-weight: 700;
      cursor: pointer; border: 1px solid var(--b0); color: var(--t2);
      background: var(--card); transition: all .15s;
    }
    .mode-pill.demo.on { background: var(--Bd); border-color: var(--Bb); color: var(--B); }
    .mode-pill.real.on { background: var(--Gd); border-color: var(--Gb); color: var(--G); }

    .f-row { display: flex; gap: 5px; margin-bottom: 8px; }
    .f-g   { flex: 1; }
    .f-lbl {
      display: block; font-size: 8px; font-weight: 700;
      letter-spacing: .12em; text-transform: uppercase; color: var(--t2); margin-bottom: 3px;
    }
    .f-inp {
      width: 100%; background: var(--card); border: 1px solid var(--b1);
      color: var(--t0); padding: 7px 9px; border-radius: 4px;
      font-size: 11px; font-family: var(--mono); outline: none;
      transition: border-color .15s;
    }
    .f-inp:focus {
      border-color: var(--sky);
      box-shadow: 0 0 0 3px rgba(2,132,199,.1);
    }
    .f-inp::placeholder { color: var(--t2); }

    .dur-grid {
      display: grid; grid-template-columns: repeat(4, 1fr); gap: 3px; margin-bottom: 11px;
    }
    .dur-pill {
      padding: 5px 2px; text-align: center; border-radius: 3px;
      font-size: 9px; font-family: var(--mono); font-weight: 600;
      cursor: pointer; border: 1px solid var(--b0); color: var(--t2);
      background: var(--card); transition: all .12s;
    }
    .dur-pill:hover { border-color: var(--b1); color: var(--t1); }
    .dur-pill.on    { background: var(--act); color: var(--t0); border-color: var(--b2); }

    .bs-row { display: grid; grid-template-columns: 1fr 1fr; gap: 7px; }

    .buy-btn, .sell-btn {
      padding: 13px 6px 11px; border: none; border-radius: 10px;
      cursor: pointer; font-family: var(--mono);
      display: flex; flex-direction: column; align-items: center; gap: 2px;
      transition: all .15s; width: 100%;
    }
    .buy-btn {
      background: linear-gradient(160deg, rgba(16,185,129,.22), rgba(16,185,129,.10));
      border: 1px solid var(--Gb); color: var(--G);
    }
    .sell-btn {
      background: linear-gradient(160deg, rgba(244,63,94,.22), rgba(244,63,94,.10));
      border: 1px solid var(--Rb); color: var(--R);
    }
    .buy-btn:hover  { background: rgba(16,185,129,.30); box-shadow: 0 4px 20px rgba(16,185,129,.2); transform: translateY(-1px); }
    .sell-btn:hover { background: rgba(244,63,94,.30);  box-shadow: 0 4px 20px rgba(244,63,94,.2);  transform: translateY(-1px); }
    .buy-btn:active, .sell-btn:active { transform: none; }

    .btn-arr { font-size: 20px; line-height: 1; }
    .btn-dir { font-size: 14px; font-weight: 700; }
    .btn-px  { font-size: 9px; opacity: .65; margin-top: 1px; }

    /* Open positions */
    .pos-sec {
      border-top: 1px solid var(--b0);
      display: flex; flex-direction: column;
      flex: 1; min-height: 0; overflow-y: auto;
    }
    .pos-it {
      padding: 9px 12px; border-bottom: 1px solid var(--b0);
      transition: background .1s;
    }
    .pos-it:hover { background: var(--hover); }
    .pos-hd { display: flex; justify-content: space-between; align-items: center; margin-bottom: 3px; }
    .pos-sym { font-size: 11px; font-family: var(--mono); font-weight: 700; }
    .pos-badge {
      font-size: 8px; font-family: var(--mono); font-weight: 700;
      padding: 1px 6px; border-radius: 3px;
      background: var(--Ad); color: var(--A); border: 1px solid var(--Ab);
    }
    .pos-dir {
      font-size: 9px; font-family: var(--mono); font-weight: 700;
      padding: 1px 6px; border-radius: 3px;
    }
    .pos-dir.buy  { background: var(--Gd); color: var(--G); }
    .pos-dir.sell { background: var(--Rd); color: var(--R); }
    .pos-meta {
      font-size: 9px; color: var(--t2); font-family: var(--mono);
      margin-top: 2px; display: flex; gap: 7px; flex-wrap: wrap;
    }
    .pos-pnl  { font-size: 10px; font-family: var(--mono); font-weight: 700; margin-top: 2px; }
    .pos-timer { font-size: 10px; font-family: var(--mono); color: var(--A); font-weight: 600; margin-top: 2px; }
    .pos-bw { height: 3px; background: var(--b0); border-radius: 2px; margin-top: 5px; overflow: hidden; }
    .pos-b  { height: 100%; border-radius: 2px; transition: width .5s linear; }

    /* QUOTES PANEL */
    .q-row {
      display: flex; justify-content: space-between; align-items: center;
      padding: 9px 12px; border-bottom: 1px solid var(--b0);
      cursor: pointer; transition: background .1s;
    }
    .q-row:hover { background: var(--hover); }
    .q-sym { font-size: 11px; font-family: var(--mono); font-weight: 600; }
    .q-sub { font-size: 8px; color: var(--t2); margin-top: 1px; }
    .q-px  { font-size: 11px; font-family: var(--mono); font-weight: 600; text-align: right; }
    .q-ch  { font-size: 8px;  font-family: var(--mono); text-align: right; margin-top: 1px; }

    /* HISTORY PANEL */
    .h-row {
      display: flex; justify-content: space-between; align-items: center;
      padding: 9px 12px; border-bottom: 1px solid var(--b0);
    }
    .h-sym  { font-size: 11px; font-family: var(--mono); font-weight: 600; }
    .h-meta { font-size: 8px; color: var(--t2); font-family: var(--mono); margin-top: 2px; }
    .h-res  {
      font-size: 8px; font-family: var(--mono); font-weight: 700;
      padding: 1px 6px; border-radius: 3px; display: inline-block; margin-bottom: 2px;
    }
    .h-res.win  { background: var(--Gd); color: var(--G); border: 1px solid var(--Gb); }
    .h-res.loss { background: var(--Rd); color: var(--R); border: 1px solid var(--Rb); }
    .h-pnl { font-size: 11px; font-family: var(--mono); font-weight: 700; text-align: right; }

    /* GRAPH PANEL */
    .g-pad   { padding: 10px; display: flex; flex-direction: column; gap: 8px; }
    .g-cnv   { height: 160px; position: relative; }
    .g-ctrl  { display: flex; gap: 4px; }
    .g-btn {
      flex: 1; padding: 5px; font-size: 9px; font-family: var(--mono); font-weight: 600;
      background: var(--card); border: 1px solid var(--b0); color: var(--t2);
      border-radius: 3px; cursor: pointer; transition: all .12s;
    }
    .g-btn:hover { background: var(--hover); color: var(--t1); }
    .g-btn.on    { background: var(--Bd); border-color: var(--Bb); color: var(--B); }
    .g-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 5px; }
    .g-card  { background: var(--card); border: 1px solid var(--b0); border-radius: 4px; padding: 8px 10px; }
    .g-lbl   { font-size: 8px; color: var(--t2); font-family: var(--mono); margin-bottom: 3px; }
    .g-val   { font-size: 13px; font-family: var(--mono); font-weight: 700; }

    /* ACCOUNT FOOTER */
    .acct-footer {
      flex-shrink: 0;
      border-top: 1px solid var(--b0);
      padding: 9px 10px;
    }
    .acct-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5px; margin-top: 6px; }
    .acct-card {
      background: var(--card); border: 1px solid var(--b0); border-radius: 6px; padding: 7px 10px;
    }
    .acct-lbl { font-size: 8px; color: var(--t2); font-family: var(--mono); margin-bottom: 2px; }
    .acct-val { font-size: 11px; font-family: var(--mono); font-weight: 600; color: var(--t0); }
    .acct-val.g { color: var(--G); }
    .acct-val.r { color: var(--R); }

    /* EMPTY STATE */
    .empty {
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      gap: 8px; padding: 28px 14px; color: var(--t2); font-size: 10px;
      text-align: center; font-family: var(--mono);
    }
    .empty-ico { font-size: 22px; opacity: .3; }

    /* ═══════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════ */
    @media (max-width: 900px) {
      #body { flex-direction: column; }
      #sl, #sr {
        width: 100%; min-width: 0; max-width: 100vw;
        border: none; border-bottom: 1px solid var(--b0);
        flex-shrink: 0;
      }
      #sl { order: 1; max-height: 220px; }
      #cc { order: 2; min-height: 260px; height: 350px; }
      #sr { order: 3; border-top: 1px solid var(--b0); max-height: 380px; }
      .chart-bar, .c-status { flex-wrap: wrap; gap: 4px; }
    }

    @media (max-width: 600px) {
      :root { --nav-h: 56px; --top-h: 44px; }
      #topbar { flex-wrap: wrap; height: auto; padding: 5px 7px; gap: 5px; }
      .tp-l, .tp-r { flex-wrap: wrap; }
      .tab-strip { flex-wrap: wrap; }
      #cc { min-height: 200px; height: 260px; }
      .dur-grid { grid-template-columns: repeat(2, 1fr); }
      .bs-row { grid-template-columns: 1fr; }
      .acct-grid { grid-template-columns: 1fr; }
      .g-stats { grid-template-columns: 1fr; }
      .buy-btn, .sell-btn { padding: 16px 10px; border-radius: 12px; }
      .btn-arr { font-size: 22px; }
      .btn-dir { font-size: 16px; }

      /* Mobile floating action bar */
      .mobile-action-bar {
        display: flex !important;
        position: fixed; left: 12px; right: 12px; bottom: 12px;
        gap: 8px; z-index: 60;
      }
      .mobile-action-bar button {
        flex: 1; padding: 14px 10px; border-radius: 12px;
        font-size: 16px; font-weight: 800;
      }
    }

    /* Hide mobile bar on desktop */
    .mobile-action-bar { display: none; }

    /* ═══════════════════════════════════════════
       SCROLLBAR (global)
    ═══════════════════════════════════════════ */
    ::-webkit-scrollbar       { width: 4px; height: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--b1); border-radius: 2px; }

    /* ═══════════════════════════════════════════
       UTILITIES
    ═══════════════════════════════════════════ */
    input[type=number]::-webkit-inner-spin-button { opacity: .4; }
  </style>
</head>

<body>

  <!-- ══════════ NAVBAR (เหมือนกับหน้าอื่นทุกประการ) ══════════ -->
  <?php include __DIR__ . '/../partials/user_navbar.php'; ?>

  <div id="app">

    <!-- ══════════ TOPBAR (terminal strip) ══════════ -->
    <div id="topbar">
      <div class="tp-l">
        <span class="tp-brand">ST Terminal</span>
        <button class="tp-m">File</button><button class="tp-m">View</button>
        <button class="tp-m">Tools</button><button class="tp-m">Window</button><button class="tp-m">Help</button>
        <div class="tab-strip">
          <button class="tab-btn qt" onclick="showPanel('quotes')">Quotes</button>
          <button class="tab-btn bs" onclick="showPanel('trade')">Buy/Sell</button>
          <button class="tab-btn hs" onclick="showPanel('history')">History</button>
          <button class="tab-btn gr" onclick="showPanel('graph')">P&L Graph</button>
        </div>
      </div>
      <div class="tp-r">
        <span class="ap loading" id="apiPill">⟳ CONNECTING</span>
        <div class="live-p">
          <div class="live-d"></div><span class="live-t">LIVE</span>
        </div>
        <span id="clk"></span>
        <span style="font-size:9px;color:var(--t2);margin-left:8px">🇹🇭 Bangkok</span>
        <span id="currentDate" style="font-size:9px;color:var(--t2);margin-left:8px"></span>
        <button id="togglePanelBtn" title="Toggle panels" class="tp-m" style="margin-left:8px">☰</button>
      </div>
    </div>

    <!-- ══════════ BODY ══════════ -->
    <div id="body">

      <!-- LEFT: Market Watch -->
      <div id="sl">
        <div class="s-hdr">Market Watch <span class="s-badge" id="pairCnt">0</span></div>
        <div id="mwList"></div>
        <div class="nav-sec">
          <div class="s-hdr" style="padding:0 2px 5px;border:none">Navigator</div>
          <div class="nav-it on" onclick="setNavMode('demo',this)">Demo Account</div>
          <div class="nav-it" onclick="setNavMode('real',this)">Real Account</div>
        </div>
      </div>

      <!-- CENTER: Chart -->
      <div id="cc">
        <div id="alertBox"></div>
        <div class="chart-bar">
          <select id="cSym" onchange="selectSym(this.value)"></select>
          <div class="vsep"></div>
          <div class="tf-grp" id="tfGrp">
            <button class="tf-btn on" data-tf="M1">M1</button>
            <button class="tf-btn" data-tf="M5">M5</button>
            <button class="tf-btn" data-tf="M15">M15</button>
            <button class="tf-btn" data-tf="H1">H1</button>
            <button class="tf-btn" data-tf="D1">D1</button>
          </div>
          <div class="vsep"></div>
          <div class="ct-grp" id="ctGrp">
            <button class="tf-btn" data-ct="bar">Bar</button>
            <button class="tf-btn on" data-ct="line">Line</button>
            <button class="tf-btn" data-ct="area">Area</button>
          </div>
        </div>

        <!-- wrapper: flex:1 + min-height:0 = canvas fills all remaining space -->
        <div id="cWrap">
          <canvas id="pChart"></canvas>
          <div class="c-ov">
            <div class="ov-sym" id="ovSym">—</div>
            <div class="ov-row"><span class="ov-lbl">BID</span><span class="ov-val" id="ovBid">—</span></div>
            <div class="ov-row"><span class="ov-lbl">ASK</span><span class="ov-val" id="ovAsk">—</span></div>
            <div class="ov-div"></div>
            <div class="ov-row"><span class="ov-lbl">SPREAD</span><span class="ov-sprd" id="ovSpread">—</span></div>
            <div class="ov-row"><span class="ov-lbl">CHG</span><span class="ov-val" id="ovChg">—</span></div>
          </div>
          <div class="c-pm" id="cPM"></div>
        </div>

        <div class="c-status">
          <div class="cs-it">
            <div class="cs-dot"></div>Real-time
          </div>
          <div class="cs-it" id="csUpd">Updated: —</div>
          <div class="cs-it" id="csAcct">Demo</div>
          <div class="cs-it" id="csBal">฿—</div>
        </div>
      </div>

      <!-- RIGHT: Panels -->
      <div id="sr">

        <!-- TRADE PANEL -->
        <div id="panel-trade" class="rpanel show">
          <div class="trade-hdr">
            <div class="s-hdr" style="padding:0 0 7px;border:none">Quick Trade</div>
            <div class="mode-row">
              <div class="mode-pill demo <?= $tradeMode === 'demo' ? 'on' : '' ?>" onclick="setMode('demo',this)">DEMO</div>
              <div class="mode-pill real <?= $tradeMode === 'real' ? 'on' : '' ?>" onclick="setMode('real',this)">REAL</div>
            </div>
            <label class="f-lbl">Volume (฿)</label>
            <input id="amt" type="number" class="f-inp" min="10" step="1" value="100" style="margin-bottom:7px">
            <div class="f-row">
              <div class="f-g"><label class="f-lbl">Stop Loss</label><input type="number" step="0.00001" class="f-inp" placeholder="0.00000"></div>
              <div class="f-g"><label class="f-lbl">Take Profit</label><input type="number" step="0.00001" class="f-inp" placeholder="0.00000"></div>
            </div>
            <label class="f-lbl" style="margin-bottom:4px">Duration</label>
            <div class="dur-grid">
              <div class="dur-pill on" onclick="setDur(30,this)">30s</div>
              <div class="dur-pill" onclick="setDur(60,this)">1m</div>
              <div class="dur-pill" onclick="setDur(120,this)">2m</div>
              <div class="dur-pill" onclick="setDur(300,this)">5m</div>
              <div class="dur-pill" onclick="setDur(600,this)">10m</div>
              <div class="dur-pill" onclick="setDur(900,this)">15m</div>
              <div class="dur-pill" onclick="setDur(1800,this)">30m</div>
              <div class="dur-pill" onclick="setDur(3600,this)">1h</div>
            </div>
            <div class="bs-row">
              <button class="buy-btn" onclick="doTrade('buy')"><span class="btn-arr">↑</span><span class="btn-dir">BUY</span><span class="btn-px" id="buyPx">—</span></button>
              <button class="sell-btn" onclick="doTrade('sell')"><span class="btn-arr">↓</span><span class="btn-dir">SELL</span><span class="btn-px" id="sellPx">—</span></button>
            </div>
          </div>
          <div class="pos-sec">
            <div class="s-hdr">Open Positions <span class="s-badge" id="posBadge">0</span></div>
            <div id="posList">
              <div class="empty">
                <div class="empty-ico">◎</div>No open positions
              </div>
            </div>
          </div>
        </div>

        <!-- QUOTES PANEL -->
        <div id="panel-quotes" class="rpanel">
          <div class="s-hdr">Live Quotes</div>
          <div id="qList"></div>
        </div>

        <!-- HISTORY PANEL -->
        <div id="panel-history" class="rpanel">
          <div class="s-hdr">Trade History</div>
          <div id="hList">
            <?php
            if (isset($currentUser)) {
              $hist = Trade::getByUser($currentUser->id, 100);
              $any  = false;
              foreach ($hist as $t) {
                if ($t->result === 'pending') continue;
                $any = true;
                $w   = $t->result === 'win';
                $pnl = $t->profit_loss ?? 0;
                echo '<div class="h-row"><div>';
                echo '<div class="h-sym">' . htmlspecialchars($t->symbol) . '</div>';
                echo '<div class="h-meta">' . ($t->direction === 'up' ? 'BUY' : 'SELL') . ' · ' . date('d/m H:i', strtotime($t->created_at)) . '</div>';
                echo '</div><div>';
                echo '<div class="h-res ' . ($w ? 'win' : 'loss') . '">' . strtoupper($t->result) . '</div>';
                echo '<div class="h-pnl ' . ($pnl >= 0 ? 'cu' : 'cd') . '">' . ($pnl >= 0 ? '+' : '') . number_format($pnl, 2) . '฿</div>';
                echo '</div></div>';
              }
              if (!$any) echo '<div class="empty"><div class="empty-ico">◎</div>No history yet</div>';
            }
            ?>
          </div>
        </div>

        <!-- GRAPH PANEL -->
        <div id="panel-graph" class="rpanel">
          <div class="s-hdr">P&L Overview</div>
          <div class="g-pad">
            <div class="g-cnv"><canvas id="gChart"></canvas></div>
            <div class="g-ctrl">
              <button class="g-btn" onclick="setGT('bar',this)">Bar</button>
              <button class="g-btn on" onclick="setGT('line',this)">Line</button>
            </div>
            <div class="g-stats">
              <div class="g-card">
                <div class="g-lbl">Total Trades</div>
                <div class="g-val" id="gTot"><?= $trade_stats->total_trades ?? '0' ?></div>
              </div>
              <div class="g-card">
                <div class="g-lbl">Win Rate</div>
                <div class="g-val cu" id="gWR"><?php $winRate = ($trade_stats->total_trades > 0) ? ($trade_stats->wins / $trade_stats->total_trades) * 100 : 0;
                                                echo number_format($winRate, 1) . '%'; ?></div>
              </div>
              <div class="g-card">
                <div class="g-lbl">Total P&L</div>
                <div class="g-val" id="gPNL"><?php $pp = $trade_stats->total_profit_loss ?? 0;
                                              echo ($pp >= 0 ? '+' : '') . number_format($pp, 2) . '฿' ?></div>
              </div>
              <div class="g-card">
                <div class="g-lbl">Best Trade</div>
                <div class="g-val cu">+<?= number_format($trade_stats->avg_win ?? 0, 2) ?>฿</div>
              </div>
            </div>
          </div>
        </div>

        <!-- ACCOUNT FOOTER -->
        <div class="acct-footer">
          <div class="s-hdr" style="padding:0 0 6px;border:none">Account</div>
          <div class="acct-grid">
            <div class="acct-card">
              <div class="acct-lbl">Balance</div>
              <div class="acct-val" id="acBal">฿—</div>
            </div>
            <div class="acct-card">
              <div class="acct-lbl">Equity</div>
              <div class="acct-val g" id="acEq">฿—</div>
            </div>
            <div class="acct-card">
              <div class="acct-lbl">Open P&L</div>
              <div class="acct-val" id="acOPnl">฿0.00</div>
            </div>
            <div class="acct-card">
              <div class="acct-lbl">Mode</div>
              <div class="acct-val" id="acMode"><?= strtoupper($tradeMode) ?></div>
            </div>
          </div>
        </div>

      </div><!-- /sr -->
    </div><!-- /body -->
  </div><!-- /app -->

  <script>
    /* ═══════════════════════════════════════════════
   DATA
═══════════════════════════════════════════════ */
    const PAIRS = [{
        s: 'EUR/USD',
        cat: 'Major',
        d: 5,
        sp: 0.00010,
        id: 1
      },
      {
        s: 'GBP/USD',
        cat: 'Major',
        d: 5,
        sp: 0.00012,
        id: 2
      },
      {
        s: 'USD/JPY',
        cat: 'Major',
        d: 3,
        sp: 0.010,
        id: 3
      },
      {
        s: 'USD/CHF',
        cat: 'Major',
        d: 5,
        sp: 0.00011,
        id: 4
      },
      {
        s: 'USD/CAD',
        cat: 'Major',
        d: 5,
        sp: 0.00013,
        id: 5
      },
      {
        s: 'AUD/USD',
        cat: 'Major',
        d: 5,
        sp: 0.00012,
        id: 6
      },
      {
        s: 'NZD/USD',
        cat: 'Major',
        d: 5,
        sp: 0.00014,
        id: 7
      },
      {
        s: 'EUR/GBP',
        cat: 'Minor',
        d: 5,
        sp: 0.00009,
        id: 8
      },
      {
        s: 'EUR/JPY',
        cat: 'Minor',
        d: 3,
        sp: 0.012,
        id: 9
      },
      {
        s: 'GBP/JPY',
        cat: 'Minor',
        d: 3,
        sp: 0.014,
        id: 10
      },
      {
        s: 'AUD/JPY',
        cat: 'Minor',
        d: 3,
        sp: 0.013,
        id: 11
      },
      {
        s: 'EUR/AUD',
        cat: 'Minor',
        d: 5,
        sp: 0.00016,
        id: 12
      },
      {
        s: 'GBP/AUD',
        cat: 'Minor',
        d: 5,
        sp: 0.00018,
        id: 13
      },
      {
        s: 'EUR/CAD',
        cat: 'Minor',
        d: 5,
        sp: 0.00015,
        id: 14
      },
      {
        s: 'USD/THB',
        cat: 'Exotic',
        d: 3,
        sp: 0.100,
        id: 15
      },
      {
        s: 'USD/SGD',
        cat: 'Exotic',
        d: 5,
        sp: 0.00020,
        id: 16
      },
      {
        s: 'USD/MXN',
        cat: 'Exotic',
        d: 4,
        sp: 0.003,
        id: 17
      },
      {
        s: 'USD/HKD',
        cat: 'Exotic',
        d: 5,
        sp: 0.00030,
        id: 18
      },
      {
        s: 'XAU/USD',
        cat: 'Metal',
        d: 2,
        sp: 0.30,
        id: 19
      },
      {
        s: 'XAG/USD',
        cat: 'Metal',
        d: 3,
        sp: 0.05,
        id: 20
      },
    ];
    const SEED = {
      'EUR/USD': 1.0850,
      'GBP/USD': 1.2740,
      'USD/JPY': 157.50,
      'USD/CHF': 0.8980,
      'USD/CAD': 1.3620,
      'AUD/USD': 0.6560,
      'NZD/USD': 0.6030,
      'EUR/GBP': 0.8520,
      'EUR/JPY': 170.90,
      'GBP/JPY': 200.80,
      'AUD/JPY': 103.30,
      'EUR/AUD': 1.6540,
      'GBP/AUD': 1.9420,
      'EUR/CAD': 1.4780,
      'USD/THB': 36.20,
      'USD/SGD': 1.3480,
      'USD/MXN': 18.45,
      'USD/HKD': 7.820,
      'XAU/USD': 3320.0,
      'XAG/USD': 33.50,
    };

    /* ═══════ STATE ═══════ */
    const px = {},
      hist = {};
    let selSym = 'EUR/USD',
      ctType = 'line',
      dur = 30,
      mode = '<?= $tradeMode ?>';
    let balD = <?= $balDemo ?>,
      balR = <?= $balReal ?>;
    let positions = [],
      closed = [],
      idSeq = 1;
    let PC = null,
      GC = null;
    let realTimeData = null; // Store real API data
    let lastFetchTime = 0;

    // Thailand timezone
    const THAI_TIMEZONE = 'Asia/Bangkok';

    const gp = s => PAIRS.find(p => p.s === s);
    const getBal = () => mode === 'demo' ? balD : balR;
    const setBal = v => {
      if (mode === 'demo') balD = v;
      else balR = v;
    };

    // Get current time in Thai timezone
    function getThaiTime() {
      return new Date().toLocaleTimeString('th-TH', {
        timeZone: THAI_TIMEZONE,
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
    }

    // Get current date in Thai timezone
    function getThaiDate() {
      return new Date().toLocaleDateString('th-TH', {
        timeZone: THAI_TIMEZONE,
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    }

    /* ═══════ SEED 80 BARS ═══════ */
    function seedHistory() {
      PAIRS.forEach(p => {
        const base = SEED[p.s] || 1;
        const arr = [];
        let cur = base;
        for (let i = 0; i < 80; i++) {
          const vol = p.cat === 'Metal' ? .0007 : p.cat === 'Exotic' ? .0003 : .00014;
          cur = parseFloat((cur + cur * (Math.random() - .499) * vol).toFixed(p.d));
          arr.push(cur);
        }
        hist[p.s] = arr;
        px[p.s] = arr[arr.length - 1];
      });
      console.log('History seeded for', PAIRS.length, 'pairs');
      console.log('Sample data for EUR/USD:', hist['EUR/USD']?.slice(0, 5));
    }

    /* ═══════ TICK ═══════ */
    function tick() {
      PAIRS.forEach(p => {
        const vol = p.cat === 'Metal' ? .0007 : p.cat === 'Exotic' ? .0003 : .00014;

        // Use real API data when available, otherwise simulate
        if (realTimeData && realTimeData.rates) {
          // Try to get real price from API data
          const realPrice = getRealPrice(p.s);
          if (realPrice) {
            px[p.s] = parseFloat((realPrice + realPrice * (Math.random() - 0.5) * vol * 0.5).toFixed(p.d));
          } else {
            px[p.s] = parseFloat((px[p.s] + px[p.s] * (Math.random() - 0.5) * vol).toFixed(p.d));
          }
        } else {
          // Fallback to simulation when no real data
          px[p.s] = parseFloat((px[p.s] + px[p.s] * (Math.random() - 0.5) * vol).toFixed(p.d));
        }

        hist[p.s].push(px[p.s]);
        if (hist[p.s].length > 120) hist[p.s].shift();
      });
    }

    // Get real price from API data
    function getRealPrice(symbol) {
      if (!realTimeData || !realTimeData.rates) return null;

      const rates = realTimeData.rates;
      const base = realTimeData.base || 'USD';

      // Map symbols to API rates
      const rateMap = {
        'EUR/USD': {
          from: 'EUR',
          to: 'USD'
        },
        'GBP/USD': {
          from: 'GBP',
          to: 'USD'
        },
        'USD/JPY': {
          from: 'USD',
          to: 'JPY'
        },
        'USD/CHF': {
          from: 'USD',
          to: 'CHF'
        },
        'USD/CAD': {
          from: 'USD',
          to: 'CAD'
        },
        'AUD/USD': {
          from: 'AUD',
          to: 'USD'
        },
        'NZD/USD': {
          from: 'NZD',
          to: 'USD'
        },
        'USD/SGD': {
          from: 'USD',
          to: 'SGD'
        },
        'USD/HKD': {
          from: 'USD',
          to: 'HKD'
        },
        'USD/MXN': {
          from: 'USD',
          to: 'MXN'
        },
        'USD/THB': {
          from: 'USD',
          to: 'THB'
        },
        'EUR/GBP': {
          from: 'EUR',
          to: 'GBP'
        },
        'EUR/JPY': {
          from: 'EUR',
          to: 'JPY'
        },
        'GBP/JPY': {
          from: 'GBP',
          to: 'JPY'
        },
        'AUD/JPY': {
          from: 'AUD',
          to: 'JPY'
        },
        'EUR/AUD': {
          from: 'EUR',
          to: 'AUD'
        },
        'GBP/AUD': {
          from: 'GBP',
          to: 'AUD'
        },
        'EUR/CAD': {
          from: 'EUR',
          to: 'CAD'
        },
      };

      const mapping = rateMap[symbol];
      if (!mapping) return null;

      try {
        let rate;
        if (mapping.from === base) {
          // Direct rate from base
          if (rates[mapping.to]) {
            rate = rates[mapping.to];
          }
        } else if (mapping.to === base) {
          // Inverse rate to base
          if (rates[mapping.from]) {
            rate = 1 / rates[mapping.from];
          }
        } else {
          // Cross rate calculation
          if (rates[mapping.from] && rates[mapping.to]) {
            rate = rates[mapping.to] / rates[mapping.from];
          }
        }

        return rate ? parseFloat(rate.toFixed(5)) : null;
      } catch (e) {
        return null;
      }
    }

    /* ═══════ FETCH REAL PRICES ═══════ */
    async function fetchPrices() {
      try {
        const r = await fetch('/proxy_prices.php?_=' + Date.now());
        if (!r.ok) throw new Error('API request failed');
        const d = await r.json();
        realTimeData = d; // Store the real API data
        const rt = d.rates || {};

        // Update prices using the real data
        if (rt.EUR) px['EUR/USD'] = +(1 / rt.EUR).toFixed(5);
        if (rt.GBP) px['GBP/USD'] = +(1 / rt.GBP).toFixed(5);
        if (rt.JPY) px['USD/JPY'] = +rt.JPY.toFixed(3);
        if (rt.CHF) px['USD/CHF'] = +rt.CHF.toFixed(5);
        if (rt.CAD) px['USD/CAD'] = +rt.CAD.toFixed(5);
        if (rt.AUD) px['AUD/USD'] = +(1 / rt.AUD).toFixed(5);
        if (rt.NZD) px['NZD/USD'] = +(1 / rt.NZD).toFixed(5);
        if (rt.SGD) px['USD/SGD'] = +rt.SGD.toFixed(5);
        if (rt.HKD) px['USD/HKD'] = +rt.HKD.toFixed(5);
        if (rt.MXN) px['USD/MXN'] = +rt.MXN.toFixed(4);
        if (rt.THB) px['USD/THB'] = +rt.THB.toFixed(3);
        if (rt.EUR && rt.GBP) px['EUR/GBP'] = +(rt.GBP / rt.EUR).toFixed(5);
        if (rt.EUR && rt.JPY) px['EUR/JPY'] = +(rt.JPY / rt.EUR).toFixed(3);
        if (rt.GBP && rt.JPY) px['GBP/JPY'] = +(rt.JPY / rt.GBP).toFixed(3);
        if (rt.AUD && rt.JPY) px['AUD/JPY'] = +(rt.JPY / rt.AUD).toFixed(3);
        if (rt.EUR && rt.AUD) px['EUR/AUD'] = +(rt.AUD / rt.EUR).toFixed(5);
        if (rt.GBP && rt.AUD) px['GBP/AUD'] = +(rt.AUD / rt.GBP).toFixed(5);
        if (rt.EUR && rt.CAD) px['EUR/CAD'] = +(rt.CAD / rt.EUR).toFixed(5);

        const apiPill = document.getElementById('apiPill');
        if (apiPill) {
          apiPill.textContent = '● LIVE';
          apiPill.className = 'ap ok';
        }
        lastFetchTime = Date.now();
      } catch (error) {
        console.warn('Using simulated prices, API unavailable:', error.message);
        const apiPill = document.getElementById('apiPill');
        if (apiPill) {
          apiPill.textContent = '⚠ SIM';
          apiPill.className = 'ap fail';
        }
      }
    }

    /* ═══════ PRICE CHART ═══════ */
    function buildChart() {
      const canvas = document.getElementById('pChart');
      if (!canvas) {
        console.error('Canvas element not found');
        return;
      }
      if (!window.Chart) {
        console.error('Chart.js not loaded');
        return;
      }

      // Ensure canvas has proper dimensions
      const wrapper = document.getElementById('cWrap');
      if (wrapper) {
        const rect = wrapper.getBoundingClientRect();
        if (rect.width > 0 && rect.height > 0) {
          canvas.width = rect.width;
          canvas.height = rect.height;
        }
      }

      if (PC) {
        PC.destroy();
        PC = null;
      }
      PC = new Chart(canvas, {
        type: 'line',
        data: {
          labels: [],
          datasets: [{
            data: [],
            borderColor: '#10b981',
            backgroundColor: 'rgba(16,185,129,.06)',
            tension: .25,
            fill: true,
            borderWidth: 1.5,
            pointRadius: 0,
            pointHoverRadius: 3,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: {
            duration: 150
          },
          interaction: {
            mode: 'index',
            intersect: false
          },
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              backgroundColor: '#0c1018',
              borderColor: 'rgba(255,255,255,.1)',
              borderWidth: 1,
              titleColor: '#e8eef8',
              bodyColor: '#7a90b0',
              titleFont: {
                family: 'JetBrains Mono',
                size: 10
              },
              bodyFont: {
                family: 'JetBrains Mono',
                size: 9
              },
              callbacks: {
                label: c => ' ' + c.parsed.y.toFixed(gp(selSym)?.d || 5)
              }
            }
          },
          scales: {
            x: {
              grid: {
                color: 'rgba(255,255,255,.02)'
              },
              ticks: {
                color: '#3a4d68',
                maxTicksLimit: 8,
                font: {
                  family: 'JetBrains Mono',
                  size: 8
                }
              }
            },
            y: {
              position: 'right',
              grid: {
                color: 'rgba(255,255,255,.02)'
              },
              ticks: {
                color: '#3a4d68',
                font: {
                  family: 'JetBrains Mono',
                  size: 8
                },
                callback: v => v.toFixed(gp(selSym)?.d || 5)
              }
            }
          }
        }
      });
    }

    function redrawChart() {
      if (!PC) {
        console.warn('Chart instance not available');
        return;
      }
      const p = gp(selSym);
      if (!p) {
        console.warn('Pair not found:', selSym);
        return;
      }
      const arr = hist[selSym] || [];
      if (arr.length === 0) {
        console.warn('No historical data for:', selSym);
        return;
      }
      const price = px[selSym] || SEED[selSym] || 1;
      const now = Date.now();

      // Use Thai timezone for labels
      const labels = arr.map((_, i) => {
        const t = new Date(now - (arr.length - 1 - i) * 2500);
        return t.toLocaleTimeString('th-TH', {
          timeZone: THAI_TIMEZONE,
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit',
          hour12: false
        });
      });

      const isUp = arr.length > 1 ? arr[arr.length - 1] >= arr[0] : true;
      PC.data.labels = [...labels];
      PC.data.datasets[0].data = [...arr];
      PC.data.datasets[0].borderColor = isUp ? '#10b981' : '#f43f5e';
      PC.data.datasets[0].backgroundColor = isUp ? 'rgba(16,185,129,.06)' : 'rgba(244,63,94,.06)';
      PC.data.datasets[0].fill = ctType !== 'bar';
      PC.config.type = ctType === 'bar' ? 'bar' : 'line';
      PC.update('none');

      const bid = price,
        ask = price + p.sp;
      const chg = arr.length > 1 ? (arr[arr.length - 1] - arr[0]) / arr[0] * 100 : 0;
      document.getElementById('ovSym').textContent = selSym;
      document.getElementById('ovBid').textContent = bid.toFixed(p.d);
      document.getElementById('ovAsk').textContent = ask.toFixed(p.d);
      document.getElementById('ovSpread').textContent = (p.sp * Math.pow(10, p.d)).toFixed(1) + ' pips';
      document.getElementById('ovChg').textContent = (chg >= 0 ? '+' : '') + chg.toFixed(3) + '%';
      document.getElementById('ovChg').style.color = chg >= 0 ? 'var(--G)' : 'var(--R)';
      document.getElementById('buyPx').textContent = ask.toFixed(p.d);
      document.getElementById('sellPx').textContent = bid.toFixed(p.d);

      // Use Thai timezone for update time
      document.getElementById('csUpd').textContent = 'Updated: ' + getThaiTime();
    }

    /* ═══════ MARKET WATCH ═══════ */
    function buildMW() {
      const mwEl = document.getElementById('mwList');
      const qEl = document.getElementById('qList');
      const sel = document.getElementById('cSym');
      mwEl.innerHTML = qEl.innerHTML = sel.innerHTML = '';
      ['Major', 'Minor', 'Exotic', 'Metal'].forEach(cat => {
        const rows = PAIRS.filter(p => p.cat === cat);
        if (!rows.length) return;
        const sep = document.createElement('div');
        sep.className = 'cat-hdr';
        sep.textContent = cat;
        mwEl.appendChild(sep);
        rows.forEach(p => {
          const price = px[p.s] || SEED[p.s] || 0;
          const arr = hist[p.s] || [];
          const ch = arr.length > 1 ? arr[arr.length - 1] - arr[0] : 0;
          const pct = arr.length > 1 ? ch / arr[0] * 100 : 0;
          const up = ch >= 0;
          /* MW */
          const r = document.createElement('div');
          r.className = 'mw-row' + (p.s === selSym ? ' sel' : '');
          r.dataset.s = p.s;
          r.innerHTML = `<div><div class="mw-sym">${p.s}</div><div class="mw-sub">${cat}</div></div>
        <div class="mw-r">
          <div class="mw-px" id="mp${p.s.replace('/','')}">${price.toFixed(p.d)}</div>
          <div class="mw-ch ${up?'cu':'cd'}" id="mc${p.s.replace('/','')}">${up?'+':''}${pct.toFixed(3)}%</div>
        </div>`;
          r.addEventListener('click', () => selectSym(p.s));
          mwEl.appendChild(r);
          /* Quote */
          const q = document.createElement('div');
          q.className = 'q-row';
          q.dataset.s = p.s;
          q.innerHTML = `<div><div class="q-sym">${p.s}</div><div class="q-sub">${cat}</div></div>
        <div>
          <div class="q-px ${up?'cu':'cd'}" id="qp${p.s.replace('/','')}">${price.toFixed(p.d)}</div>
          <div class="q-ch ${up?'cu':'cd'}" id="qc${p.s.replace('/','')}">${up?'+':''}${pct.toFixed(3)}%</div>
        </div>`;
          q.addEventListener('click', () => {
            selectSym(p.s);
            showPanel('trade');
          });
          qEl.appendChild(q);
          /* Option */
          const o = document.createElement('option');
          o.value = p.s;
          o.textContent = p.s;
          sel.appendChild(o);
        });
      });
      document.getElementById('pairCnt').textContent = PAIRS.length;
      sel.value = selSym;
      console.log('Market watch built, selected symbol:', selSym);
    }

    function refreshMW() {
      PAIRS.forEach(p => {
        const price = px[p.s] || 0;
        const arr = hist[p.s] || [];
        const ch = arr.length > 1 ? arr[arr.length - 1] - arr[0] : 0;
        const pct = arr.length > 1 ? ch / arr[0] * 100 : 0;
        const up = ch >= 0;
        const k = p.s.replace('/', '');
        const mp = document.getElementById('mp' + k);
        const mc = document.getElementById('mc' + k);
        const qp = document.getElementById('qp' + k);
        const qc = document.getElementById('qc' + k);
        if (mp) mp.textContent = price.toFixed(p.d);
        if (mc) {
          mc.textContent = (up ? '+' : '') + pct.toFixed(3) + '%';
          mc.className = 'mw-ch ' + (up ? 'cu' : 'cd');
        }
        if (qp) {
          qp.textContent = price.toFixed(p.d);
          qp.className = 'q-px ' + (up ? 'cu' : 'cd');
        }
        if (qc) {
          qc.textContent = (up ? '+' : '') + pct.toFixed(3) + '%';
          qc.className = 'q-ch ' + (up ? 'cu' : 'cd');
        }
      });
    }

    function selectSym(s) {
      selSym = s;
      document.querySelectorAll('.mw-row').forEach(r => r.classList.toggle('sel', r.dataset.s === s));
      document.getElementById('cSym').value = s;
      redrawChart();
    }

    /* ═══════ TRADE ═══════ */
    async function doTrade(dir) {
      const p = gp(selSym);
      const amt = parseFloat(document.getElementById('amt').value) || 0;
      if (!p) return showAlert('ไม่พบคู่สกุลเงิน', 'err');
      if (amt < 10) return showAlert('ขั้นต่ำ 10 บาท', 'err');
      if (amt > getBal()) return showAlert('ยอดเงินไม่เพียงพอ', 'err');
      const entry = dir === 'buy' ? px[p.s] + p.sp : px[p.s];
      const exp = Date.now() + dur * 1000;

      // Send trade to backend
      const fd = new FormData();
      fd.append('forex_pair_id', p.id); // Send numeric ID instead of symbol
      fd.append('direction', dir === 'buy' ? 'up' : 'down');
      fd.append('amount', amt);
      fd.append('duration', dur);
      fd.append('mode', mode);
      fd.append('entry_price', entry);

      try {
        const response = await fetch('/trade/execute', {
          method: 'POST',
          body: fd
        });

        if (response.ok) {
          // Trade successful on backend, now update frontend
          const pos = {
            id: idSeq++,
            s: selSym,
            dir,
            amt,
            entry,
            dur,
            exp,
            start: Date.now(),
            p
          };
          setBal(getBal() - amt);
          positions.push(pos);
          renderPos();
          updateFoot();
          showAlert(`เปิด ${dir.toUpperCase()} ${selSym} ฿${amt.toFixed(0)} · ${dur}s`, 'ok');
        } else {
          showAlert('เกิดข้อผิดพลาดในการเปิดออเดอร์', 'err');
        }
      } catch (error) {
        console.error('Trade error:', error);
        showAlert('เกิดข้อผิดพลาดในการเชื่อมต่อ', 'err');
      }
    }

    function resolvePos(pos) {
      const exit = px[pos.s];
      const win = pos.dir === 'buy' ? exit > pos.entry : exit < (pos.entry + pos.p.sp);
      const pnl = win ? pos.amt * .85 : -pos.amt;
      setBal(getBal() + pos.amt + pnl);
      const cl = {
        ...pos,
        result: win ? 'win' : 'loss',
        pnl,
        exit,
        ct: Date.now()
      };
      closed.unshift(cl);
      positions = positions.filter(x => x.id !== pos.id);
      addHist(cl);
      renderPos();
      updateFoot();
      updateGraph();
      showAlert(`${pos.s} ${pos.dir.toUpperCase()} → ${win?'WIN':'LOSS'} ${pnl>=0?'+':''}฿${pnl.toFixed(2)}`, win ? 'ok' : 'err');
    }

    function addHist(cl) {
      const list = document.getElementById('hList');
      const emp = list.querySelector('.empty');
      if (emp) emp.remove();
      const d = document.createElement('div');
      d.className = 'h-row';
      d.innerHTML = `<div><div class="h-sym">${cl.s}</div><div class="h-meta">${cl.dir==='buy'?'BUY':'SELL'} · ${new Date(cl.ct).toLocaleTimeString('th-TH')}</div></div>
    <div><div class="h-res ${cl.result}">${cl.result.toUpperCase()}</div><div class="h-pnl ${cl.pnl>=0?'cu':'cd'}">${cl.pnl>=0?'+':''}${cl.pnl.toFixed(2)}฿</div></div>`;
      list.prepend(d);
    }

    /* ═══════ POSITIONS ═══════ */
    function renderPos() {
      const list = document.getElementById('posList');
      const pm = document.getElementById('cPM');
      document.getElementById('posBadge').textContent = positions.length;
      pm.innerHTML = '';
      if (!positions.length) {
        list.innerHTML = '<div class="empty"><div class="empty-ico">◎</div>No open positions</div>';
        return;
      }
      list.innerHTML = '';
      positions.forEach(pos => {
        const now = Date.now();
        const rem = Math.max(0, Math.ceil((pos.exp - now) / 1000));
        const pct = Math.min((now - pos.start) / (pos.dur * 1000) * 100, 100);
        const cur = px[pos.s] || pos.entry;
        const live = pos.dir === 'buy' ? cur - pos.entry : (pos.entry + pos.p.sp) - cur;
        const win = live > 0;
        const bc = rem < 10 ? 'var(--R)' : rem < 30 ? 'var(--A)' : 'var(--G)';
        const el = document.createElement('div');
        el.className = 'pos-it';
        el.id = 'px' + pos.id;
        el.innerHTML = `
      <div class="pos-hd">
        <div style="display:flex;align-items:center;gap:5px">
          <span class="pos-sym">${pos.s}</span>
          <span class="pos-dir ${pos.dir}">${pos.dir.toUpperCase()}</span>
        </div>
        <span class="pos-badge">OPEN</span>
      </div>
      <div class="pos-meta"><span>฿${pos.amt.toFixed(0)}</span><span>@${pos.entry.toFixed(pos.p.d)}</span><span>${cur.toFixed(pos.p.d)}</span></div>
      <div class="pos-pnl ${win?'cu':'cd'}" id="pp${pos.id}">${win?'↑ WIN +':'↓ LOSS -'}฿${(win?pos.amt*.85:pos.amt).toFixed(0)}</div>
      <div class="pos-timer" id="pt${pos.id}">⏱ ${rem}s</div>
      <div class="pos-bw"><div class="pos-b" id="pb${pos.id}" style="width:${pct}%;background:${bc}"></div></div>`;
        list.appendChild(el);
        const tag = document.createElement('div');
        tag.className = 'pm-tag pm-' + pos.dir;
        tag.textContent = (pos.dir === 'buy' ? '↑' : '↓') + pos.s + ' ' + rem + 's';
        pm.appendChild(tag);
      });
    }

    setInterval(() => {
      const now = Date.now();
      const done = [];
      positions.forEach(pos => {
        if (now >= pos.exp) {
          done.push(pos);
          return;
        }
        const rem = Math.max(0, Math.ceil((pos.exp - now) / 1000));
        const pct = Math.min((now - pos.start) / (pos.dur * 1000) * 100, 100);
        const cur = px[pos.s] || pos.entry;
        const live = pos.dir === 'buy' ? cur - pos.entry : (pos.entry + pos.p.sp) - cur;
        const win = live > 0;
        const bc = rem < 10 ? 'var(--R)' : rem < 30 ? 'var(--A)' : 'var(--G)';
        const ptEl = document.getElementById('pt' + pos.id);
        const pbEl = document.getElementById('pb' + pos.id);
        const ppEl = document.getElementById('pp' + pos.id);
        if (ptEl) ptEl.textContent = '⏱ ' + rem + 's';
        if (pbEl) {
          pbEl.style.width = pct + '%';
          pbEl.style.background = bc;
        }
        if (ppEl) {
          ppEl.className = 'pos-pnl ' + (win ? 'cu' : 'cd');
          ppEl.textContent = (win ? '↑ WIN +' : '↓ LOSS -') + '฿' + (win ? pos.amt * .85 : pos.amt).toFixed(0);
        }
      });
      done.forEach(resolvePos);
    }, 500);

    /* ═══════ ACCOUNT FOOTER ═══════ */
    function updateFoot() {
      const b = getBal();
      document.getElementById('acBal').textContent = '฿' + b.toFixed(2);
      document.getElementById('acEq').textContent = '฿' + b.toFixed(2);
      document.getElementById('acMode').textContent = mode.toUpperCase();
      document.getElementById('csAcct').textContent = mode === 'demo' ? 'Demo' : 'Real';
      document.getElementById('csBal').textContent = '฿' + b.toFixed(2);
      let op = 0;
      positions.forEach(pos => {
        const cur = px[pos.s] || pos.entry;
        const live = pos.dir === 'buy' ? cur - pos.entry : (pos.entry + pos.p.sp) - cur;
        op += live > 0 ? pos.amt * .85 : -pos.amt;
      });
      const opEl = document.getElementById('acOPnl');
      opEl.textContent = (op >= 0 ? '+' : '') + '฿' + op.toFixed(2);
      opEl.className = 'acct-val ' + (op >= 0 ? 'g' : 'r');
    }

    /* ═══════ GRAPH ═══════ */
    function buildGraph() {
      const c = document.getElementById('gChart');
      if (!c || !window.Chart) return;
      if (GC) {
        GC.destroy();
        GC = null;
      }
      GC = new Chart(c, {
        type: 'line',
        data: {
          labels: [],
          datasets: [{
            data: [],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,.08)',
            tension: .35,
            fill: true,
            borderWidth: 1.5,
            pointRadius: 2,
            pointBackgroundColor: ctx => ((ctx.dataset.data[ctx.dataIndex] || 0) >= 0 ? '#10b981' : '#f43f5e'),
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
                color: 'rgba(255,255,255,.02)'
              },
              ticks: {
                color: '#3a4d68',
                font: {
                  family: 'JetBrains Mono',
                  size: 8
                }
              }
            },
            y: {
              grid: {
                color: 'rgba(255,255,255,.02)'
              },
              ticks: {
                color: '#3a4d68',
                font: {
                  family: 'JetBrains Mono',
                  size: 8
                },
                callback: v => '฿' + v.toFixed(0)
              }
            }
          }
        }
      });
    }

    function updateGraph() {
      if (!GC) return;
      let cum = 0;
      const all = [...closed].reverse();
      GC.data.labels = all.map((_, i) => 'T' + (i + 1));
      GC.data.datasets[0].data = all.map(t => {
        cum += t.pnl;
        return cum;
      });
      GC.update();
      const wins = closed.filter(t => t.result === 'win').length;
      const wr = closed.length ? wins / closed.length * 100 : 0;
      const tot = closed.reduce((a, t) => a + t.pnl, 0);
      document.getElementById('gTot').textContent = closed.length;
      document.getElementById('gWR').textContent = wr.toFixed(1) + '%';
      document.getElementById('gPNL').textContent = (tot >= 0 ? '+' : '') + tot.toFixed(2) + '฿';
      document.getElementById('gPNL').className = 'g-val ' + (tot >= 0 ? 'cu' : 'cd');
    }

    function setGT(t, btn) {
      if (GC) {
        GC.config.type = t;
        GC.data.datasets[0].fill = t === 'line';
        GC.update();
      }
      document.querySelectorAll('.g-btn').forEach(b => b.classList.remove('on'));
      if (btn) btn.classList.add('on');
    }

    /* ═══════ UI HELPERS ═══════ */
    function showPanel(n) {
      document.querySelectorAll('.rpanel').forEach(p => p.classList.remove('show'));
      document.getElementById('panel-' + n).classList.add('show');
      if (n === 'graph' && !GC) buildGraph();
    }

    function setMode(m, el) {
      mode = m;
      document.querySelectorAll('.mode-pill').forEach(p => p.classList.remove('on'));
      el.classList.add('on');
      updateFoot();
    }

    function setNavMode(m, el) {
      document.querySelectorAll('.nav-it').forEach(x => x.classList.remove('on'));
      el.classList.add('on');
      const pill = document.querySelector('.mode-pill.' + m);
      if (pill) setMode(m, pill);
    }

    function setDur(v, el) {
      dur = v;
      document.querySelectorAll('.dur-pill').forEach(p => p.classList.remove('on'));
      el.classList.add('on');
    }

    // Toggle right panel (sr) visibility and mobile action bar
    (function(){
      function initMobileHelpers(){
        const tbtn = document.getElementById('togglePanelBtn');
        const sr = document.getElementById('sr');
        if(tbtn && sr){
          tbtn.addEventListener('click', function(){ sr.classList.toggle('collapsed'); });
        }

        function ensureMobileBar(){
          const existing = document.getElementById('mobileActionBar');
          if(window.innerWidth <= 600){
            if(!existing){
              const bar = document.createElement('div');
              bar.id = 'mobileActionBar';
              bar.className = 'mobile-action-bar';
              bar.innerHTML = '<button class="buy-btn" onclick="doTrade(\'buy\')">BUY</button><button class="sell-btn" onclick="doTrade(\'sell\')">SELL</button>';
              document.body.appendChild(bar);
            }
          } else {
            if(existing) existing.remove();
          }
        }
        ensureMobileBar();
        window.addEventListener('resize', ensureMobileBar);
      }
      if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initMobileHelpers); else initMobileHelpers();
    })();

    function showAlert(msg, t) {
      const box = document.getElementById('alertBox');
      box.innerHTML = `<div class="${t==='ok'?'a-ok':'a-err'}">${t==='ok'?'✓':'✕'} ${msg}</div>`;
      clearTimeout(window._at);
      window._at = setTimeout(() => box.innerHTML = '', 4000);
    }

    document.querySelectorAll('#tfGrp .tf-btn').forEach(b => {
      b.addEventListener('click', function() {
        document.querySelectorAll('#tfGrp .tf-btn').forEach(x => x.classList.remove('on'));
        this.classList.add('on');
        redrawChart();
      });
    });
    document.querySelectorAll('#ctGrp .tf-btn').forEach(b => {
      b.addEventListener('click', function() {
        document.querySelectorAll('#ctGrp .tf-btn').forEach(x => x.classList.remove('on'));
        this.classList.add('on');
        ctType = this.dataset.ct || 'line';
        redrawChart();
      });
    });

    // Update clock with Thai timezone
    setInterval(() => document.getElementById('clk').textContent = getThaiTime(), 1000);

    /* ═══════ MAIN LOOP ═══════ */
    // ตรวจสอบเวลาตลาด Forex (เปิดจันทร์ 05:00 ปิดเสาร์ 05:00 ตามเวลาไทย)
    function isMarketOpen() {
      const now = new Date();
      // เวลาไทย UTC+7
      const utc = now.getUTCDay(); // 0=อาทิตย์, 1=จันทร์, ... 6=เสาร์
      const hour = now.getUTCHours();
      // ตลาดเปิด จันทร์ 22:00 UTC (05:00+1) ถึง เสาร์ 22:00 UTC (05:00+6)
      if (utc === 0 || utc === 6) {
        // อาทิตย์หรือเสาร์
        if (utc === 6 && hour < 22) return true; // เสาร์ก่อน 05:00 ไทย
        return false;
      }
      if (utc === 1 && hour < 22) return false; // จันทร์ก่อน 05:00 ไทย
      return true;
    }

    function loop() {
      if (isMarketOpen()) {
        tick();
        redrawChart();
        refreshMW();
        updateFoot();
        document.getElementById('alertBox').innerHTML = '';
      } else {
        // ตลาดปิด
        document.getElementById('alertBox').innerHTML = '<div class="a-err">ตลาด Forex ปิด (หยุดเสาร์-อาทิตย์)</div>';
      }
    }

    /* ═══════ BOOT ═══════ */
    window.addEventListener('load', async () => {
      seedHistory();
      buildMW();

      // Display current date in Thai timezone
      const dateEl = document.getElementById('currentDate');
      if (dateEl) dateEl.textContent = getThaiDate();

      // Fetch real prices immediately on load
      try {
        await fetchPrices();
        // Update API source indicator
        updateApiSourceDisplay();
      } catch (e) {
        console.warn('Initial price fetch failed, using simulated data');
      }

      // Small delay to ensure DOM is fully rendered
      setTimeout(() => {
        buildChart(); // สร้าง Chart หลัง canvas มีขนาดจริงแล้ว
        redrawChart();
        updateFoot();
      }, 100);

      // Start the main loop
      setInterval(loop, 2500);

      // Fetch real prices more frequently (every 30 seconds)
      setInterval(async () => {
        try {
          await fetchPrices();
          updateApiSourceDisplay();
        } catch (e) {
          console.warn('Price fetch failed');
        }
      }, 30000);

      // Update date every minute
      setInterval(() => {
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = getThaiDate();
      }, 60000);

      // Initial call to ensure clock shows correct time immediately
      document.getElementById('clk').textContent = getThaiTime();

      // Add resize observer to handle chart resizing
      const resizeObserver = new ResizeObserver(() => {
        if (PC) {
          PC.resize();
        }
      });

      const chartWrapper = document.getElementById('cWrap');
      if (chartWrapper) {
        resizeObserver.observe(chartWrapper);
      }
    });

    // Update API source display
    function updateApiSourceDisplay() {
      if (realTimeData && realTimeData.source) {
        const apiPill = document.getElementById('apiPill');
        if (apiPill) {
          const sourceName = realTimeData.source.charAt(0).toUpperCase() + realTimeData.source.slice(1);
          apiPill.textContent = '● ' + sourceName;
          apiPill.className = 'ap ok';
        }
      }
    }
  </script>
</body>

</html>