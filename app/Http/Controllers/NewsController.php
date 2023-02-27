<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Thomas\News\Application\Queries\GetNewsHeadlines;

final class NewsController extends Controller
{
    public function get(GetNewsHeadlines $query): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $query->get(),
        ]);
    }
}
