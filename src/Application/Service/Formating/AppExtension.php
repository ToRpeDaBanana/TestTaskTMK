<?php

namespace App\Application\Service\Formating;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_views', [$this, 'formatViews']),
        ];
    }

    public function formatViews(int $views): string
    {
        if ($views < 1000) {
            return (string)$views;
        } elseif ($views < 1000000) {
            return round($views / 1000, 1) . 'K';
        } else {
            return round($views / 1000000, 1) . 'M';
        }
    }
}
