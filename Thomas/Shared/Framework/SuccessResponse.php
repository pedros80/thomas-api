<?php

declare(strict_types=1);

namespace Thomas\Shared\Framework;

use Illuminate\Contracts\Support\Arrayable;
use Thomas\Shared\Framework\Response;

final class SuccessResponse extends Response
{
    public function __construct(array|Arrayable $data, ?Pagination $pagination = null, array $errors = [], int $statusCode = 200)
    {
        if (!is_array($data)) {
            $data = $data->toArray();
        }

        parent::__construct($this->formatData($data, $pagination, $errors), $statusCode);
    }

    private function formatData(array $data, ?Pagination $pagination, array $errors): array
    {
        $out = [
            'success' => true,
            'errors'  => $errors,
            'data'    => $data,
        ];

        if ($pagination) {
            $out['pagination'] = $pagination->toArray();
        }

        return $out;
    }
}
