<?php

declare(strict_types=1);

namespace Thomas\Tube\Application\Queries;

use Illuminate\Cache\Repository;
use Thomas\Tube\Domain\TubeLineId;
use Thomas\Tube\Domain\TubeService;

final class GetNaptansByLine
{
    public function __construct(
        private readonly TubeService $service,
        private readonly Repository $cache
    ) {
    }

    public function get(TubeLineId $line): array
    {
        $key = "Naptans|Line:{$line}";

        /** @var array $naptans */
        $naptans = $this->cache->get($key);

        if (!$naptans) {

            $naptans = $this->service->getNaptansByLine($line);

            $this->cache->put($key, $naptans, 60);
        }

        return $naptans;
    }
}
