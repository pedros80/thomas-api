<?php

namespace Thomas\Stations\Infrastructure;

use Stomp\Transport\Frame;

final class MockMessageFactory
{
    private const HEADERS = '{"content-length":"456","expires":"1675970249777","destination":"\/topic\/darwin.pushport-v16","ack":"ID:nrdp-prod-01.dsg.caci.co.uk-39784-1675822063826-2:101095828","CamelJmsDeliveryMode":"1","subscription":"1407819931400544964","priority":"4","breadcrumbId":"ID-nrdp-prod-01-dsg-caci-co-uk-1675822062607-0-25787817","Content_HYPHEN_Type":"application\/xml","Username":"thales","SequenceNumber":"212201","message-id":"ID:nrdp-prod-01.dsg.caci.co.uk-39784-1675822063826-8:8:1:1:1534083","PushPortSequence":"3489762","MessageType":"OW","timestamp":"1675969849777"}';

    public static function stations(): Frame
    {
        $content = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
            <Pport
                xmlns="http://www.thalesgroup.com/rtti/PushPort/v16"
                xmlns:ns2="http://www.thalesgroup.com/rtti/PushPort/Schedules/v3"
                xmlns:ns3="http://www.thalesgroup.com/rtti/PushPort/Schedules/v2"
                xmlns:ns4="http://www.thalesgroup.com/rtti/PushPort/Formations/v2"
                xmlns:ns5="http://www.thalesgroup.com/rtti/PushPort/Forecasts/v3"
                xmlns:ns6="http://www.thalesgroup.com/rtti/PushPort/Formations/v1"
                xmlns:ns7="http://www.thalesgroup.com/rtti/PushPort/StationMessages/v1"
                xmlns:ns8="http://www.thalesgroup.com/rtti/PushPort/TrainAlerts/v1"
                xmlns:ns9="http://www.thalesgroup.com/rtti/PushPort/TrainOrder/v1"
                xmlns:ns10="http://www.thalesgroup.com/rtti/PushPort/TDData/v1"
                xmlns:ns11="http://www.thalesgroup.com/rtti/PushPort/Alarms/v1"
                xmlns:ns12="http://thalesgroup.com/RTTI/PushPortStatus/root_1"
                ts="2023-02-08T23:15:40.9166875Z"
                version="16.0">
                <uR updateOrigin="Workstation">
                    <OW id="123605" cat="Train" sev="1">
                        <ns7:Station crs="BRR"/>
                        <ns7:Station crs="BUS"/>
                        <ns7:Station crs="CKS"/>
                        <ns7:Station crs="CMY"/>
                        <ns7:Station crs="DNL"/>
                        <ns7:Station crs="EKL"/>
                        <ns7:Station crs="GFN"/>
                        <ns7:Station crs="GLC"/>
                        <ns7:Station crs="HMY"/>
                        <ns7:Station crs="KLM"/>
                        <ns7:Station crs="KMK"/>
                        <ns7:Station crs="KNS"/>
                        <ns7:Station crs="NIT"/>
                        <ns7:Station crs="PTL"/>
                        <ns7:Station crs="PWW"/>
                        <ns7:Station crs="STT"/>
                        <ns7:Station crs="THB"/>
                        <ns7:Station crs="THT"/>
                        <ns7:Msg>
Trains between Glasgow Central and East Kilbride / Kilmarnock may be cancelled, delayed or revised. More details can be found in Latest Travel News.
                        </ns7:Msg>
                    </OW>
                </uR>
            </Pport>';

        $body = gzencode($content);
        $body = $body !== false ? $body : $content;

        return new Frame('MESSAGE', json_decode(self::HEADERS, true), $body);
    }

    public static function noStations(): Frame
    {
        $content = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
            <Pport
                xmlns="http://www.thalesgroup.com/rtti/PushPort/v16"
                xmlns:ns2="http://www.thalesgroup.com/rtti/PushPort/Schedules/v3"
                xmlns:ns3="http://www.thalesgroup.com/rtti/PushPort/Schedules/v2"
                xmlns:ns4="http://www.thalesgroup.com/rtti/PushPort/Formations/v2"
                xmlns:ns5="http://www.thalesgroup.com/rtti/PushPort/Forecasts/v3"
                xmlns:ns6="http://www.thalesgroup.com/rtti/PushPort/Formations/v1"
                xmlns:ns7="http://www.thalesgroup.com/rtti/PushPort/StationMessages/v1"
                xmlns:ns8="http://www.thalesgroup.com/rtti/PushPort/TrainAlerts/v1"
                xmlns:ns9="http://www.thalesgroup.com/rtti/PushPort/TrainOrder/v1"
                xmlns:ns10="http://www.thalesgroup.com/rtti/PushPort/TDData/v1"
                xmlns:ns11="http://www.thalesgroup.com/rtti/PushPort/Alarms/v1"
                xmlns:ns12="http://thalesgroup.com/RTTI/PushPortStatus/root_1"
                ts="2023-02-08T23:15:40.9166875Z"
                version="16.0">
                <uR updateOrigin="Workstation">
                    <OW id="123605" cat="Train" sev="1">
                        <ns7:Msg>
Trains between Glasgow Central and East Kilbride / Kilmarnock may be cancelled, delayed or revised. More details can be found in Latest Travel News.

                        </ns7:Msg>
                    </OW>
                </uR>
            </Pport>';

        $body = gzencode($content);
        $body = $body !== false ? $body : $content;

        return new Frame('MESSAGE', json_decode(self::HEADERS, true), $body);
    }
}
