<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;

class StatsController extends Controller
{
    public function lastVisit(ShortUrl $shortUrl): array
    {
        return [
          'last_visit' => $shortUrl->last_visit?->toIso8601String(),
        ];
    }

    public function visits(ShortUrl $shortUrl)
    {
        $visits = $shortUrl->visits()
            ->selectRaw("
                DATE_FORMAT(created_at, '%Y-%m-%d') as date,
                COUNT(*) as count
            ")
            ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m-%d")')
            ->get();

        ray($visits);

        return [
            'total' => $shortUrl->visits()->count(),
            'visits' => [

            ]
        ];
    }
}
