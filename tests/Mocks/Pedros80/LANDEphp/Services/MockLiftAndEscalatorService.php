<?php

declare(strict_types=1);

namespace Tests\Mocks\Pedros80\LANDEphp\Services;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Pedros80\LANDEphp\Contracts\LiftsAndEscalators;
use function Safe\json_decode;
use stdClass;

final class MockLiftAndEscalatorService implements LiftsAndEscalators
{
    public function getAssetsByStationCode(string $station, string $token): stdClass
    {
        $data = match($station) {
            'EDB'   => '{"data":{"assets":[{"blockId":null,"description":"Platform 11","crs":"EDB","type":"Lift","location":"Platform 11","id":"1160","displayName":"Lift, Main Concourse (Platfoms 2-19)","sensorId":"2009","prn":"85889000475","status":{"status":"Available","sensorId":"2009","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"Platform 8 & 9","crs":"EDB","type":"Lift","location":"Platform 8 & 9","id":"1161","displayName":"Lift, Platforms 8&9","sensorId":"2049","prn":"85889000476","status":{"status":"Available","sensorId":"2049","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"Car Park","crs":"EDB","type":"Lift","location":"Car Park","id":"1162","displayName":"Lift, Car Park ","sensorId":"2010","prn":"85889000477","status":{"status":"Available","sensorId":"2010","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"Car Park to Bridge","crs":"EDB","type":"Lift","location":"Car Park to Bridge","id":"1163","displayName":"Lift, New Street Car Park and Market Street to footbridge ","sensorId":"2047","prn":"85889000478","status":{"status":"Available","sensorId":"2047","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"Platform 10","crs":"EDB","type":"Lift","location":"Platform 10","id":"1164","displayName":"Lift, Platform 10","sensorId":"2048","prn":"85889000479","status":{"status":"Unknown","sensorId":"2048","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"Lift 1, Platform 20 (Steps)","crs":"EDB","type":"Lift","location":"Platform 20 (Steps)","id":"1166","displayName":"Lift 1, Platform 20, Footbridge, towards Princes Street","sensorId":"7518","prn":"85889000490","status":{"status":"Available","sensorId":"7518","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"Lift 2, Platform 20 (Steps)","crs":"EDB","type":"Lift","location":"Platform 20 (Steps)","id":"1167","displayName":"Lift 2, Platform 20, Footbridge, towards Princes Street","sensorId":"7519","prn":"85889000491","status":{"status":"Available","sensorId":"7519","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"North West Lift (Station Building)","crs":"EDB","type":"Lift","location":"Station Building","id":"1168","displayName":"Lift, towards Princes Street ","sensorId":"7069","prn":"85889000492","status":{"status":"Available","sensorId":"7069","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"Platform 19","crs":"EDB","type":"Lift","location":"Platform 19","id":"1170","displayName":"Lift, Platform 19, Footbridge towards Princes St","sensorId":"2008","prn":"85889000494","status":{"status":"Available","sensorId":"2008","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"Lift 1 Carlton Road Bridge","crs":"EDB","type":"Lift","location":"Carlton Road Bridge","id":"1171","displayName":"Lift 1, Carlton Road Bridge","sensorId":"2006","prn":"85889000496","status":{"status":"Available","sensorId":"2006","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"Lift 2 Carlton Road Bridge","crs":"EDB","type":"Lift","location":"Carlton Road Bridge","id":"1172","displayName":"Lift 2, Carlton Road Bridge","sensorId":"2007","prn":"85889000497","status":{"status":"Available","sensorId":"2007","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"E10 Platform 11","crs":"EDB","type":"Escalator","location":"Platform 11","id":"1173","displayName":"Escalator 10, Platform 11 Down","sensorId":"7526","prn":"1316417","status":{"status":"Available","sensorId":"7526","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"E5","crs":"EDB","type":"Escalator","location":"","id":"2654","displayName":"Escalator 5, concourse","sensorId":"7516","prn":"1316401","status":{"status":"Not Available","sensorId":"7516","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"E6","crs":"EDB","type":"Escalator","location":"","id":"2655","displayName":"Escalator 6, concourse","sensorId":"7517","prn":"1316402","status":{"status":"Available","sensorId":"7517","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"E1 Waverley Steps","crs":"EDB","type":"Escalator","location":"Waverley Steps","id":"2656","displayName":"Escalator 1, Waverley Steps","sensorId":"7511","prn":"1316403","status":{"status":"Available","sensorId":"7511","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"E2 Waverley Steps","crs":"EDB","type":"Escalator","location":"Waverley Steps","id":"2657","displayName":"Escalator 2, Waverley Steps","sensorId":"7510","prn":"1316408","status":{"status":"Available","sensorId":"7510","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"E3 Waverley Steps","crs":"EDB","type":"Escalator","location":"Waverley Steps","id":"2658","displayName":"Escalator 3, Waverley Steps","sensorId":"7512","prn":"1316409","status":{"status":"Available","sensorId":"7512","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"E4 Waverley Steps","crs":"EDB","type":"Escalator","location":"Waverley Steps","id":"2659","displayName":"Escalator 4, Waverley Steps","sensorId":"7513","prn":"1316410","status":{"status":"Available","sensorId":"7513","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"E7 Waverley Steps","crs":"EDB","type":"Escalator","location":"Waverley Steps","id":"2660","displayName":"Escalator 7, Waverley Steps","sensorId":"7514","prn":"1316411","status":{"status":"Available","sensorId":"7514","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"E8 Waverley Steps","crs":"EDB","type":"Escalator","location":"Waverley Steps","id":"2661","displayName":"Escalator 8, Waverley Steps","sensorId":"7515","prn":"1316413","status":{"status":"Unknown","sensorId":"7515","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"E9 Platform 11 Up","crs":"EDB","type":"Escalator","location":"Platform 11","id":"2662","displayName":"Escalator 9, Platform 11 Up","sensorId":"7525","prn":"1316416","status":{"status":"Available","sensorId":"7525","isolated":false,"engineerOnSite":false,"independent":false}},{"blockId":null,"description":"Platform 1","crs":"EDB","type":"Lift","location":"Platform 1","id":"1165","displayName":"Lift, Platform 1, Footbridge, towards Princes Street","sensorId":null,"prn":"85889000480","status":null},{"blockId":null,"description":"Lift, First Class Lounge","crs":"EDB","type":"Lift","location":null,"id":"3292","displayName":"Lift,","sensorId":"2005","prn":"85889000498","status":{"status":"Unknown","sensorId":"2005","isolated":false,"engineerOnSite":false,"independent":false}}]}}',
            'DAM'   => '{"data":{"assets":[]}}',
            'KGX'   => '{"errors":[{"message":"rate limit of 15 exceeded","extensions":{"path":"$","code":"rate-limit-exceeded"}}]}',
            default => '{"data":{"assets":[]}}',
        };

        return json_decode($data);
    }

    public function getAssetInfoById(int $id, string $token): stdClass
    {
        $data = match($id) {
            1160    => '{"data":{"assets":[{"blockId":null,"description":"Platform 11","crs":"EDB","type":"Lift","location":"Platform 11","id":"1160","displayName":"Lift, Main Concourse (Platfoms 2-19)","sensorId":"2009","prn":"85889000475","status":{"status":"Available","sensorId":"2009","isolated":false,"engineerOnSite":false,"independent":false}}]}}',
            9999    => '{"data":{"assets":[]}}',
            10000   => '{"errors":[{"message":"rate limit of 15 exceeded","extensions":{"path":"$","code":"rate-limit-exceeded"}}]}',
            default => '{"data":{"assets":[]}}',
        };

        return json_decode($data);
    }

    public function getSensorInfoById(int $id, string $token): stdClass
    {
        $data = match ($id) {
            2005    => '{"status":[{"sensorId":"2005","isolated":false,"status":"Unknown","independent":false,"engineerOnSite":false}]}',
            9999    => '{"status":[]}',
            10000   => '{"errors":[{"message":"rate limit of 15 exceeded","extensions":{"path":"$","code":"rate-limit-exceeded"}}]}',
            default => throw new ClientException('Error', new Request('POST', ''), new Response(401, [], '{"error":"Access denied due to invalid subscription key"}')),
        };

        return json_decode($data);
    }

    public function getSensors(string $token, int $num = 50, int $offset = 0): stdClass
    {
        $data = match ($num) {
            1       => '{"status":[{"sensorId":"89","isolated":false,"status":"Not Available","independent":false,"engineerOnSite":false}]}',
            9999    => '{"status":[]}',
            10000   => '{"errors":[{"message":"rate limit of 15 exceeded","extensions":{"path":"$","code":"rate-limit-exceeded"}}]}',
            default => throw new ClientException('Error', new Request('POST', ''), new Response(401, [], '{"error":"Access denied due to invalid subscription key"}')),
        };

        return json_decode($data);
    }
}
