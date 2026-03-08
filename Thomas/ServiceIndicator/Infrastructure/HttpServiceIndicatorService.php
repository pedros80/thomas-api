<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Infrastructure;

use Thomas\ServiceIndicator\Domain\ServiceIndicators;
use Thomas\ServiceIndicator\Domain\ServiceIndicatorService;
use Thomas\Shared\Domain\KBService;

final class HttpServiceIndicatorService implements ServiceIndicatorService
{
    public function __construct(
        private readonly KBService $knowledgeBase,
        private readonly ServiceIndicatorParser $parser
    ) {
    }

    public function get(): ServiceIndicators
    {
        $xml = $this->knowledgeBase->serviceIndicators();
        $out = $this->parser->parse($xml);

        return new ServiceIndicators($out);
    }
}
