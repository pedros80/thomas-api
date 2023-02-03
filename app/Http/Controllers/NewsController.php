<?php

namespace App\Http\Controllers;

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