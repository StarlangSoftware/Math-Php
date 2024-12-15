<?php

namespace olcaytaner\Math;

class DiscreteDistribution
{
    private array $data;
    private int $sum;

    /**
     * A constructor of {@link DiscreteDistribution} class which initializes the $data array.
     */
    public function __construct()
    {
        $this->data = [];
        $this->sum = 0;
    }

    /**
     * The addItem method takes a String item as an input and if this map contains a mapping for the item it puts the item
     * with given value + 1, else it puts item with value of 1.
     *
     * @param string $item String input.
     */
    public function addItem(string $item): void
    {
        if (isset($this->data[$item])) {
            $this->data[$item]++;
        } else {
            $this->data[$item] = 1;
        }
        $this->sum++;
    }

    /**
     * The removeItem method takes a String item as an input and if this map contains a mapping for the item it puts the item
     * with given value - 1, and if its value is 0, it removes the item.
     *
     * @param string $item String input.
     */
    public function removeItem(string $item): void
    {
        if (isset($this->data[$item])) {
            $this->data[$item]--;
            if ($this->data[$item] == 0) {
                unset($this->data[$item]);
            }
            $this->sum--;
        }
    }

    /**
     * The addDistribution method takes a {@link DiscreteDistribution} as an input and loops through the entries in this distribution
     * and if this map contains a mapping for the entry it puts the entry with its value + entry, else it puts entry with its value.
     * It also accumulates the values of entries and assigns to the sum variable.
     *
     * @param DiscreteDistribution $distribution {@link DiscreteDistribution} type input.
     */
    public function addDistribution(DiscreteDistribution $distribution): void
    {
        foreach ($distribution->data as $key => $value) {
            if (isset($this->data[$key])) {
                $this->data[$key] += $value;
            } else {
                $this->data[$key] = $value;
            }
            $this->sum += $value;
        }
    }

    /**
     * The removeDistribution method takes a {@link DiscreteDistribution} as an input and loops through the entries in this distribution
     * and if this map contains a mapping for the entry it puts the entry with its key - value, else it removes the entry.
     * It also decrements the value of entry from sum and assigns to the sum variable.
     *
     * @param DiscreteDistribution $distribution {@link DiscreteDistribution} type input.
     */
    public function removeDistribution(DiscreteDistribution $distribution): void
    {
        foreach ($distribution->data as $key => $value) {
            if ($this->data[$key] - $value != 0) {
                $this->data[$key] -= $value;
            } else {
                unset($this->data[$key]);
            }
            $this->sum -= $value;
        }
    }

    /**
     * The getter for sum variable.
     *
     * @return int sum.
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * The getIndex method takes an item as an input and returns the index of given item.
     *
     * @param string $item to search for index.
     * @return int index of given item.
     */
    public function getIndex(string $item): int
    {
        $index = 0;
        foreach ($this->data as $key => $value) {
            if ($key == $item) {
                return $index;
            }
            $index++;
        }
        return -1;
    }

    /**
     * The containsItem method takes an item as an input and returns true if this map contains a mapping for the
     * given item.
     *
     * @param string $item to check.
     * @return bool true if this map contains a mapping for the given item.
     */
    public function containsItem(string $item): bool
    {
        return isset($this->data[$item]);
    }

    /**
     * The getItem method takes an index as an input and returns the item at given index.
     *
     * @param int $index is used for searching the item.
     * @return string|null the item at given index.
     */
    public function getItem(int $index): string|null
    {
        $i = 0;
        foreach ($this->data as $key => $value) {
            if ($i == $index) {
                return $key;
            }
            $i++;
        }
        return null;
    }

    /**
     * The getValue method takes an index as an input and returns the value at given index.
     *
     * @param int $index is used for searching the value.
     * @return int|null the value at given index.
     */
    public function getValue(int $index): int|null
    {
        $i = 0;
        foreach ($this->data as $key => $value) {
            if ($i == $index) {
                return $value;
            }
            $i++;
        }
        return null;
    }

    /**
     * The getCount method takes an item as an input returns the value to which the specified item is mapped, or {@code null}
     * if this map contains no mapping for the key.
     *
     * @param string $item is used to search for value.
     * @return int the value to which the specified item is mapped
     */
    public function getCount(string $item): int
    {
        return $this->data[$item];
    }

    /**
     * The getMaxItem method loops through the entries and gets the entry with maximum value.
     *
     * @param array|null $includeTheseOnly If the array is not null, only items in this array are considered
     * @return string the entry with maximum value.
     */
    public function getMaxItem(array $includeTheseOnly = null): string
    {
        $max = -1;
        $maxItem = null;
        if ($includeTheseOnly == null) {
            foreach ($this->data as $key => $value) {
                if ($value > $max) {
                    $max = $value;
                    $maxItem = $key;
                }
            }
        } else {
            foreach ($includeTheseOnly as $key => $value) {
                if (isset($this->data[$key])) {
                    if ($this->data[$key] > $max) {
                        $max = $this->data[$key];
                        $maxItem = $key;
                    }
                }
            }
        }
        return $maxItem;
    }

    /**
     * The getProbability method takes an item as an input returns the value to which the specified item is mapped over sum,
     * or 0.0 if this map contains no mapping for the key.
     *
     * @param string $item is used to search for probability.
     * @return float the probability to which the specified item is mapped.
     */
    public function getProbability(string $item): float
    {
        if (isset($this->data[$item])) {
            return $this->data[$item] / $this->sum;
        } else {
            return 0.0;
        }
    }

    /**
     * Returns the distribution as a probability distribution
     * @return array Probability distribution
     */
    public function getProbabilityDistribution(): array
    {
        $result = [];
        foreach ($this->data as $key => $value) {
            $result[$key] = $this->getProbability($key);
        }
        return $result;
    }

    /**
     * The getProbabilityLaplaceSmoothing method takes an item as an input returns the smoothed value to which the specified
     * item is mapped over sum, or 1.0 over sum if this map contains no mapping for the key.
     *
     * @param string $item is used to search for probability.
     * @return float the smoothed probability to which the specified item is mapped.
     */
    public function getProbabilityLaplaceSmoothing(string $item): float
    {
        if (isset($this->data[$item])) {
            return ($this->data[$item] + 1) / ($this->sum + count($this->data) + 1);
        } else {
            return 1 / ($this->sum + count($this->data) + 1);
        }
    }

    /**
     * The entropy method loops through the values and calculates the entropy of these values.
     *
     * @return float entropy value.
     */
    public function entropy(): float
    {
        $total = 0.0;
        foreach ($this->data as $key => $value) {
            $probability = $value / $this->sum;
            $total += -$probability * (log($probability) / log(2));
        }
        return $total;
    }

}