<?php

declare(strict_types=1);

namespace Tests\Mocks\Pedros80\NREphp\Services;

use Pedros80\NREphp\Contracts\Boards;
use function Safe\json_decode;
use stdClass;

final class MockLiveDepartureBoard implements Boards
{
    private function getDeparturesNoCalllingPoints(stdClass $data): stdClass
    {
        unset($data->GetStationBoardResult->trainServices->service[0]->subsequentCallingPoints);

        return $data;
    }

    private function getDeparturesOneCalllingPoint(stdClass $data): stdClass
    {
        $list  = $data->GetStationBoardResult->trainServices->service[0]->subsequentCallingPoints->callingPointList;
        $point = $list[0]->callingPoint[0];

        $list[0]->callingPoint = [$point];

        $data->GetStationBoardResult->trainServices->service[0]->subsequentCallingPoints->callingPointList = $list;

        return $data;
    }

    public function getDepBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {

        $data = json_decode('{"GetStationBoardResult":{"nrcMessages":{"message":[{"_":"things"}]},"generatedAt":"2023-09-01T17:39:42.4755104+01:00","locationName":"Dalmeny","crs":"DAM","platformAvailable":true,"trainServices":{"service":[{"std":"17:39","etd":"Cancelled","operator":"ScotRail","operatorCode":"SR","isCancelled":true,"serviceType":"train","cancelReason":"This train has been cancelled because of a shortage of train crew","serviceID":"1946536DLMY____","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Cowdenbeath","crs":"COW"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"North Queensferry","crs":"NQU","st":"17:42","et":"Cancelled"},{"locationName":"Inverkeithing","crs":"INK","st":"17:46","et":"Cancelled"},{"locationName":"Rosyth","crs":"ROS","st":"17:50","et":"Cancelled"},{"locationName":"Dunfermline Town","crs":"DFE","st":"17:55","et":"Cancelled"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"17:58","et":"Cancelled"},{"locationName":"Cowdenbeath","crs":"COW","st":"18:06","et":"Cancelled"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"std":"17:44","etd":"On time","platform":"1","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1946452DLMY____","origin":{"location":[{"locationName":"Glenrothes with Thornton","crs":"GLT"}]},"destination":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Edinburgh Gateway","crs":"EGY","st":"17:50","et":"On time"},{"locationName":"South Gyle","crs":"SGL","st":"17:52","et":"On time"},{"locationName":"Haymarket","crs":"HYM","st":"17:59","et":"On time"},{"locationName":"Edinburgh","crs":"EDB","st":"18:04","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"std":"17:55","etd":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1945983DLMY____","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Perth","crs":"PTH","via":"via Kirkcaldy"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"North Queensferry","crs":"NQU","st":"17:59","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"18:03","et":"On time"},{"locationName":"Dalgety Bay","crs":"DAG","st":"18:06","et":"On time"},{"locationName":"Aberdour","crs":"AUR","st":"18:11","et":"On time"},{"locationName":"Burntisland","crs":"BTS","st":"18:15","et":"On time"},{"locationName":"Kinghorn","crs":"KGH","st":"18:20","et":"On time"},{"locationName":"Kirkcaldy","crs":"KDY","st":"18:25","et":"On time"},{"locationName":"Markinch","crs":"MNC","st":"18:34","et":"On time"},{"locationName":"Ladybank","crs":"LDY","st":"18:42","et":"On time"},{"locationName":"Perth","crs":"PTH","st":"19:10","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"std":"18:04","etd":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1946454DLMY____","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Glenrothes with Thornton","crs":"GLT"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"North Queensferry","crs":"NQU","st":"18:08","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"18:11","et":"On time"},{"locationName":"Rosyth","crs":"ROS","st":"18:15","et":"On time"},{"locationName":"Dunfermline Town","crs":"DFE","st":"18:20","et":"On time"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"18:27","et":"On time"},{"locationName":"Cowdenbeath","crs":"COW","st":"18:34","et":"On time"},{"locationName":"Lochgelly","crs":"LCG","st":"18:40","et":"On time"},{"locationName":"Cardenden","crs":"CDD","st":"18:43","et":"On time"},{"locationName":"Glenrothes with Thornton","crs":"GLT","st":"18:51","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"std":"18:25","etd":"On time","platform":"1","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1946502DLMY____","origin":{"location":[{"locationName":"Cowdenbeath","crs":"COW"}]},"destination":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Edinburgh Gateway","crs":"EGY","st":"18:30","et":"On time"},{"locationName":"Haymarket","crs":"HYM","st":"18:38","et":"On time"},{"locationName":"Edinburgh","crs":"EDB","st":"18:46","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"std":"18:36","etd":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1946537DLMY____","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Cowdenbeath","crs":"COW"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"North Queensferry","crs":"NQU","st":"18:39","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"18:43","et":"On time"},{"locationName":"Rosyth","crs":"ROS","st":"18:47","et":"On time"},{"locationName":"Dunfermline Town","crs":"DFE","st":"18:52","et":"On time"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"18:56","et":"On time"},{"locationName":"Cowdenbeath","crs":"COW","st":"19:03","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"std":"18:43","etd":"On time","platform":"1","operator":"ScotRail","operatorCode":"SR","serviceType":"train","length":2,"serviceID":"1946456DLMY____","origin":{"location":[{"locationName":"Glenrothes with Thornton","crs":"GLT"}]},"destination":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Edinburgh Gateway","crs":"EGY","st":"18:48","et":"On time","length":2},{"locationName":"South Gyle","crs":"SGL","st":"18:51","et":"On time","length":2},{"locationName":"Haymarket","crs":"HYM","st":"18:57","et":"On time","length":2},{"locationName":"Edinburgh","crs":"EDB","st":"19:03","et":"On time","length":2}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"std":"19:11","etd":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1946492DLMY____","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Glenrothes with Thornton","crs":"GLT"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"North Queensferry","crs":"NQU","st":"19:15","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"19:18","et":"On time"},{"locationName":"Rosyth","crs":"ROS","st":"19:22","et":"On time"},{"locationName":"Dunfermline Town","crs":"DFE","st":"19:27","et":"On time"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"19:31","et":"On time"},{"locationName":"Cowdenbeath","crs":"COW","st":"19:37","et":"On time"},{"locationName":"Lochgelly","crs":"LCG","st":"19:43","et":"On time"},{"locationName":"Cardenden","crs":"CDD","st":"19:46","et":"On time"},{"locationName":"Glenrothes with Thornton","crs":"GLT","st":"19:54","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"std":"19:28","etd":"Cancelled","operator":"ScotRail","operatorCode":"SR","isCancelled":true,"serviceType":"train","cancelReason":"This train has been cancelled because of a shortage of train crew","serviceID":"1946504DLMY____","origin":{"location":[{"locationName":"Cowdenbeath","crs":"COW"}]},"destination":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Edinburgh Gateway","crs":"EGY","st":"19:34","et":"Cancelled"},{"locationName":"Haymarket","crs":"HYM","st":"19:41","et":"Cancelled"},{"locationName":"Edinburgh","crs":"EDB","st":"19:48","et":"Cancelled"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"std":"19:36","etd":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1946538DLMY____","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Glenrothes with Thornton","crs":"GLT"}]},"subsequentCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"North Queensferry","crs":"NQU","st":"19:39","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"19:43","et":"On time"},{"locationName":"Rosyth","crs":"ROS","st":"19:47","et":"On time"},{"locationName":"Dunfermline Town","crs":"DFE","st":"19:52","et":"On time"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"19:56","et":"On time"},{"locationName":"Cowdenbeath","crs":"COW","st":"20:02","et":"On time"},{"locationName":"Lochgelly","crs":"LCG","st":"20:08","et":"On time"},{"locationName":"Cardenden","crs":"CDD","st":"20:12","et":"On time"},{"locationName":"Glenrothes with Thornton","crs":"GLT","st":"20:20","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}}]}}}');

        if ($crs === 'GTW') {
            return $this->getDeparturesNoCalllingPoints($data);
        }

        if ($crs === 'EDB') {
            return $this->getDeparturesOneCalllingPoint($data);
        }

        return $data;
    }

    public function getArrBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return json_decode('{"GetStationBoardResult":{"generatedAt":"2023-09-01T20:49:37.1378848+01:00","locationName":"Dalmeny","crs":"DAM","platformAvailable":true,"trainServices":{"service":[{"sta":"21:07","eta":"On time","platform":"1","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1939969DLMY____","origin":{"location":[{"locationName":"Dundee","crs":"DEE"}]},"destination":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"previousCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Dundee","crs":"DEE","st":"19:53","at":"On time"},{"locationName":"Leuchars","crs":"LEU","st":"20:05","at":"No report"},{"locationName":"Cupar","crs":"CUP","st":"20:12","at":"On time"},{"locationName":"Ladybank","crs":"LDY","st":"20:20","at":"On time"},{"locationName":"Markinch","crs":"MNC","st":"20:27","at":"20:29"},{"locationName":"Kirkcaldy","crs":"KDY","st":"20:37","at":"20:39"},{"locationName":"Kinghorn","crs":"KGH","st":"20:42","at":"On time"},{"locationName":"Burntisland","crs":"BTS","st":"20:47","et":"20:49"},{"locationName":"Aberdour","crs":"AUR","st":"20:51","et":"20:53"},{"locationName":"Dalgety Bay","crs":"DAG","st":"20:56","et":"20:58"},{"locationName":"Inverkeithing","crs":"INK","st":"20:59","et":"21:01"},{"locationName":"North Queensferry","crs":"NQU","st":"21:03","et":"21:05"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"sta":"21:17","eta":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1945921DLMY____","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Dundee","crs":"DEE"}]},"previousCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Edinburgh","crs":"EDB","st":"21:00","et":"On time"},{"locationName":"Haymarket","crs":"HYM","st":"21:04","et":"On time"},{"locationName":"South Gyle","crs":"SGL","st":"21:09","et":"On time"},{"locationName":"Edinburgh Gateway","crs":"EGY","st":"21:11","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"sta":"21:25","eta":"On time","platform":"1","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1946510DLMY____","origin":{"location":[{"locationName":"Glenrothes with Thornton","crs":"GLT"}]},"destination":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"previousCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Glenrothes with Thornton","crs":"GLT","st":"20:43","at":"20:30"},{"locationName":"Cardenden","crs":"CDD","st":"20:50","et":"On time"},{"locationName":"Lochgelly","crs":"LCG","st":"20:54","et":"On time"},{"locationName":"Cowdenbeath","crs":"COW","st":"21:00","et":"On time"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"21:06","et":"On time"},{"locationName":"Dunfermline Town","crs":"DFE","st":"21:09","et":"On time"},{"locationName":"Rosyth","crs":"ROS","st":"21:13","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"21:17","et":"On time"},{"locationName":"North Queensferry","crs":"NQU","st":"21:21","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"sta":"21:35","eta":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1946541DLMY____","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Glenrothes with Thornton","crs":"GLT"}]},"previousCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Edinburgh","crs":"EDB","st":"21:18","et":"On time"},{"locationName":"Haymarket","crs":"HYM","st":"21:22","et":"On time"},{"locationName":"South Gyle","crs":"SGL","st":"21:27","et":"On time"},{"locationName":"Edinburgh Gateway","crs":"EGY","st":"21:29","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"sta":"21:58","eta":"On time","platform":"1","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1940693DLMY____","origin":{"location":[{"locationName":"Dundee","crs":"DEE"}]},"destination":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"previousCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Dundee","crs":"DEE","st":"20:44","at":"On time"},{"locationName":"Leuchars","crs":"LEU","st":"20:57","et":"On time"},{"locationName":"Cupar","crs":"CUP","st":"21:04","et":"On time"},{"locationName":"Ladybank","crs":"LDY","st":"21:11","et":"On time"},{"locationName":"Markinch","crs":"MNC","st":"21:18","et":"On time"},{"locationName":"Kirkcaldy","crs":"KDY","st":"21:29","et":"On time"},{"locationName":"Kinghorn","crs":"KGH","st":"21:33","et":"On time"},{"locationName":"Burntisland","crs":"BTS","st":"21:38","et":"On time"},{"locationName":"Aberdour","crs":"AUR","st":"21:42","et":"On time"},{"locationName":"Dalgety Bay","crs":"DAG","st":"21:47","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"21:51","et":"On time"},{"locationName":"North Queensferry","crs":"NQU","st":"21:55","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"sta":"22:17","eta":"Cancelled","operator":"ScotRail","operatorCode":"SR","isCancelled":true,"serviceType":"train","cancelReason":"This train has been cancelled because of a broken down train","serviceID":"1945706DLMY____","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Dundee","crs":"DEE"}]},"previousCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Edinburgh","crs":"EDB","st":"22:00","et":"Cancelled"},{"locationName":"Haymarket","crs":"HYM","st":"22:04","et":"Cancelled"},{"locationName":"South Gyle","crs":"SGL","st":"22:09","et":"Cancelled"},{"locationName":"Edinburgh Gateway","crs":"EGY","st":"22:11","et":"Cancelled"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"sta":"22:17","eta":"On time","platform":"1","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1946513DLMY____","origin":{"location":[{"locationName":"Glenrothes with Thornton","crs":"GLT"}]},"destination":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"previousCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Glenrothes with Thornton","crs":"GLT","st":"21:35","et":"On time"},{"locationName":"Cardenden","crs":"CDD","st":"21:42","et":"On time"},{"locationName":"Lochgelly","crs":"LCG","st":"21:46","et":"On time"},{"locationName":"Cowdenbeath","crs":"COW","st":"21:52","et":"On time"},{"locationName":"Dunfermline Queen Margaret","crs":"DFL","st":"21:58","et":"On time"},{"locationName":"Dunfermline Town","crs":"DFE","st":"22:01","et":"On time"},{"locationName":"Rosyth","crs":"ROS","st":"22:05","et":"On time"},{"locationName":"Inverkeithing","crs":"INK","st":"22:10","et":"On time"},{"locationName":"North Queensferry","crs":"NQU","st":"22:14","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}},{"sta":"22:33","eta":"On time","platform":"2","operator":"ScotRail","operatorCode":"SR","serviceType":"train","serviceID":"1940780DLMY____","origin":{"location":[{"locationName":"Edinburgh","crs":"EDB"}]},"destination":{"location":[{"locationName":"Glenrothes with Thornton","crs":"GLT"}]},"previousCallingPoints":{"callingPointList":[{"callingPoint":[{"locationName":"Edinburgh","crs":"EDB","st":"22:16","et":"On time"},{"locationName":"Haymarket","crs":"HYM","st":"22:20","et":"On time"},{"locationName":"South Gyle","crs":"SGL","st":"22:25","et":"On time"},{"locationName":"Edinburgh Gateway","crs":"EGY","st":"22:27","et":"On time"}],"serviceType":"train","serviceChangeRequired":false,"assocIsCancelled":false}]}}]}}}');
    }

    public function getArrDepBoardWithDetails(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return (object) [];
    }

    public function getArrivalBoard(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return (object) [];
    }

    public function getArrivalDepartureBoard(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return (object) [];
    }

    public function getDepartureBoard(
        int $numRows,
        string $crs,
        ?string $filterCrs = null,
        ?string $filterType = null,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return (object) [];
    }

    public function getFastestDepartures(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return (object) [];
    }

    public function getFastestDeparturesWithDetails(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return (object) [];
    }

    public function getNextDepartures(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return (object) [];
    }

    public function getNextDeparturesWithDetails(
        string $crs,
        array $filterList,
        ?int $timeOffset = null,
        ?int $timeWindow = null
    ): stdClass {
        return (object) [];
    }

    public function getServiceDetails(string $serviceID): stdClass
    {
        return (object) [];
    }
}
