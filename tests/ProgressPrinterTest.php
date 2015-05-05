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

        $printer = new \Convenient\ProgressPrinter(1, 1);

        $printer->printProgress();
        $printer->printProgress();
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function print100Wide()
    {
        $printer = new \Convenient\ProgressPrinter(200, 100);

        for ($i=0; $i<200; $i++) {
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
        $printer = new \Convenient\ProgressPrinter(1, 10);

        $printer->printProgress();

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
        $arr = array();
        for ($i = 0; $i<12346; $i++) {
            $arr[] = $i;
        }

        $printer = new \Convenient\ProgressPrinter($arr);

        $this->assertEquals(12346, $printer->getTotalCount());
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function initialiseWithTraversable()
    {
        $arr = array();
        for ($i = 0; $i<67890; $i++) {
            $arr[] = $i;
        }

        $iterator = new ArrayIterator($arr);

        $printer = new \Convenient\ProgressPrinter($iterator);

        $this->assertEquals(67890, $printer->getTotalCount());
    }

    /**
     * @test
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function initialiseWithInteger()
    {
        $printer = new \Convenient\ProgressPrinter(67);

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
