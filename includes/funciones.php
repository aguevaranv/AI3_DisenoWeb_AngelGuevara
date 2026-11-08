<?php

declare(strict_types=1);

// Escapa un texto antes de mostrarlo en HTML (protección contra XSS).
function e(?string $valor): string
{
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}
