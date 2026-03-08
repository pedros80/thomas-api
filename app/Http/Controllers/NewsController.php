<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Thomas\News\Domain\NewsItemsOptions;
use Thomas\News\Domain\NewsService;
use Thomas\Shared\Framework\Pagination;
use Thomas\Shared\Framework\SuccessResponse;

final class NewsController extends Controller
{
    public function get(Request $request, NewsService $news): SuccessResponse
    {
        $options = NewsItemsOptions::fromRequest($request);

        $newsItems = $news->page($options);

        $pagination = new Pagination(
            $options->pageNumber,
            $options->perPage,
            $news->count(),
        );

        return new SuccessResponse($newsItems, $pagination);
    }
}
