<?php

namespace olcaytaner\Math;

use PHPUnit\Framework\TestCase;

class DiscreteDistributionTest extends TestCase
{
    private $smallDistribution;

    public function setUp(): void
    {
        $this->smallDistribution = new DiscreteDistribution();
        $this->smallDistribution->addItem("item1");
        $this->smallDistribution->addItem("item2");
        $this->smallDistribution->addItem("item3");
        $this->smallDistribution->addItem("item1");
        $this->smallDistribution->addItem("item2");
        $this->smallDistribution->addItem("item1");
    }

    public function testAddItem()
    {
        $this->assertEquals(3, $this->smallDistribution->getCount("item1"));
        $this->assertEquals(2, $this->smallDistribution->getCount("item2"));
        $this->assertEquals(1, $this->smallDistribution->getCount("item3"));
    }

    public function testRemoveItem()
    {
        $this->smallDistribution->removeItem("item1");
        $this->smallDistribution->removeItem("item2");
        $this->smallDistribution->removeItem("item3");
        $this->assertEquals(2, $this->smallDistribution->getCount("item1"));
        $this->assertEquals(1, $this->smallDistribution->getCount("item2"));
        $this->smallDistribution->addItem("item1");
        $this->smallDistribution->addItem("item2");
        $this->smallDistribution->addItem("item3");
    }

    public function testAddDistribution()
    {
        $discreteDistribution = new DiscreteDistribution();
        $discreteDistribution->addItem("item4");
        $discreteDistribution->addItem("item5");
        $discreteDistribution->addItem("item5");
        $discreteDistribution->addItem("item2");
        $this->smallDistribution->addDistribution($discreteDistribution);
        $this->assertEquals(3, $this->smallDistribution->getCount("item1"));
        $this->assertEquals(3, $this->smallDistribution->getCount("item2"));
        $this->assertEquals(1, $this->smallDistribution->getCount("item3"));
        $this->assertEquals(1, $this->smallDistribution->getCount("item4"));
        $this->assertEquals(2, $this->smallDistribution->getCount("item5"));
    }

    public function testRemoveDistribution()
    {
        $discreteDistribution = new DiscreteDistribution();
        $discreteDistribution->addItem("item1");
        $discreteDistribution->addItem("item1");
        $discreteDistribution->addItem("item2");
        $this->smallDistribution->removeDistribution($discreteDistribution);
        $this->assertEquals(1, $this->smallDistribution->getCount("item1"));
        $this->assertEquals(1, $this->smallDistribution->getCount("item2"));
        $this->assertEquals(1, $this->smallDistribution->getCount("item3"));
        $this->smallDistribution->addDistribution($discreteDistribution);
    }

    public function testGetSum()
    {
        $this->assertEquals(6, $this->smallDistribution->getSum());
    }

    public function testGetIndex()
    {
        $this->assertEquals(0, $this->smallDistribution->getIndex("item1"));
        $this->assertEquals(1, $this->smallDistribution->getIndex("item2"));
        $this->assertEquals(2, $this->smallDistribution->getIndex("item3"));
    }

    public function testContainsItem()
    {
        $this->assertTrue($this->smallDistribution->containsItem("item1"));
        $this->assertFalse($this->smallDistribution->containsItem("item4"));
    }

    public function testGetItem()
    {
        $this->assertEquals("item1", $this->smallDistribution->getItem(0));
        $this->assertEquals("item2", $this->smallDistribution->getItem(1));
        $this->assertEquals("item3", $this->smallDistribution->getItem(2));
    }

    public function testGetValue()
    {
        $this->assertEquals(3, $this->smallDistribution->getValue(0));
        $this->assertEquals(2, $this->smallDistribution->getValue(1));
        $this->assertEquals(1, $this->smallDistribution->getValue(2));
    }

    public function testGetCount()
    {
        $this->assertEquals(3, $this->smallDistribution->getCount("item1"));
        $this->assertEquals(2, $this->smallDistribution->getCount("item2"));
        $this->assertEquals(1, $this->smallDistribution->getCount("item3"));
    }

    public function testGetMaxItem1()
    {
        $this->assertEquals("item1", $this->smallDistribution->getMaxItem());
    }

    public function testGetProbability()
    {
        $this->assertEquals(0.5, $this->smallDistribution->getProbability("item1"));
        $this->assertEquals(1 / 3, $this->smallDistribution->getProbability("item2"));
        $this->assertEquals(1 / 6, $this->smallDistribution->getProbability("item3"));
    }

    public function testgetProbabilityLaplaceSmoothing()
    {
        $this->assertEquals(0.4, $this->smallDistribution->getProbabilityLaplaceSmoothing("item1"));
        $this->assertEquals(0.3, $this->smallDistribution->getProbabilityLaplaceSmoothing("item2"));
        $this->assertEquals(0.2, $this->smallDistribution->getProbabilityLaplaceSmoothing("item3"));
        $this->assertEquals(0.1, $this->smallDistribution->getProbabilityLaplaceSmoothing("item4"));
    }

    public function testEntropy()
    {
        $this->assertEquals(14591, floor(10000 * $this->smallDistribution->entropy()));
    }
}
