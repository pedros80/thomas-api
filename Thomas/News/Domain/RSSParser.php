<?php

namespace Thomas\News\Domain;

use SimpleXMLElement;

interface RSSParser
{
    public function parse(SimpleXMLElement $xml): array;
}
