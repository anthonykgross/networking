<?php
namespace Networking\Tests;

use Networking\Host;
use Networking\Network;

class NetworkTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $this->assertInstanceOf(Network::class, new Network(new Host()));
    }

    public function testTraceRoute()
    {
        $host = new Host();
        $host->setIp('34.194.78.64');

        $ip = new Network($host);
        $this->assertCount(30, $ip->traceRoute());
    }
}