<?php

namespace Thomas\ServiceIndicator\Infrastructure;

use SimpleXMLElement;
use Thomas\ServiceIndicator\Domain\Icon;
use Thomas\ServiceIndicator\Domain\ServiceIndicator;
use Thomas\ServiceIndicator\Domain\Status;
use Thomas\ServiceIndicator\Domain\TocCode;
use Thomas\ServiceIndicator\Domain\TocName;

final class ServiceIndicatorParser
{
    public function parse(string $xml): array
    {
        $out = [];
        $xml = new SimpleXMLElement($xml);

        foreach ($xml as $toc) {

            $out[] = new ServiceIndicator(
                new TocCode((string) $toc->TocCode),
                new TocName((string) $toc->TocName),
                $this->getStatus($toc),
                new Icon((string) $toc->StatusImage)
            );
        }

        return $out;
    }

    private function getStatus(SimpleXMLElement $toc): Status
    {
        $status = (string) $toc->Status;
        if ($status === 'Custom') {
            $status = (string) $toc->StatusDescription;
        }

        return new Status($status);
    }
}
