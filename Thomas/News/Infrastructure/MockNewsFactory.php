<?php

declare(strict_types=1);

namespace Thomas\News\Infrastructure;

use SimpleXMLElement;

final class MockNewsFactory
{
    public function makeXML(): SimpleXMLElement
    {
        return new SimpleXMLElement($this->makeContent());
    }

    public function makeContent(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet title="XSL_formatting" type="text/xsl" href="/shared/bsp/xsl/rss/nolsol.xsl"?>
<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
        <title><![CDATA[BBC News - Home]]></title>
        <description><![CDATA[BBC News - Home]]></description>
        <link>https://www.bbc.co.uk/news/</link>
        <image>
            <url>https://news.bbcimg.co.uk/nol/shared/img/bbc_news_120x60.gif</url>
            <title>BBC News - Home</title>
            <link>https://www.bbc.co.uk/news/</link>
        </image>
        <generator>RSS for Node</generator>
        <lastBuildDate>Tue, 07 Feb 2023 21:45:03 GMT</lastBuildDate>
        <copyright><![CDATA[Copyright: (C) British Broadcasting Corporation, see http://news.bbc.co.uk/2/hi/help/rss/4498287.stm for terms and conditions of reuse.]]></copyright>
        <language><![CDATA[en-gb]]></language>
        <ttl>15</ttl>
        <item>
            <title><![CDATA[Epsom College head called relative before she was shot by husband]]></title>
            <description><![CDATA[Police recover a firearm owned by George Pattison who officers believe killed his wife and daughter.]]></description>
            <link>https://www.bbc.co.uk/news/uk-england-surrey-64544884?at_medium=RSS&amp;at_campaign=KARANGA</link>
            <guid isPermaLink="false">https://www.bbc.co.uk/news/uk-england-surrey-64544884</guid>
            <pubDate>Tue, 07 Feb 2023 18:45:52 GMT</pubDate>
        </item>
        <item>
            <title><![CDATA[China spy balloon: US Navy releases photos of debris]]></title>
            <description><![CDATA[The suspected Chinese surveillance balloon was shot down over the Atlantic on Saturday.]]></description>
            <link>https://www.bbc.co.uk/news/world-us-canada-64562100?at_medium=RSS&amp;at_campaign=KARANGA</link>
            <guid isPermaLink="false">https://www.bbc.co.uk/news/world-us-canada-64562100</guid>
            <pubDate>Tue, 07 Feb 2023 18:25:41 GMT</pubDate>
        </item>
        <item>
            <title><![CDATA[Nicola Bulley: Police still believe missing mum fell into river]]></title>
            <description><![CDATA[Officers say they are "fully open" to new information and are following about 500 lines of inquiry.]]></description>
            <link>https://www.bbc.co.uk/news/uk-england-lancashire-64548395?at_medium=RSS&amp;at_campaign=KARANGA</link>
            <guid isPermaLink="false">https://www.bbc.co.uk/news/uk-england-lancashire-64548395</guid>
            <pubDate>Tue, 07 Feb 2023 17:02:05 GMT</pubDate>
        </item>
        <item>
            <title><![CDATA[Civil servants set to strike on Budget day]]></title>
            <description><![CDATA[The PCS union plans a second walkout as the row with the government over pay escalates.]]></description>
            <link>https://www.bbc.co.uk/news/business-64561834?at_medium=RSS&amp;at_campaign=KARANGA</link>
            <guid isPermaLink="false">https://www.bbc.co.uk/news/business-64561834</guid>
            <pubDate>Tue, 07 Feb 2023 18:40:19 GMT</pubDate>
        </item>
    </channel>
</rss>';
    }
}
