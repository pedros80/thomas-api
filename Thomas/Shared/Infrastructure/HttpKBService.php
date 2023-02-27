<?php

declare(strict_types=1);

namespace Thomas\Shared\Infrastructure;

use Pedros80\NREphp\Services\KnowledgeBase;
use Thomas\Shared\Domain\KBService;
use Thomas\Shared\Domain\TokenService;

final class HttpKBService implements KBService
{
    public function __construct(
        private TokenService $tokens,
        private KnowledgeBase $knowledgeBase
    ) {
    }

    public function serviceIndicators(): string
    {
        $token = $this->tokens->get();

        return $this->knowledgeBase->serviceIndicators($token['token']);
    }
}
