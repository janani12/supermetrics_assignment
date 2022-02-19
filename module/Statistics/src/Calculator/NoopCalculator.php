<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class NoopCalculator extends AbstractCalculator
{

    /**
     * @var array
     */
    private $totals = [];

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $author = $postTo->getAuthorId();
        
        $this->totals[ $author ] = ($this->totals[$author] ?? 0) + 1;
    }

    /**
     *  @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
        $count = count($this->totals);
        $value = ($count > 0) 
                    ? array_sum($this->totals) / $count 
                    : 0;
        return (new StatisticsTo())->setValue(round($value));
    }
}
