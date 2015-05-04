<?php
namespace Convenient;

class ProgressPrinter
{
    private $totalCount = 0;
    private $currentCount = 0;
    private $percentPerNotch = 100;
    private $countsPerNotch = false;
    private $enabled = false;

    /**
     * @param int $percentPerNotch
     * @param bool $enabled
     */
    public function __construct($percentPerNotch = 4, $enabled = true)
    {
        $this->percentPerNotch = $percentPerNotch;
        $this->isEnabled($enabled);
        $this->currentCount = 0;
    }

    /**
     * Either pass in a total count value, or a traversable object which will be iterated through, counted, then reset.
     *
     * @param $totalCount
     *
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function initProgressBar($totalCount)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $this->setTotalCount($totalCount);

        $numberOfNotches = ceil(100 / $this->percentPerNotch);
        $this->countsPerNotch  = ceil($this->getTotalCount() / $numberOfNotches);

        for ($i = 0; $i < $numberOfNotches; $i++) {
            echo "=";
        }
        echo "\n";
    }

    /**
     *
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function printProgress()
    {
        if (!$this->isEnabled() || !$this->countsPerNotch) {
            return;
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
}
