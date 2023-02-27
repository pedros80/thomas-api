<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Infrastructure;

use Thomas\ServiceIndicator\Domain\ServiceIndicatorService;
use Thomas\Shared\Domain\KBService;

final class HttpServiceIndicatorService implements ServiceIndicatorService
{
    public function __construct(
        private KBService $knowledgeBase,
        private ServiceIndicatorParser $parser
    ) {
    }

    public function get(): array
    {
        $xml = $this->knowledgeBase->serviceIndicators();
        $out = $this->parser->parse($xml);

        return $out;
    }
}
