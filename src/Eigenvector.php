<?php

namespace olcaytaner\Math;

class Eigenvector extends Vector
{
    private float $eigenvalue;

    /**
     * A constructor of {@link Eigenvector} which takes a double eigenValue and an {@link Array} values as inputs.
     * It calls its super class {@link Vector} with values {@link Array} and initializes eigenValue variable with its
     * eigenValue input.
     *
     * @param float $eigenValue double input.
     * @param array $values {@link ArrayList} input.
     */
    public function __construct(float $eigenvalue, array $values)
    {
        parent::__construct($values);
        $this->eigenvalue = $eigenvalue;
    }

    /**
     * The eigenValue method which returns the eigenValue variable.
     *
     * @return float eigenValue variable.
     */
    public function getEigenvalue(): float
    {
        return $this->eigenvalue;
    }
}