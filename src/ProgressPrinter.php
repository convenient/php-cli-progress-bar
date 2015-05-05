<?php
namespace Convenient;

class ProgressPrinter
{
    private $totalCount = 0;
    private $currentCount = 0;
    private $percentPerNotch = 100;
    private $countsPerNotch = false;
    private $enabled = false;
    private $isInitialised = false;

    /**
     * Either pass in a total count value, or a traversable object which will be iterated through, counted, then reset.
     *
     * @param $totalCount
     * @param int $percentPerNotch
     * @param bool $enabled
     */
    public function __construct($totalCount, $percentPerNotch = 4, $enabled = true)
    {
        $this->setTotalCount($totalCount);
        $this->isEnabled($enabled);
        $this->percentPerNotch = $percentPerNotch;
        $this->currentCount = 0;
    }

    /**
     *
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    private function initProgressBar()
    {
        $numberOfNotches = ceil(100 / $this->percentPerNotch);
        $this->countsPerNotch  = ceil($this->getTotalCount() / $numberOfNotches);

        for ($i = 0; $i < $numberOfNotches; $i++) {
            echo "=";
        }
        echo "\n";

        $this->isInitialised(true);
    }

    /**
     *
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function printProgress()
    {
        if (!$this->isEnabled()) {
            return;
        }
        if (!$this->isInitialised()) {
            $this->initProgressBar();
        }
        if ($this->currentCount >= $this->getTotalCount()) {
            throw new \OutOfBoundsException("Current count has gone higher than total count");
        }
        if (($this->currentCount++ % $this->countsPerNotch == 0)) {
            echo "%";
        }
        if ($this->currentCount == $this->getTotalCount()) {
            echo "\n";
        }
    }

    /**
     * @param $totalCount
     *
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    private function setTotalCount($totalCount)
    {
        if (is_array($totalCount) || $totalCount instanceof \Traversable) {
            foreach ($totalCount as $obj) {
                $this->totalCount ++;
            }
            reset($totalCount);
        } elseif (is_numeric($totalCount)) {
            $this->totalCount = intval($totalCount);
        } else {
            throw new \InvalidArgumentException("Invalid total count provided\n");
        }
    }

    /**
     * @return int
     *
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @param null $boolean
     * @return bool|null
     *
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function isEnabled($boolean = null)
    {
        if (!is_null($boolean)) {
            $this->enabled = (bool)$boolean;
        }
        return $this->enabled;
    }

    /**
     * @param null $boolean
     * @return bool
     *
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    private function isInitialised($boolean = null)
    {
        if (!is_null($boolean)) {
            $this->isInitialised = (bool)$boolean;
        }
        return $this->isInitialised;
    }
}
