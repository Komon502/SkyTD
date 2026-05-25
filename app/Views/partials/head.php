<?php
if (!isset($title)) $title = 'SkyTrade';
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Small helper classes for responsive behavior */
        .container { max-width: 1024px; margin: 0 auto; padding: 0 1rem; }
        .responsive-table { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        /* utility to make elements stack nicely on very small screens */
        .stack-mobile { display: flex; flex-direction: column; gap: .5rem; }
    </style>
