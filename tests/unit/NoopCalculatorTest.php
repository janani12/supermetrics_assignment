<?php

declare(strict_types = 1);

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use Statistics\Calculator\NoopCalculator;
use Statistics\Dto\StatisticsTo;


/**
 * Class ATestTest
 *
 * @package Tests\unit
 */
class NoopCalculatorTest extends TestCase
{
    /**
     * @var NoopCalculator
     */
    protected $noopControl;

    /**
     * @var mockdata
     */
    protected $totals;

    protected function setUp():void 
    {
        $this->totals = [
                'user_14' => 4,
                'user_1' => 2,
                'user_3' => 3,
        ];
        $this->noopControl = new NoopCalculator();
    }

    /**
     *@test
     */
    public function testDoCalculateNoop(): void
    {
        $result = $this->invokeNoopMethod( 
                                    $this->noopControl,
                                    'doCalculate'
                                );
        $this->assertInstanceOf(StatisticsTo::class, $result);
        $this->assertNotNull($result->getValue());
    }

    /**
     * @param NoopCalculator $object
     * @param Methodname  $methodName
     * @param Methodparams  $parameters
     *
     * @return StatisticsTo
     */
    public function invokeNoopMethod(&$object, $methodName, array $parameters = array()) : StatisticsTo
    {
        $reflection = new \ReflectionClass(get_class($object));

        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        $reflectionProperty = $reflection->getProperty('totals');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $this->totals);

        return $method->invokeArgs($object, $parameters);
    }
}
