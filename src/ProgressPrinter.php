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
        $this->enabled = $enabled;
        $this->currentCount = 0;
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
            $this->enabled = ($boolean);
        }
        return $this->enabled;
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
        if (!$this->enabled) {
            return;
        }

        if ($totalCount instanceof \Traversable) {
            foreach ($totalCount as $obj) {
                $this->totalCount ++;
            }
            reset($totalCount);
        } else {
            $this->totalCount = intval($totalCount);
        }

        $numberOfNotches = ceil(100 / $this->percentPerNotch);
        $this->countsPerNotch   = ceil($this->totalCount / $numberOfNotches);

        for ($i = 0; $i < $numberOfNotches; $i++) {
            echo "_";
        }
        echo "\n";
    }

    /**
     *
     * @author Luke Rodgers <lukerodgers90@gmail.com>
     */
    public function printProgress()
    {
        if (!$this->enabled && $this->countsPerNotch) {
            return;
        }
        if (($this->currentCount++ % $this->countsPerNotch == 0)) {
            echo "%";
        }
        if ($this->currentCount == $this->totalCount) {
            echo "\n";
        }
    }
}
