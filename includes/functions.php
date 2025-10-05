<?php
function h($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }

function active($page, $current) { return $page === $current ? 'active' : ''; }

// Demo money format
function money($n) { return '₫ ' . number_format((float)$n, 0, ',', '.'); }
