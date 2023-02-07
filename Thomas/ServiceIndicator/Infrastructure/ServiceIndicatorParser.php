<?php

namespace Thomas\ServiceIndicator\Infrastructure;

use SimpleXMLElement;

final class ServiceIndicatorParser
{
    public function parse(string $xml): array
    {
        $out = [];
        $xml = new SimpleXMLElement($xml);

        foreach ($xml as $toc) {
            $out[] = [
                'code'   => (string) $toc->TocCode,
                'name'   => (string) $toc->TocName,
                'status' => (string) $toc->Status,
                'image'  => (string) $toc->StatusImage,
            ];
        }

        return $out;
    }
}
