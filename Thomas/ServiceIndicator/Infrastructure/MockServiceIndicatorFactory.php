<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Infrastructure;

final class MockServiceIndicatorFactory
{
    public static function makeXML(): string
    {
        return '<?xml version="1.0" encoding="utf-8"?>
            <NSI xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xsi:schemaLocation="http://internal.nationalrail.co.uk/xml/XsdSchemas/External/Version4.0/nre-service-indicator-v4-0.xsd" xmlns="http://nationalrail.co.uk/xml/serviceindicator">
                <TOC>
                <TocCode>VT</TocCode>
                <TocName>Avanti West Coast</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>AvantiWestCoast</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>CC</TocCode>
                <TocName>c2c</TocName>
                <Status>Custom</Status>
                <StatusImage>icon-note-noshadow.png</StatusImage>
                <StatusDescription><![CDATA[Disruption at Barking]]></StatusDescription>
                <ServiceGroup>
                    <GroupName>Barking</GroupName>
                    <CurrentDisruption>D683432B9756482BA702243F08804B92</CurrentDisruption>
                    <CustomDetail><![CDATA[Read about this disruption]]></CustomDetail>
                    <CustomURL>https://www.nationalrail.co.uk/</CustomURL>
                </ServiceGroup>
                <TwitterAccount>c2c_Rail</TwitterAccount>
                <AdditionalInfo><![CDATA[Latest travel news]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>CS</TocCode>
                <TocName>Caledonian Sleeper</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>CalSleeper</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>CH</TocCode>
                <TocName>Chiltern Railways</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>chilternrailway</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>XC</TocCode>
                <TocName>CrossCountry</TocName>
                <Status>Custom</Status>
                <StatusImage>icon-note-noshadow.png</StatusImage>
                <StatusDescription><![CDATA[Delays between Newcastle and Berwick-upon-Tweed]]></StatusDescription>
                <ServiceGroup>
                    <GroupName>Morpeth</GroupName>
                    <CurrentDisruption>BF318D823D2B400F98B3AA124AF61242</CurrentDisruption>
                    <CustomDetail><![CDATA[Read about this disruption]]></CustomDetail>
                    <CustomURL>https://www.nationalrail.co.uk/</CustomURL>
                </ServiceGroup>
                <TwitterAccount>crosscountryuk</TwitterAccount>
                <AdditionalInfo><![CDATA[Latest travel news]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>EM</TocCode>
                <TocName>East Midlands Railway</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>EastMidRailway</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>XR</TocCode>
                <TocName>Elizabeth line</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>TFL</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>ES</TocCode>
                <TocName>Eurostar</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>EurostarUK</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>GX</TocCode>
                <TocName>Gatwick Express</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>GatwickExpress</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>GC</TocCode>
                <TocName>Grand Central</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>GC_Rail</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>GN</TocCode>
                <TocName>Great Northern</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>GNRailUK</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>GW</TocCode>
                <TocName>Great Western Railway</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>GWRHelp</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>LE</TocCode>
                <TocName>Greater Anglia</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>greateranglia</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>HX</TocCode>
                <TocName>Heathrow Express</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>HeathrowExpress</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>HT</TocCode>
                <TocName>Hull Trains</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>Hull_Trains</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>IL</TocCode>
                <TocName>Island Line</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>SW_Help</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>GR</TocCode>
                <TocName>London North Eastern Railway</TocName>
                <Status>Custom</Status>
                <StatusImage>icon-note-noshadow.png</StatusImage>
                <StatusDescription><![CDATA[Delays between Newcastle and Berwick-upon-Tweed]]></StatusDescription>
                <ServiceGroup>
                    <GroupName>Morpeth</GroupName>
                    <CurrentDisruption>BF318D823D2B400F98B3AA124AF61242</CurrentDisruption>
                    <CustomDetail><![CDATA[Read about this disruption]]></CustomDetail>
                    <CustomURL>https://www.nationalrail.co.uk/</CustomURL>
                </ServiceGroup>
                <TwitterAccount>LNER</TwitterAccount>
                <AdditionalInfo><![CDATA[Latest travel news]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>LN</TocCode>
                <TocName>London Northwestern Railway</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>LNRailway</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>LO</TocCode>
                <TocName>London Overground</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>TfL</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>LD</TocCode>
                <TocName>Lumo</TocName>
                <Status>Custom</Status>
                <StatusImage>icon-note-noshadow.png</StatusImage>
                <StatusDescription><![CDATA[Delays between Newcastle and Berwick-upon-Tweed]]></StatusDescription>
                <ServiceGroup>
                    <GroupName>Morpeth</GroupName>
                    <CurrentDisruption>BF318D823D2B400F98B3AA124AF61242</CurrentDisruption>
                    <CustomDetail><![CDATA[Read about this disruption]]></CustomDetail>
                    <CustomURL>https://www.nationalrail.co.uk/</CustomURL>
                </ServiceGroup>
                <TwitterAccount>LumoTravel</TwitterAccount>
                <AdditionalInfo><![CDATA[Latest travel news]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>ME</TocCode>
                <TocName>Merseyrail</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>Merseyrail</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>NT</TocCode>
                <TocName>Northern</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>northernassist</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>SR</TocCode>
                <TocName>ScotRail</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>ScotRail</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>SW</TocCode>
                <TocName>South Western Railway</TocName>
                <Status>Minor delays on some routes</Status>
                <StatusImage>icon-note-noshadow.png</StatusImage>
                <ServiceGroup>
                    <GroupName>Overton</GroupName>
                    <CurrentDisruption>7EF526751A7E43BE8816EC5E02FE9334</CurrentDisruption>
                    <CustomDetail><![CDATA[Read about this disruption]]></CustomDetail>
                    <CustomURL>https://www.nationalrail.co.uk/</CustomURL>
                </ServiceGroup>
                <ServiceGroup>
                    <GroupName>Hook</GroupName>
                    <CurrentDisruption>CEC30DC5B288460BAC766D3C65F4D3D1</CurrentDisruption>
                    <CustomDetail><![CDATA[Read about this disruption]]></CustomDetail>
                    <CustomURL>https://www.nationalrail.co.uk/</CustomURL>
                </ServiceGroup>
                <TwitterAccount>SW_Help</TwitterAccount>
                <AdditionalInfo><![CDATA[Latest travel news]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>SE</TocCode>
                <TocName>Southeastern</TocName>
                <Status>Custom</Status>
                <StatusImage>icon-note-noshadow.png</StatusImage>
                <StatusDescription><![CDATA[Disruption between Ashford International and Headcorn]]></StatusDescription>
                <ServiceGroup>
                    <GroupName>Headcorn</GroupName>
                    <CurrentDisruption>CA43C24E5EAF4F158CB65FDA7672B286</CurrentDisruption>
                    <CustomDetail><![CDATA[Read about this disruption]]></CustomDetail>
                    <CustomURL>https://www.nationalrail.co.uk/</CustomURL>
                </ServiceGroup>
                <TwitterAccount>Se_Railway</TwitterAccount>
                <AdditionalInfo><![CDATA[Latest travel news]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>SN</TocCode>
                <TocName>Southern</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>SouthernRailUK</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>SX</TocCode>
                <TocName>Stansted Express</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>Stansted_Exp</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>TL</TocCode>
                <TocName>Thameslink</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>TLRailUK</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>TP</TocCode>
                <TocName>TransPennine Express</TocName>
                <Status>Custom</Status>
                <StatusImage>icon-note-noshadow.png</StatusImage>
                <StatusDescription><![CDATA[Delays between Newcastle and Berwick-upon-Tweed]]></StatusDescription>
                <ServiceGroup>
                    <GroupName>Morpeth</GroupName>
                    <CurrentDisruption>BF318D823D2B400F98B3AA124AF61242</CurrentDisruption>
                    <CustomDetail><![CDATA[Read about this disruption]]></CustomDetail>
                    <CustomURL>https://www.nationalrail.co.uk/</CustomURL>
                </ServiceGroup>
                <TwitterAccount>TPEAssist</TwitterAccount>
                <AdditionalInfo><![CDATA[Latest travel news]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>AW</TocCode>
                <TocName>Transport for Wales</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>tfwrail</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
                <TOC>
                <TocCode>WM</TocCode>
                <TocName>West Midlands Railway</TocName>
                <Status>Good service</Status>
                <StatusImage>icon-tick2.png</StatusImage>
                <TwitterAccount>WestMidRailway</TwitterAccount>
                <AdditionalInfo><![CDATA[Follow us on Twitter]]></AdditionalInfo>
                </TOC>
            </NSI>';
    }
}
