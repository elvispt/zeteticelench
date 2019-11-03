<?php

namespace Tests\Unit;

use App\Libraries\SysInfo\SysInfo;
use Tests\TestCase;

class SysInfoTest extends TestCase
{
    public function testUpTimeIsReturned()
    {
        $sysInfo = new SysInfo();
        $up = $sysInfo->up();
        $this->assertIsString($up);
        $this->assertTrue(strlen($up) > 0);
    }

    public function testUpSinceIsReturned()
    {
        $sysInfo = new SysInfo();
        $upSince = $sysInfo->upSince();
        $this->assertIsString($upSince);
        $this->assertTrue(strlen($upSince) > 0);
        $this->assertIsInt(strtotime($upSince));
    }

    public function testMemoryInfoIsReturned()
    {
        $sysInfo = new SysInfo();
        $memory = $sysInfo->memory();
        $this->assertIsArray($memory);
        $this->assertArrayHasKey('total', $memory);
        $this->assertArrayHasKey('used', $memory);
        $this->assertArrayHasKey('free', $memory);
        $this->assertArrayHasKey('shared', $memory);
        $this->assertArrayHasKey('buffCache', $memory);
        $this->assertArrayHasKey('available', $memory);
    }

    public function testAllInfoReturned()
    {
        $sysInfo = new SysInfo();
        $all = $sysInfo->all();
        $this->assertIsArray($all);
        $this->assertArrayHasKey('up', $all);
        $this->assertArrayHasKey('upSince', $all);
        $this->assertArrayHasKey('memory', $all);
    }

    public function testNumberOfQueueWorkersRunning()
    {
        $sysInfo = new SysInfo();
        $nWorkers = $sysInfo->nQueueWorkersRunning();
        $this->assertIsInt($nWorkers);
        $this->assertTrue($nWorkers >= 0);
    }
}
