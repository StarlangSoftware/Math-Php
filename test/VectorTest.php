<?php

use olcaytaner\Math\Vector;
use PHPUnit\Framework\TestCase;

class VectorTest extends TestCase
{
    private Vector $smallVector1;
    private Vector $smallVector2;
    private Vector $largeVector1;
    private Vector $largeVector2;

    public function nearlyEqual(float $value1, float $value2, float $difference): void
    {
        $this->assertTrue(abs($value1 - $value2) < $difference);
    }

    public function setUp(): void
    {
        $data1 = [2, 3, 4, 5, 6];
        $data2 = [8, 7, 6, 5, 4];
        $this->smallVector1 = new Vector($data1);
        $this->smallVector2 = new Vector($data2);
        $largeData1 = [];
        for ($i = 1; $i <= 1000; $i++) {
            $largeData1[] = $i;
        }
        $this->largeVector1 = new Vector($largeData1);
        $largeData2 = [];
        for ($i = 1; $i <= 1000; $i++) {
            $largeData2[] = 1000 - $i + 1;
        }
        $this->largeVector2 = new Vector($largeData2);
    }

    public function testBiased()
    {
        $biased = $this->smallVector1->biased();
        $this->assertEquals(1, $biased->getValue(0));
        $this->assertEquals($this->smallVector1->size() + 1, $biased->size());
    }

    public function testSumOfElementsSmall()
    {
        $this->assertEquals(20, $this->smallVector1->sumOfElements());
        $this->assertEquals(30, $this->smallVector2->sumOfElements());
    }

    public function testSumOfElementsLarge()
    {
        $this->assertEquals(500500, $this->largeVector1->sumOfElements());
        $this->assertEquals(500500, $this->largeVector2->sumOfElements());
    }

    public function testMaxIndex()
    {
        $this->assertEquals(4, $this->smallVector1->maxIndex());
        $this->assertEquals(0, $this->smallVector2->maxIndex());
    }

    public function testSigmoid()
    {
        $data1 = [2, 3, 4, 5, 6];
        $smallVector3 = new Vector($data1);
        $smallVector3->sigmoid();
        $this->nearlyEqual(0.8807971, $smallVector3->getValue(0), 0.000001);
        $this->nearlyEqual(0.9975274, $smallVector3->getValue(4), 0.000001);
    }

    public function testSkipVectorSmall()
    {
        $smallVector3 = $this->smallVector1->skipVector(2, 0);
        $this->assertEquals(2, $smallVector3->getValue(0));
        $this->assertEquals(6, $smallVector3->getValue(2));
        $smallVector3 = $this->smallVector1->skipVector(3, 1);
        $this->assertEquals(3, $smallVector3->getValue(0));
        $this->assertEquals(6, $smallVector3->getValue(1));
    }

    public function testSkipVectorLarge()
    {
        $largeVector3 = $this->largeVector1->skipVector(2, 0);
        $this->assertEquals(250000, $largeVector3->sumOfElements());
        $largeVector3 = $this->largeVector1->skipVector(5, 3);
        $this->assertEquals(100300, $largeVector3->sumOfElements());
    }

    public function testVectorAddSmall()
    {
        $this->smallVector1->addVector($this->smallVector2);
        $this->assertEquals(50, $this->smallVector1->sumOfElements());
    }

    public function testVectorAddLarge()
    {
        $this->largeVector1->addVector($this->largeVector2);
        $this->assertEquals(1001000, $this->largeVector1->sumOfElements());
    }

    public function testSubtractSmall()
    {
        $this->smallVector1->subtract($this->smallVector2);
        $this->assertEquals(-10, $this->smallVector1->sumOfElements());
    }

    public function testSubtractLarge()
    {
        $this->largeVector1->subtract($this->largeVector2);
        $this->assertEquals(0, $this->largeVector1->sumOfElements());
    }

    public function testDifferenceSmall()
    {
        $smallVector3 = $this->smallVector1->difference($this->smallVector2);
        $this->assertEquals(-10, $smallVector3->sumOfElements());
    }

    public function testDifferenceLarge()
    {
        $largeVector3 = $this->largeVector1->difference($this->largeVector2);
        $this->assertEquals(0, $largeVector3->sumOfElements());
    }

    public function testDotProductWithVectorSmall()
    {
        $dotProduct = $this->smallVector1->dotProduct($this->smallVector2);
        $this->assertEquals(110, $dotProduct);
    }

    public function testDotProductWithVectorLarge()
    {
        $dotProduct = $this->largeVector1->dotProduct($this->largeVector2);
        $this->assertEquals(167167000, $dotProduct);
    }

    public function testDotProductWithItselfSmall()
    {
        $dotProduct = $this->smallVector1->dotProductWithItself();
        $this->assertEquals(90, $dotProduct);
    }

    public function testDotProductWithItselfLarge()
    {
        $dotProduct = $this->largeVector1->dotProductWithItself();
        $this->assertEquals(333833500, $dotProduct);
    }

    public function testElementProductSmall()
    {
        $smallVector3 = $this->smallVector1->elementProduct($this->smallVector2);
        $this->assertEquals(110, $smallVector3->sumOfElements());
    }

    public function testElementProductLarge()
    {
        $largeVector3 = $this->largeVector1->elementProduct($this->largeVector2);
        $this->assertEquals(167167000, $largeVector3->sumOfElements());
    }

    public function testDivide()
    {
        $this->smallVector1->divide(10.0);
        $this->assertEquals(2, $this->smallVector1->sumOfElements());
    }

    public function testMultiply()
    {
        $this->smallVector1->multiplyWithValue(10.0);
        $this->assertEquals(200, $this->smallVector1->sumOfElements());
    }

    public function testProduct()
    {
        $smallVector3 = $this->smallVector1->product(7.0);
        $this->assertEquals(140, $smallVector3->sumOfElements());
    }

    public function testL1NormalizeSmall()
    {
        $this->smallVector1->l1Normalize();
        $this->assertEquals(1.0, $this->smallVector1->sumOfElements());
    }

    public function testL1NormalizeLarge()
    {
        $this->largeVector1->l1Normalize();
        $this->assertEquals(1.0, $this->largeVector1->sumOfElements());
    }

    public function testL2NormSmall()
    {
        $norm = $this->smallVector1->l2Norm();
        $this->assertEquals($norm, sqrt(90));
    }

    public function testL2NormLarge()
    {
        $norm = $this->largeVector1->l2Norm();
        $this->assertEquals($norm, sqrt(333833500));
    }

    public function testCosineSimilaritySmall()
    {
        $similarity = $this->smallVector1->cosineSimilarity($this->smallVector2);
        $this->nearlyEqual(0.8411910, $similarity, 0.000001);
    }

    public function testCosineSimilarityLarge()
    {
        $similarity = $this->largeVector1->cosineSimilarity($this->largeVector2);
        $this->nearlyEqual(0.5007497, $similarity, 0.000001);
    }

    public function testElementAdd()
    {
        $this->smallVector1->add(7);
        $this->assertEquals(7, $this->smallVector1->getValue(5));
        $this->assertEquals(6, $this->smallVector1->size());
    }

    public function testInsert()
    {
        $this->smallVector1->insert(3, 6);
        $this->assertEquals(6, $this->smallVector1->getValue(3));
        $this->assertEquals(6, $this->smallVector1->size());
    }

    public function testRemove()
    {
        $this->smallVector1->remove(2);
        $this->assertEquals(5, $this->smallVector1->getValue(2));
        $this->assertEquals(4, $this->smallVector1->size());
    }

}
