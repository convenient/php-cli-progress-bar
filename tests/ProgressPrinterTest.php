<?php
class ProgressPrinterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function printOutOfBounds()
    {
        $this->setExpectedException('OutOfBoundsException', 'Current count has gone higher than total count');

        $printer = new \Convenient\ProgressPrinter();
        $printer->initProgressBar(100);

        for ($i=0; $i<101; $i++) {
            $printer->printProgress();
        }
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function printOneNotchPer100()
    {
        $printer = new \Convenient\ProgressPrinter(1);

        $printer->initProgressBar(100);

        for ($i=0; $i<100; $i++) {
            $printer->printProgress();
        }

        $expectedOutput =
            "====================================================================================================\n" .
            "%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%\n";
        $this->expectOutputString($expectedOutput);
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function print10Notch()
    {
        $printer = new \Convenient\ProgressPrinter(10);

        $totalCount = 100;

        $printer->initProgressBar($totalCount);

        for ($i=0; $i<$totalCount; $i++) {
            $printer->printProgress();
        }

        $expectedOutput =
            "==========\n" .
            "%%%%%%%%%%\n";
        $this->expectOutputString($expectedOutput);
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function initialiseWithArray()
    {
        $printer = new \Convenient\ProgressPrinter(100);
        $this->expectOutputString("=\n");

        $arr = array();
        for ($i = 0; $i<12346; $i++) {
            $arr[] = $i;
        }

        $printer->initProgressBar($arr);

        $this->assertEquals(12346, $printer->getTotalCount());
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function initialiseWithTraversable()
    {
        $printer = new \Convenient\ProgressPrinter(100);
        $this->expectOutputString("=\n");

        $arr = array();
        for ($i = 0; $i<67890; $i++) {
            $arr[] = $i;
        }

        $iterator = new ArrayIterator($arr);

        $printer->initProgressBar($iterator);

        $this->assertEquals(67890, $printer->getTotalCount());
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function initialiseWithInteger()
    {
        $printer = new \Convenient\ProgressPrinter(100);
        $this->expectOutputString("=\n");

        $printer->initProgressBar(67);

        $this->assertEquals(67, $printer->getTotalCount());
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function initialiseWithOther()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid total count provided');

        $printer = new \Convenient\ProgressPrinter();
        $printer->initProgressBar(new stdClass());
    }
}
