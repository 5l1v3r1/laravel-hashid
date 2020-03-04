<?php

namespace ElfSundae\Laravel\Hashid\Test;

use ElfSundae\Laravel\Hashid\OptimusDriver;
use Jenssegers\Optimus\Energon;
use Jenssegers\Optimus\Optimus;

class OptimusDriverTest extends DriverTestCase
{
    protected $driver = OptimusDriver::class;

    protected $maxInteger = 2 ** Optimus::DEFAULT_SIZE - 1;

    public function testInstantiation()
    {
        $this->assertInstanceOf($this->driver, $this->makeDriver($this->getConfig()));
    }

    public function testExceptionCreatingWithEmptyConfig()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('prime and inverse must be specified.');
        $this->makeDriver();
    }

    public function testExceptionCreatingWithInvalidPrime()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('prime and inverse must be specified.');
        $this->makeDriver(['prime' => null]);
    }

    public function testExceptionCreatingWithInvalidInverse()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('prime and inverse must be specified.');
        $this->makeDriver(['inverse' => null]);
    }

    public function testEncoding()
    {
        $this->assertEncodedData(20, 1535832388, ['prime' => 1580030173, 'inverse' => 59260789, 'random' => 0]);
        $this->runForIntegersWith(0, $this->maxInteger, $this->getConfig());
        $this->assertUniformEncoding(random_int(0, $this->maxInteger), $this->getConfig());
    }

    protected function getConfig($prime = null)
    {
        return array_combine(['prime', 'inverse', 'random'], Energon::generate($prime));
    }
}
