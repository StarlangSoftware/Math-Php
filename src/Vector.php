<?php

namespace olcaytaner\Math;

class Vector
{
    private int $size;
    private array $values;

    public function constructor1(): void
    {
        $this->values = [];
        $this->size = 0;
    }

    public function constructor2(array $values): void
    {
        $this->values = $values;
        $this->size = count($values);
    }

    public function constructor3(int $size, float $initial): void
    {
        $this->size = $size;
        $this->values = [];
        for ($i = 0; $i < $this->size; $i++) {
            $this->values[] = $initial;
        }
    }

    public function constructor4(int $size, float $initial, int $index): void
    {
        $this->size = $size;
        $this->values = [];
        for ($i = 0; $i < $index; $i++) {
            $this->values[] = 0.0;
        }
        $this->values[$index] = $initial;
    }

    public function __construct(mixed $valuesOrSize = null, mixed $initial = null, mixed $index = null)
    {
        if ($valuesOrSize == null) {
            $this->constructor1();
        } else {
            if (is_array($valuesOrSize)) {
                $this->constructor2($valuesOrSize);
            } else {
                if ($index == null) {
                    $this->constructor3($valuesOrSize, $initial);
                } else {
                    $this->constructor4($valuesOrSize, $initial, $index);
                }
            }
        }
    }

    /**
     * The biased method creates a {@link Vector} result, add adds each item of values {@link Array} into the result Vector.
     * Then, insert 1.0 to 0th position and return result {@link Vector}.
     *
     * @return Vector result {@link Vector}.
     */
    public function biased(): Vector
    {
        $result = new Vector(0, 0);
        foreach ($this->values as $value) {
            $result->add($value);
        }
        $result->insert(0, 1.0);
        return $result;
    }

    /**
     * The add method adds given input to the values {@link Array} and increments the size variable by one.
     *
     * @param float $x double input to add values {@link Array}.
     */
    public function add(float $x): void
    {
        $this->values[] = $x;
        $this->size++;
    }

    /**
     * The insert method puts given input to the given index of values {@link Array} and increments the size variable by one.
     *
     * @param int $pos index to insert input.
     * @param float $x input to insert to given index of values {@link Array}.
     */
    public function insert(int $pos, float $x): void
    {
        array_splice($this->values, $pos, 0, $x);
        $this->size++;
    }

    /**
     * The remove method deletes the item at given input position of values {@link Array} and decrements the size variable by one.
     *
     * @param int $pos index to remove from values {@link Array}.
     */
    public function remove(int $pos): void
    {
        array_splice($this->values, $pos, 1);
        $this->size--;
    }

    /**
     * The clear method sets all the elements of values {@link Array} to 0.0.
     */
    public function clear(): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            $this->values[$i] = 0;
        }
    }

    /**
     * The sumOfElements method sums up all elements in the vector.
     *
     * @return float Sum of all elements in the vector.
     */
    public function sumOfElements(): float
    {
        $total = 0;
        foreach ($this->values as $value) {
            $total += $value;
        }
        return $total;
    }

    /**
     * The maxIndex method gets the first item of values {@link Array} as maximum item, then it loops through the indices
     * and if a greater value than the current maximum item comes, it updates the maximum item and returns the final
     * maximum item's index.
     *
     * @return int final maximum item's index.
     */
    public function maxIndex(): int
    {
        $index = 0;
        $max = $this->values[0];
        for ($i = 1; $i < $this->size; $i++) {
            if ($this->values[$i] > $max) {
                $max = $this->values[$i];
                $index = $i;
            }
        }
        return $index;
    }

    /**
     * The sigmoid method loops through the values {@link Array} and sets each ith item with sigmoid function, i.e
     * 1 / (1 + Math.exp(-values.get(i))), $i ranges from 0 to size.
     */
    public function sigmoid(): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            $this->values[$i] = 1 / (1 + exp(-$this->values[$i]));
        }
    }

    /**
     * The tanh method loops through the values {@link Array} and sets each ith item with tanh function.
     */
    public function tanh(): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            $this->values[$i] = 1 / (1 + tanh($this->values[$i]));
        }
    }

    /**
     * The relu method loops through the values {@link Array} and sets each ith item with relu function.
     */
    public function relu(): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            if ($this->values[$i] < 0) {
                $this->values[$i] = 0;
            }
        }
    }

    /**
     * The reluDerivative method loops through the values {@link Array} and sets each ith item with the derivative of
     * relu function.
     */
    public function reluDerivative(): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            if ($this->values[$i] > 0) {
                $this->values[$i] = 1.0;
            } else {
                $this->values[$i] = 0;
            }
        }
    }

    /**
     * The skipVector method takes a mod and a value as inputs. It creates a new result Vector, and assigns given input value to i.
     * While $i is less than the size, it adds the ith item of values {@link Array} to the result and increments i by given mod input.
     *
     * @param int $mod integer input.
     * @param int $value integer input.
     * @return Vector result Vector.
     */
    public function skipVector(int $mod, int $value): Vector
    {
        $result = new Vector(0, 0);
        $i = $value;
        while ($i < $this->size) {
            $result->add($this->values[$i]);
            $i += $mod;
        }
        return $result;
    }

    /**
     * The add method takes a {@link Vector} v as an input. It sums up the corresponding elements of both given vector's
     * values {@link Array} and values {@link Array} and puts result back to the values {@link Array}.
     * If their sizes do not match, it throws a VectorSizeMismatch exception.
     *
     * @param Vector $v Vector to add.
     */
    public function addVector(Vector $v): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            $this->values[$i] += $v->values[$i];
        }
    }

    /**
     * The subtract method takes a {@link Vector} v as an input. It subtracts the corresponding elements of given vector's
     * values {@link Array} from values {@link Array} and puts result back to the values {@link Array}.
     * If their sizes do not match, it throws a VectorSizeMismatch exception.
     *
     * @param Vector $v Vector to subtract from values {@link Array}.
     */
    public function subtract(Vector $v): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            $this->values[$i] -= $v->values[$i];
        }
    }

    /**
     * The difference method takes a {@link Vector} v as an input. It creates a new double {@link Array} result, then
     * subtracts the corresponding elements of given vector's values {@link Array} from values {@link Array} and puts
     * result back to the result {@link Array}. If their sizes do not match, it throws a VectorSizeMismatch exception.
     *
     * @param Vector $v Vector to find difference from values {@link Array}.
     * @return Vector new {@link Vector} with result {@link Array}.
     */
    public function difference(Vector $v): Vector
    {
        $result = [];
        for ($i = 0; $i < $this->size; $i++) {
            $result[] = $this->values[$i] - $v->values[$i];
        }
        return new Vector($result);
    }

    /**
     * The dotProduct method takes a {@link Vector} v as an input. It creates a new double variable result, then
     * multiplies the corresponding elements of given vector's values {@link Array} with values {@link Array} and assigns
     * the multiplication to the result. If their sizes do not match, it throws a VectorSizeMismatch exception.
     *
     * @param Vector $v Vector to find dot product.
     * @return float result.
     */
    public function dotProduct(Vector $v): float
    {
        $result = 0;
        for ($i = 0; $i < $this->size; $i++) {
            $result += $this->values[$i] * $v->values[$i];
        }
        return $result;
    }

    /**
     * The dotProduct method creates a new double variable result, then squares the elements of values {@link Array}
     * and assigns the accumulation to the result.
     *
     * @return float result.
     */
    public function dotProductWithItself(): float
    {
        $result = 0;
        for ($i = 0; $i < $this->size; $i++) {
            $result += $this->values[$i] * $this->values[$i];
        }
        return $result;
    }

    /**
     * The elementProduct method takes a {@link Vector} v as an input. It creates a new double {@link Array} result, then
     * multiplies the corresponding elements of given vector's values {@link Array} with values {@link Array} and assigns
     * the multiplication to the result {@link Array}. If their sizes do not match, it throws a VectorSizeMismatch exception.
     *
     * @param Vector $v Vector to find dot product.
     * @return Vector with result {@link Array}.
     */
    public function elementProduct(Vector $v): Vector
    {
        $result = [];
        for ($i = 0; $i < $this->size; $i++) {
            $result[] = $this->values[$i] * $v->values[$i];
        }
        return new Vector($result);
    }

    /**
     * The divide method takes a double value as an input and divides each item of values {@link Array} with given value.
     *
     * @param float $value is used to divide items of values {@link Array}.
     */
    public function divide(float $value): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            $this->values[$i] /= $value;
        }
    }

    /**
     * The multiply method takes a double value as an input and multiplies each item of values {@link Array} with given value.
     *
     * @param float $value is used to multiply items of values {@link Array}.
     */
    public function multiplyWithValue(float $value): void
    {
        for ($i = 0; $i < $this->size; $i++) {
            $this->values[$i] *= $value;
        }
    }

    /**
     * The product method takes a double value as an input and creates a new result {@link Vector}, then multiplies each
     * item of values {@link Array} with given value and adds to the result {@link Vector}.
     *
     * @param float $value is used to multiply items of values {@link Array}.
     * @return Vector result.
     */
    public function product(float $value): Vector
    {
        $result = new Vector(0, 0);
        for ($i = 0; $i < $this->size; $i++) {
            $result->add($this->values[$i] * $value);
        }
        return $result;
    }

    /**
     * The l1Normalize method is used to apply Least Absolute Errors, it accumulates items of values {@link Array} and sets
     * each item by dividing it by the summation value.
     */
    public function l1Normalize(): void
    {
        $sum = 0;
        for ($i = 0; $i < $this->size; $i++) {
            $sum += $this->values[$i];
        }
        for ($i = 0; $i < $this->size; $i++) {
            $this->values[$i] /= $sum;
        }
    }

    /**
     * The l2Norm method is used to apply Least Squares, it accumulates second power of each items of values {@link Array}
     * and returns the square root of this summation.
     *
     * @return float square root of this summation.
     */
    public function l2Norm(): float
    {
        $sum = 0;
        for ($i = 0; $i < $this->size; $i++) {
            $sum += $this->values[$i] * $this->values[$i];
        }
        return sqrt($sum);
    }

    /**
     * The cosineSimilarity method takes a {@link Vector} v as an input and returns the result of dotProduct(v) / l2Norm() / v.l2Norm().
     *
     * @param Vector $v Vector input.
     * @return float dotProduct(v) / l2Norm() / v.l2Norm().
     */
    public function cosineSimilarity(Vector $v): float
    {
        return $this->dotProduct($v) / $this->l2Norm() / $v->l2Norm();
    }

    /**
     * The size method returns the size of the values {@link Array}.
     *
     * @return int size of the values {@link Array}.
     */
    public function size(): int
    {
        return count($this->values);
    }

    /**
     * Getter for the item at given index of values {@link Array}.
     *
     * @param int $index used to get an item.
     * @return float the item at given index.
     */
    public function getValue(int $index): float
    {
        return $this->values[$index];
    }

    /**
     * Setter for the setting the value at given index of values {@link Array}.
     *
     * @param int $index to set.
     * @param float $value is used to set the given index
     */
    public function setValue(int $index, float $value): void
    {
        $this->values[$index] = $value;
    }

    /**
     * The addValue method adds the given value to the item at given index of values {@link Array}.
     *
     * @param int $index to add the given value.
     * @param float $value value to add to given index.
     */
    public function addValue(int $index, float $value): void
    {
        $this->values[$index] += $value;
    }

}