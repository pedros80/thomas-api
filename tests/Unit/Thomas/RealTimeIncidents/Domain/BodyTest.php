<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\RealTimeIncidents\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\RealTimeIncidents\Domain\Body;
use Thomas\RealTimeIncidents\Domain\EndTime;
use Thomas\RealTimeIncidents\Domain\StartTime;

final class BodyTest extends TestCase
{
    public function testInstantiates(): void
    {
        $content = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <uk.co.nationalrail.xml.incident.PtIncidentStructure
            xmlns:ns2="http://nationalrail.co.uk/xml/common"
            xmlns:ns3="http://nationalrail.co.uk/xml/incident">
            <ns3:CreationTime>2023-02-06T09:56:00.000Z</ns3:CreationTime>
            <ns3:ChangeHistory>
                <ns2:ChangedBy>KeeanJames_NRCC</ns2:ChangedBy>
                <ns2:LastChangedDate>2023-02-06T09:58:00.000Z</ns2:LastChangedDate>
            </ns3:ChangeHistory>
            <ns3:IncidentNumber>D85AA5FB1954428C84A2F636014C2A4A</ns3:IncidentNumber>
            <ns3:Version>20230206095815</ns3:Version>
            <ns3:Source>
                <ns3:TwitterHashtag>#Radlett</ns3:TwitterHashtag>
            </ns3:Source>
            <ns3:ValidityPeriod>
                <ns2:StartTime>2023-02-06T09:56:00.000Z</ns2:StartTime>
            </ns3:ValidityPeriod>
            <ns3:Planned>true</ns3:Planned>
            <ns3:Summary>
                Delays between London St Pancras International and St Albans expected until 11:30
            </ns3:Summary>
            <ns3:Description>
                &lt;p&gt;Due to a problem currently under investigation&amp;#160;between London St Pancras International and St Albans trains have to run at reduced speed on all lines. As a result, trains may be delayed.&lt;/p&gt;
            </ns3:Description>
            <ns3:InfoLinks>
                <ns3:InfoLink>
                    <ns3:Uri>https://www.nationalrail.co.uk/service_disruptions/317211.aspx</ns3:Uri>
                    <ns3:Label>nationalrail.co.uk</ns3:Label>
                </ns3:InfoLink>
            </ns3:InfoLinks>
            <ns3:Affects>
                <ns3:Operators>
                    <ns3:AffectedOperator>
                        <ns3:OperatorRef>TL</ns3:OperatorRef>
                        <ns3:OperatorName>Thameslink</ns3:OperatorName>
                    </ns3:AffectedOperator>
                </ns3:Operators>
                <ns3:RoutesAffected>&lt;p&gt;between London St Pancras International and St Albans&lt;/p&gt;</ns3:RoutesAffected>
            </ns3:Affects>
            <ns3:ClearedIncident>false</ns3:ClearedIncident>
            <ns3:IncidentPriority>2</ns3:IncidentPriority>
        </uk.co.nationalrail.xml.incident.PtIncidentStructure>';

        $body = new Body($content);
        $this->assertInstanceOf(Body::class, $body);
        $this->assertEquals($content, (string) $body);
        $this->assertEquals('Delays between London St Pancras International and St Albans expected until 11:30', $body->summary());
        $this->assertEquals('<p>Due to a problem currently under investigation&#160;between London St Pancras International and St Albans trains have to run at reduced speed on all lines. As a result, trains may be delayed.</p>', $body->description());
        $this->assertEquals('2023-02-06 09:56:00', $body->creationTime()?->format('Y-m-d H:i:s'));
        $this->assertIsArray($body->toArray());
        $this->assertEquals($body->toArray(), $body->jsonSerialize());
        $this->assertNull($body->endTime());
        $this->assertFalse($body->cleared());
        $this->assertTrue($body->planned());
        $this->assertEquals(['TL'], $body->operators());
    }

    public function testCanGetStartAndEndTimes(): void
    {
        $content = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <uk.co.nationalrail.xml.incident.PtIncidentStructure
            xmlns:ns2="http://nationalrail.co.uk/xml/common"
            xmlns:ns3="http://nationalrail.co.uk/xml/incident">
            <ns3:CreationTime>2023-02-28T19:06:00.000Z</ns3:CreationTime>
            <ns3:ChangeHistory>
                <ns2:ChangedBy>mjones_nrcc</ns2:ChangedBy>
                <ns2:LastChangedDate>2023-02-28T19:55:00.000Z</ns2:LastChangedDate>
            </ns3:ChangeHistory>
            <ns3:ParticipantRef>123276</ns3:ParticipantRef>
            <ns3:IncidentNumber>9FF94BC72755480B8E80716D2BE01AF5</ns3:IncidentNumber>
            <ns3:Version>20230228195524</ns3:Version>
            <ns3:Source>
                <ns3:TwitterHashtag>#Cannock</ns3:TwitterHashtag>
            </ns3:Source>
            <ns3:ValidityPeriod>
                <ns2:StartTime>2023-02-28T19:06:00.000Z</ns2:StartTime>
                <ns2:EndTime>2023-02-28T19:55:00.000Z</ns2:EndTime>
            </ns3:ValidityPeriod>
            <ns3:Planned>false</ns3:Planned>
            <ns3:Summary>Disruption between Walsall and Rugeley Trent Valley</ns3:Summary>
            <ns3:Description>
                    &lt;p&gt;Disruption caused by an earlier&amp;#160;&lt;a href="https://www.networkrail.co.uk/running-the-railway/looking-after-the-railway/delays-explained/vandalism-and-trespass/"&gt;trespass incident&lt;/a&gt;&amp;#160;between Cannock and Hednesford has now ended.&lt;/p&gt;
            </ns3:Description>
            <ns3:InfoLinks>
                <ns3:InfoLink>
                    <ns3:Uri>https://www.nationalrail.co.uk/service_disruptions/319063.aspx</ns3:Uri>
                    <ns3:Label>nationalrail.co.uk</ns3:Label>
                </ns3:InfoLink>
            </ns3:InfoLinks>
            <ns3:Affects>
                <ns3:Operators>
                    <ns3:AffectedOperator>
                        <ns3:OperatorRef>WM</ns3:OperatorRef>
                        <ns3:OperatorName>West Midlands Railway</ns3:OperatorName>
                    </ns3:AffectedOperator>
                </ns3:Operators>
                <ns3:RoutesAffected>&lt;p&gt;Between Birmingham International and Rugeley Trent Valley&lt;/p&gt;</ns3:RoutesAffected>
            </ns3:Affects>
            <ns3:ClearedIncident>true</ns3:ClearedIncident>
            <ns3:IncidentPriority>2</ns3:IncidentPriority>
        </uk.co.nationalrail.xml.incident.PtIncidentStructure>';

        $body = new Body($content);
        $this->assertInstanceOf(StartTime::class, $body->startTime());
        $this->assertInstanceOf(EndTime::class, $body->endTime());
        $this->assertTrue($body->cleared());
        $this->assertFalse($body->planned());
        $this->assertEquals(['WM'], $body->operators());
    }
}
