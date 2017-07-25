<?php
namespace Networking\Tests;

use Networking\IP;

class IPTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $this->assertInstanceOf(IP::class, new IP('fe80::48fa:f0ff:fecf:5b75'));
    }

    public function testCheckIp()
    {
        $ip = new IP('fe80::48fa:f0ff:fecf:5b75');
        $this->assertEquals('fe80::48fa:f0ff:fecf:5b75', $ip->getIp());
        $this->assertEquals('IPV6', $ip->getType());
        $this->assertEquals(true, $ip->isValid());
        $this->assertEquals(true, $ip->isPrivate());
        $this->assertEquals(false, $ip->isReserved());
        $this->assertEquals(false, $ip->isLocal());

        $ip = new IP('::1');
        $this->assertEquals('::1', $ip->getIp());
        $this->assertEquals('IPV6', $ip->getType());
        $this->assertEquals(true, $ip->isValid());
        $this->assertEquals(true, $ip->isPrivate());
        $this->assertEquals(false, $ip->isReserved());
        $this->assertEquals(true, $ip->isLocal());

        $ip = new IP('127.0.0.1');
        $this->assertEquals('127.0.0.1', $ip->getIp());
        $this->assertEquals('IPV4', $ip->getType());
        $this->assertEquals(true, $ip->isValid());
        $this->assertEquals(true, $ip->isPrivate());
        $this->assertEquals(false, $ip->isReserved());
        $this->assertEquals(true, $ip->isLocal());

        $ip = new IP('192.168.1.81');
        $this->assertEquals('192.168.1.81', $ip->getIp());
        $this->assertEquals('IPV4', $ip->getType());
        $this->assertEquals(true, $ip->isValid());
        $this->assertEquals(false, $ip->isPrivate());
        $this->assertEquals(true, $ip->isReserved());
        $this->assertEquals(false, $ip->isLocal());

        $ip = new IP('10.0.0.10');
        $this->assertEquals('10.0.0.10', $ip->getIp());
        $this->assertEquals('IPV4', $ip->getType());
        $this->assertEquals(true, $ip->isValid());
        $this->assertEquals(false, $ip->isPrivate());
        $this->assertEquals(true, $ip->isReserved());
        $this->assertEquals(false, $ip->isLocal());
    }
}