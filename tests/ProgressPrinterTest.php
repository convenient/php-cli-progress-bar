<?php
class ProgressPrinterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function dontPrintDisabled()
    {
        $this->expectOutputString("");

        $printer = new \Convenient\ProgressPrinter(100);
        $printer->isEnabled(false);

        for ($i=0; $i<100; $i++) {
            $printer->printProgress();
        }
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function printOutOfBounds()
    {
        $this->expectOutputString("=\n%\n");

        $this->setExpectedException('OutOfBoundsException', 'Current count has gone higher than total count');

        $printer = new \Convenient\ProgressPrinter(1, 100);

        $printer->printProgress();
        $printer->printProgress();
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function printOneNotchPer100()
    {
        $printer = new \Convenient\ProgressPrinter(100, 1);

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
        $printer = new \Convenient\ProgressPrinter(100, 10);

        for ($i=0; $i<100; $i++) {
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
        $this->expectOutputString("=\n%");

        $arr = array();
        for ($i = 0; $i<12346; $i++) {
            $arr[] = $i;
        }

        $printer = new \Convenient\ProgressPrinter($arr, 100);
        $printer->printProgress();

        $this->assertEquals(12346, $printer->getTotalCount());
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function initialiseWithTraversable()
    {
        $this->expectOutputString("=\n%");

        $arr = array();
        for ($i = 0; $i<67890; $i++) {
            $arr[] = $i;
        }

        $iterator = new ArrayIterator($arr);

        $printer = new \Convenient\ProgressPrinter($iterator, 100);
        $printer->printProgress();

        $this->assertEquals(67890, $printer->getTotalCount());
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function initialiseWithInteger()
    {
        $printer = new \Convenient\ProgressPrinter(67, 100);
        $this->expectOutputString("=\n%");

        $printer->printProgress();

        $this->assertEquals(67, $printer->getTotalCount());
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function initialiseWithOther()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid total count provided');

        $printer = new \Convenient\ProgressPrinter(new stdClass());
        $printer->printProgress();
    }
}
