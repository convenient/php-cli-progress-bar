<?php
namespace Convenient;

class ProgressPrinter
{
    private $totalCount = 0;
    private $currentCount = 0;
    private $countsPerNotch = false;
    private $enabled = false;
    /**
     * @param bool $enabled
     */
    public function __construct($enabled = false)
    {
        $this->enabled = $enabled;
        $this->currentCount = 0;
    }
    /**
     * @param $totalCount
     *
     * @author Luke Rodgers <lr@amp.co>
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
        }
        $percentPerNotch = 4;
        $numberOfNotches = ceil(100 / $percentPerNotch);
        $this->countsPerNotch   = ceil($this->totalCount / $numberOfNotches);
        for ($i = 0; $i < $numberOfNotches; $i++) {
            echo "_";
        }
        echo "\n";
    }
    /**
     *
     * @author Luke Rodgers <lr@amp.co>
     */
    public function printProgress()
    {
        if (!$this->enabled) {
            return;
        }
        if (($this->currentCount++ % $this->countsPerNotch == 0)) {
            echo "%";
        }
    }
    /**
     *
     * @author Luke Rodgers <lr@amp.co>
     */
    public function closeProgressBar()
    {
        if ($this->enabled) {
            return;
        }
        echo "\n";
    }
}
