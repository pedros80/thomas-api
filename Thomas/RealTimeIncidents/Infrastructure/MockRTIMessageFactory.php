<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Infrastructure;

use Stomp\Transport\Frame;

final class MockRTIMessageFactory
{
    private const COMMAND = 'MESSAGE';
    private const BODY    = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
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
                <ns3:TwitterHashtag>#Radlett</ns3:TwitterHashtag></ns3:Source>
                <ns3:ValidityPeriod>
                    <ns2:StartTime>2023-02-06T09:56:00.000Z</ns2:StartTime>
                </ns3:ValidityPeriod>
                <ns3:Planned>false</ns3:Planned>
                <ns3:Summary>Delays between London St Pancras International and St Albans expected until 11:30</ns3:Summary>
                <ns3:Description>
                    &lt;p&gt;Due to a problem currently under investigation&amp;#160;between London St Pancras International and St Albans trains have to run at reduced speed on all lines. As a result, trains may be delayed.&lt;/p&gt;
                    &lt;p&gt;Disruption is expected until 11:30.&lt;/p&gt;
                    &lt;p&gt;&lt;strong&gt;Customer Advice:&lt;/strong&gt;&lt;/p&gt;
                    &lt;p&gt;Thameslink are seeking more information on delays taking place in the Radlett area from our Network Rail colleagues.&lt;/p&gt;
                    &lt;p&gt;At this time, please allow extra time to complete your journey.&lt;/p&gt;
                    &lt;p&gt;&lt;strong&gt;Check before you travel:&lt;/strong&gt;&lt;br /&gt;
                    You can check your journey using the National Rail Enquiries real-time&amp;#160;&lt;a href="http://ojp.nationalrail.co.uk/service/planjourney/search"&gt;Journey Planner&lt;/a&gt;&lt;/p&gt;
                    &lt;p&gt;&lt;strong&gt;Twitter:&lt;/strong&gt;&lt;br /&gt;
                    If you would like to follow this incident on Twitter, please use &lt;a href="https://twitter.com/hashtag/Radlett?f=tweets"&gt;#Radlett&lt;/a&gt;&lt;/p&gt;
                    &lt;p&gt;&lt;strong&gt;Compensation:&lt;/strong&gt;&lt;br /&gt;
                    You may be entitled to&amp;#160;&lt;a href="http://www.nationalrail.co.uk/compensation"&gt;compensation&lt;/a&gt;&amp;#160;if you experience a delay in completing your journey today. Please keep your train ticket and make a note of your journey, as both will be required to support any claim.&lt;/p&gt;
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

    public static function new(): Frame
    {
        $headers = json_decode('{"expires":"1675678006574","KNOWLEDGEBASE_DATA_TYPE":"INCIDENT_MESSAGE","INCIDENT_ID":"D85AA5FB1954428C84A2F636014C2A4A","destination":"\/topic\/kb.incidents","ack":"ID:nrdp-prod-01.dsg.caci.co.uk-45902-1674502186804-2:656431571","subscription":"3806349285722602907","priority":"4","INCIDENT_MESSAGE_STATUS":"NEW","breadcrumbId":"ID-nrdp-prod-03-dsg-caci-co-uk-1674825898397-0-2766","message-id":"ID:nrdp-prod-03.dsg.caci.co.uk-45533-1674825909115-1:1082:1:1:1","timestamp":"1675677706574"}', true);

        return new Frame(self::COMMAND, $headers, self::BODY);
    }

    public static function modified(): Frame
    {
        $headers = json_decode('{"expires":"1675678006574","KNOWLEDGEBASE_DATA_TYPE":"INCIDENT_MESSAGE","INCIDENT_ID":"D85AA5FB1954428C84A2F636014C2A4A","destination":"\/topic\/kb.incidents","ack":"ID:nrdp-prod-01.dsg.caci.co.uk-45902-1674502186804-2:656431571","subscription":"3806349285722602907","priority":"4","INCIDENT_MESSAGE_STATUS":"MODIFIED","breadcrumbId":"ID-nrdp-prod-03-dsg-caci-co-uk-1674825898397-0-2766","message-id":"ID:nrdp-prod-03.dsg.caci.co.uk-45533-1674825909115-1:1082:1:1:1","timestamp":"1675677706574"}', true);

        return new Frame(self::COMMAND, $headers, self::BODY);
    }

    public static function removed(): Frame
    {
        $headers = json_decode('{"expires":"1675678006574","KNOWLEDGEBASE_DATA_TYPE":"INCIDENT_MESSAGE","INCIDENT_ID":"D85AA5FB1954428C84A2F636014C2A4A","destination":"\/topic\/kb.incidents","ack":"ID:nrdp-prod-01.dsg.caci.co.uk-45902-1674502186804-2:656431571","subscription":"3806349285722602907","priority":"4","INCIDENT_MESSAGE_STATUS":"REMOVED","breadcrumbId":"ID-nrdp-prod-03-dsg-caci-co-uk-1674825898397-0-2766","message-id":"ID:nrdp-prod-03.dsg.caci.co.uk-45533-1674825909115-1:1082:1:1:1","timestamp":"1675677706574"}', true);

        return new Frame(self::COMMAND, $headers);
    }
}
