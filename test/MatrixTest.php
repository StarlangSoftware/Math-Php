<?php

use olcaytaner\Math\Matrix;
use olcaytaner\Math\Vector;
use PHPUnit\Framework\TestCase;

class MatrixTest extends TestCase
{
    private Matrix $small, $medium, $large, $random, $identity;
    private Vector $v, $V, $vr;
    private float $originalSum;

    public function nearlyEqual(float $value1, float $value2, float $difference): void
    {
        $this->assertTrue(abs($value1 - $value2) < $difference);
    }

    protected function setUp(): void
    {
        $this->small = new Matrix(3, 3);
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $this->small->setValue($i, $j, 1.0);
            }
        }
        $this->v = new Vector(3, 1.0);
        $this->large = new Matrix(1000, 1000);
        for ($i = 0; $i < 1000; $i++) {
            for ($j = 0; $j < 1000; $j++) {
                $this->large->setValue($i, $j, 1.0);
            }
        }
        $this->medium = new Matrix(100, 100);
        for ($i = 0; $i < 100; $i++) {
            for ($j = 0; $j < 100; $j++) {
                $this->medium->setValue($i, $j, 1.0);
            }
        }
        $this->V = new Vector(1000, 1.0);
        $this->vr = new Vector(100, 1.0);
        $this->random = new Matrix(100, 100, 1, 10);
        $this->originalSum = $this->random->sumOfElements();
        $this->identity = new Matrix(100);
    }

    public function testColumnWiseNormalize()
    {
        $this->small->columnWiseNormalize();
        $this->assertEquals(3, $this->small->sumOfElements());
        $this->large->columnWiseNormalize();
        $this->nearlyEqual(1000, $this->large->sumOfElements(), 0.001);
        $this->identity->columnWiseNormalize();
        $this->assertEquals(100, $this->identity->sumOfElements());
    }

    public function testMultiplyWithConstant()
    {
        $this->small->multiplyWithConstant(4);
        $this->assertEquals(36, $this->small->sumOfElements());
        $this->large->multiplyWithConstant(1.001);
        $this->nearlyEqual(1001000, $this->large->sumOfElements(), 0.001);
        $this->random->multiplyWithConstant(3.6);
        $this->nearlyEqual($this->originalSum * 3.6, $this->random->sumOfElements(), 0.0001);
    }

    public function testDivideByConstant()
    {
        $this->small->divideByConstant(4);
        $this->assertEquals(2.25, $this->small->sumOfElements());
        $this->large->divideByConstant(10);
        $this->nearlyEqual(100000, $this->large->sumOfElements(), 0.001);
        $this->random->divideByConstant(3.6);
        $this->nearlyEqual($this->originalSum / 3.6, $this->random->sumOfElements(), 0.0001);
    }

    public function testAdd()
    {
        $this->random->add($this->identity);
        $this->nearlyEqual($this->originalSum + 100, $this->random->sumOfElements(), 0.0001);
    }

    public function testAddVector()
    {
        $this->large->add(4, $this->V);
        $this->assertEquals(1001000, $this->large->sumOfElements());
    }

    public function testSubtract()
    {
        $this->random->subtract($this->identity);
        $this->nearlyEqual($this->originalSum - 100, $this->random->sumOfElements(), 0.0001);
    }

    public function testMultiplyWithVectorFromLeft()
    {
        $result = $this->small->multiplyWithVectorFromLeft($this->v);
        $this->assertEquals(9, $result->sumOfElements());
        $result = $this->large->multiplyWithVectorFromLeft($this->V);
        $this->assertEquals(1000000, $result->sumOfElements());
        $result = $this->random->multiplyWithVectorFromLeft($this->vr);
        $this->nearlyEqual($this->originalSum, $result->sumOfElements(), 0.0001);
    }

    public function testMultiplyWithVectorFromRight()
    {
        $result = $this->small->multiplyWithVectorFromRight($this->v);
        $this->assertEquals(9, $result->sumOfElements());
        $result = $this->large->multiplyWithVectorFromRight($this->V);
        $this->assertEquals(1000000, $result->sumOfElements());
        $result = $this->random->multiplyWithVectorFromRight($this->vr);
        $this->nearlyEqual($this->originalSum, $result->sumOfElements(), 0.0001);
    }

    public function testColumnSum()
    {
        $this->assertEquals(3, $this->small->columnSum(floor((mt_rand() / mt_getrandmax()) * 3)));
        $this->assertEquals(1000, $this->large->columnSum(floor((mt_rand() / mt_getrandmax()) * 1000)));
        $this->assertEquals(1, $this->identity->columnSum(floor((mt_rand() / mt_getrandmax()) * 100)));
    }

    public function testSumOfRows()
    {
        $this->assertEquals(9, $this->small->sumOfRows()->sumOfElements());
        $this->assertEquals(1000000, $this->large->sumOfRows()->sumOfElements());
        $this->assertEquals(100, $this->identity->sumOfRows()->sumOfElements());
        $this->nearlyEqual($this->originalSum, $this->random->sumOfRows()->sumOfElements(), 0.001);
    }

    public function testRowSum()
    {
        $this->assertEquals(3, $this->small->rowSum(floor((mt_rand() / mt_getrandmax()) * 3)));
        $this->assertEquals(1000, $this->large->rowSum(floor((mt_rand() / mt_getrandmax()) * 1000)));
        $this->assertEquals(1, $this->identity->rowSum(floor((mt_rand() / mt_getrandmax()) * 100)));
    }

    public function testMultiply()
    {
        $result = $this->small->multiply($this->small);
        $this->assertEquals(27, $result->sumOfElements());
        $result = $this->random->multiply($this->identity);
        $this->assertEquals($this->originalSum, $result->sumOfElements());
        $result = $this->identity->multiply($this->random);
        $this->assertEquals($this->originalSum, $result->sumOfElements());
    }

    public function testElementProduct()
    {
        $result = $this->small->elementProduct($this->small);
        $this->assertEquals(9, $result->sumOfElements());
        $result = $this->large->elementProduct($this->large);
        $this->assertEquals(1000000, $result->sumOfElements());
        $result = $this->random->elementProduct($this->identity);
        $this->assertEquals($result->trace(), $result->sumOfElements());
    }

    public function testSumOfElements()
    {
        $this->assertEquals(9, $this->small->sumOfElements());
        $this->assertEquals(1000000, $this->large->sumOfElements());
        $this->assertEquals(100, $this->identity->sumOfElements());
        $this->assertEquals($this->originalSum, $this->random->sumOfElements());
    }

    public function testTrace()
    {
        $this->assertEquals(3, $this->small->trace());
        $this->assertEquals(1000, $this->large->trace());
        $this->assertEquals(100, $this->identity->trace());
    }

    public function testTranspose()
    {
        $this->assertEquals(9, $this->small->transpose()->sumOfElements());
        $this->assertEquals(1000000, $this->large->transpose()->sumOfElements());
        $this->assertEquals(100, $this->identity->transpose()->sumOfElements());
        $this->nearlyEqual($this->originalSum, $this->random->transpose()->sumOfElements(), 0.001);
    }

    public function testIsSymmetric()
    {
        $this->assertTrue($this->small->isSymmetric());
        $this->assertTrue($this->large->isSymmetric());
        $this->assertTrue($this->identity->isSymmetric());
        $this->assertTrue(!$this->random->isSymmetric());
    }

    public function testDeterminant()
    {
        $this->assertEquals(0, $this->small->determinant());
        $this->assertEquals(0, $this->large->determinant());
        $this->assertEquals(1, $this->identity->determinant());
    }

    public function testInverse()
    {
        $this->identity->inverse();
        $this->assertEquals(100, $this->identity->sumOfElements());
        $this->random->inverse();
        $this->random->inverse();
        $this->nearlyEqual($this->originalSum, $this->random->sumOfElements(), 0.00001);
    }

    public function testCharacteristics()
    {
        $vectors = $this->small->characteristics();
        $this->assertCount(2, $vectors);
        $vectors = $this->identity->characteristics();
        $this->assertCount(100, $vectors);
        $vectors = $this->medium->characteristics();
        $this->assertCount(46, $vectors);
    }

}
