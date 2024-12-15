<?php

namespace olcaytaner\Math;

class Matrix
{
    private int $row;
    private int $col;
    private array $values;

    public function constructor1(int $row): void
    {
        $this->row = $row;
        $this->col = $row;
        $this->initZeros();
        for ($i = 0; $i < $this->row; $i++) {
            $this->values[$i][$i] = 1;
        }
    }

    public function constructor2(int $row, int $col): void
    {
        $this->row = $row;
        $this->col = $col;
        $this->initZeros();
    }

    public function constructor3(int $row, int $col, float $minValue): void
    {
        $this->row = $row;
        $this->col = $col;
        $this->initZeros();
        for ($i = 0; $i < $this->row; $i++) {
            $this->values[$i][$i] = $minValue;
        }
    }

    public function constructor4(int $row, int $col, float $minValue, float $maxValue): void
    {
        $this->row = $row;
        $this->col = $col;
        $this->values = [];
        for ($i = 0; $i < $this->row; $i++) {
            $array = [];
            for ($j = 0; $j < $this->col; $j++) {
                $array[] = $minValue + ($maxValue - $minValue) * (mt_rand() / mt_getrandmax());
            }
            $this->values[] = $array;
        }
    }

    public function constructor5(Vector $row, Vector $col): void
    {
        $this->row = $row->size();
        $this->col = $col->size();
        for ($i = 0; $i < $this->row; $i++) {
            $array = [];
            for ($j = 0; $j < $this->col; $j++) {
                $array[] = $row->getValue($i) * $col->getValue($j);
            }
            $this->values[] = $array;
        }
    }

    /**
     * Another constructor of Matrix class which takes row, column, minimum and maximum values as inputs.
     * First it creates new values array with given row and column numbers. Then fills in the
     * positions with random numbers using minimum and maximum inputs.
     *
     * @param mixed $row is used to create matrix.
     * @param mixed $col is used to create matrix.
     * @param mixed $minValue minimum value.
     * @param mixed $maxValue maximum value.
     */
    public function __construct(mixed $row, mixed $col = null, mixed $minValue = null, mixed $maxValue = null)
    {
        if (gettype($row) == 'integer') {
            if ($col != null) {
                if ($minValue == null) {
                    $this->constructor2($row, $col);
                } else {
                    if ($maxValue == null) {
                        $this->constructor3($row, $col, $minValue);
                    } else {
                        $this->constructor4($row, $col, $minValue, $maxValue);
                    }
                }
            } else {
                $this->constructor1($row);
            }
        } else {
            $this->constructor5($row, $col);
        }
    }

    /**
     * Initializes the values of the matrix to 0.
     */
    private function initZeros(): void
    {
        $this->values = [];
        for ($i = 0; $i < $this->row; $i++) {
            $array = [];
            for ($j = 0; $j < $this->col; $j++) {
                $array[] = 0;
            }
            $this->values[] = $array;
        }
    }

    /**
     * The getter for the index at given rowNo and colNo of values {@link Array}.
     *
     * @param int $rowNo integer input for row number.
     * @param int $colNo integer input for column number.
     * @return float item at given index of values {@link Array}.
     */
    public function getValue(int $rowNo, int $colNo): float
    {
        return $this->values[$rowNo][$colNo];
    }

    /**
     * The setter for the value at given index of values {@link Array}.
     *
     * @param int $rowNo integer input for row number.
     * @param int $colNo integer input for column number.
     * @param float $value is used to set at given index.
     */
    public function setValue(int $rowNo, int $colNo, float $value): void
    {
        $this->values[$rowNo][$colNo] = $value;
    }

    /**
     * The addValue method adds the given value to the item at given index of values {@link Array}.
     *
     * @param int $rowNo integer input for row number.
     * @param int $colNo integer input for column number.
     * @param float $value is used to add to given item at given index.
     */
    public function addValue(int $rowNo, int $colNo, float $value): void
    {
        $this->values[$rowNo][$colNo] += $value;
    }

    /**
     * The increment method adds 1 to the item at given index of values {@link Array}.
     *
     * @param int $rowNo integer input for row number.
     * @param int $colNo integer input for column number.
     */
    public function increment(int $rowNo, int $colNo): void
    {
        $this->values[$rowNo][$colNo]++;
    }

    /**
     * The getter for the row variable.
     *
     * @return int row number.
     */
    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * The getter for the column variable.
     *
     * @return int column number.
     */
    public function getColumn(): int
    {
        return $this->col;
    }

    /**
     * The getter for the row vector.
     *
     * @return Vector row vector.
     */
    public function getRowVector(int $row): Vector
    {
        return new Vector($this->values[$row]);
    }

    /**
     * The getColumn method creates an {@link Array} and adds items at given column number of values {@link Array}
     * to the {@link Array}.
     *
     * @param int $col integer input for column number.
     * @return array Array of given column number.
     */
    public function getColumnVector(int $col): array
    {
        $vector = [];
        for ($i = 0; $i < $this->row; $i++) {
            $vector[] = $this->values[$i][$col];
        }
        return $vector;
    }

    /**
     * The columnWiseNormalize method, first accumulates items column by column then divides items by the summation.
     */
    public function columnWiseNormalize(): void
    {
        for ($i = 0; $i < $this->row; $i++) {
            $sum = 0.0;
            for ($j = 0; $j < $this->col; $j++) {
                $sum += $this->values[$i][$j];
            }
            for ($j = 0; $j < $this->col; $j++) {
                $this->values[$i][$j] /= $sum;
            }
        }
    }

    /**
     * The multiplyWithConstant method takes a constant as an input and multiplies each item of values {@link Array}
     * with given constant.
     *
     * @param float $constant value to multiply items of values {@link Array}.
     */
    public function multiplyWithConstant(float $constant): void
    {
        for ($i = 0; $i < $this->row; $i++) {
            for ($j = 0; $j < $this->col; $j++) {
                $this->values[$i][$j] *= $constant;
            }
        }
    }

    /**
     * The divideByConstant method takes a constant as an input and divides each item of values {@link Array}
     * with given constant.
     *
     * @param float $constant value to divide items of values {@link Array}.
     */
    public function divideByConstant(float $constant): void
    {
        for ($i = 0; $i < $this->row; $i++) {
            for ($j = 0; $j < $this->col; $j++) {
                $this->values[$i][$j] /= $constant;
            }
        }
    }

    /**
     * The add method takes a {@link Matrix} as an input and accumulates values {@link Array} with the
     * corresponding items of given Matrix.
     *
     * @param Matrix|int $m
     * @param Vector|null $v
     */
    public function add(Matrix|int $m, Vector $v = null): void
    {
        if ($v == null) {
            for ($i = 0; $i < $this->row; $i++) {
                for ($j = 0; $j < $this->col; $j++) {
                    $this->values[$i][$j] += $m->values[$i][$j];
                }
            }
        } else {
            for ($i = 0; $i < $this->col; $i++) {
                $this->values[$m][$i] += $v->getValue($i);
            }
        }
    }

    /**
     * The subtract method takes a {@link Matrix} as an input and subtracts from values {@link Array} the
     * corresponding items of given Matrix.
     *
     * @param Matrix $m Matrix type input.
     */
    public function subtract(Matrix $m): void
    {
        for ($i = 0; $i < $this->row; $i++) {
            for ($j = 0; $j < $this->col; $j++) {
                $this->values[$i][$j] -= $m->values[$i][$j];
            }
        }
    }

    /**
     * The multiplyWithVectorFromLeft method takes a Vector as an input and creates a result {@link Array}.
     * Then, multiplies values of input Vector starting from the left side with the values {@link Array},
     * accumulates the multiplication, and assigns to the result {@link Array}.
     *
     * @param Vector $v {@link Vector} type input.
     * @return Vector that holds the result.
     */
    public function multiplyWithVectorFromLeft(Vector $v): Vector
    {
        $result = [];
        for ($i = 0; $i < $this->col; $i++) {
            $result[] = 0;
            for ($j = 0; $j < $this->row; $j++) {
                $result[$i] += $v->getValue($j) * $this->values[$j][$i];
            }
        }
        return new Vector($result);
    }

    /**
     * The multiplyWithVectorFromRight method takes a Vector as an input and creates a result {@link Array}.
     * Then, multiplies values of input Vector starting from the right side with the values {@link Array},
     * accumulates the multiplication, and assigns to the result {@link Array}.
     *
     * @param Vector $v {@link Vector} type input.
     * @return Vector that holds the result.
     */
    public function multiplyWithVectorFromRight(Vector $v): Vector
    {
        $result = [];
        for ($i = 0; $i < $this->row; $i++) {
            $result[] = 0;
            for ($j = 0; $j < $this->col; $j++) {
                $result[$i] += $v->getValue($j) * $this->values[$i][$j];
            }
        }
        return new Vector($result);
    }

    /**
     * The columnSum method takes a column number as an input and accumulates items at given column number of values
     * {@link Array}.
     *
     * @param int $columnNo Column number input.
     * @return float summation of given column of values {@link Array}.
     */
    public function columnSum(int $columnNo): float
    {
        $sum = 0.0;
        for ($i = 0; $i < $this->row; $i++) {
            $sum += $this->values[$i][$columnNo];
        }
        return $sum;
    }

    /**
     * The sumOfRows method creates a mew result {@link Vector} and adds the result of columnDum method's corresponding
     * index to the newly created result {@link Vector}.
     *
     * @return Vector Vector that holds column sum.
     */
    public function sumOfRows(): Vector
    {
        $result = new Vector(0, 0.0);
        for ($i = 0; $i < $this->row; $i++) {
            $result->add($this->columnSum($i));
        }
        return $result;
    }

    /**
     * The rowSum method takes a row number as an input and accumulates items at given row number of values
     * {@link Array}.
     *
     * @param int $rowNo Row number input.
     * @return float summation of given row of values {@link Array}.
     */
    public function rowSum(int $rowNo): float
    {
        $sum = 0.0;
        for ($i = 0; $i < $this->col; $i++) {
            $sum += $this->values[$rowNo][$i];
        }
        return $sum;
    }

    /**
     * The multiply method takes a {@link Matrix} as an input. First it creates a result {@link Matrix} and puts the
     * accumulated multiplication of values {@link Array} and given {@link Matrix} into result
     * {@link Matrix}.
     *
     * @param Matrix $m Matrix type input.
     * @return Matrix result {@link Matrix}.
     */
    public function multiply(Matrix $m): Matrix
    {
        $result = new Matrix($this->row, $m->col);
        for ($i = 0; $i < $this->row; $i++) {
            for ($j = 0; $j < $m->col; $j++) {
                $sum = 0.0;
                for ($k = 0; $k < $this->col; $k++) {
                    $sum += $this->values[$i][$k] * $m->values[$k][$j];
                }
                $result->values[$i][$j] = $sum;
            }
        }
        return $result;
    }

    /**
     * The elementProduct method takes a {@link Matrix} as an input and performs element wise multiplication. Puts result
     * to the newly created Matrix.
     *
     * @param Matrix|Vector $m
     * @return Matrix result {@link Matrix}.
     */
    public function elementProduct(Matrix|Vector $m): Matrix
    {
        if ($m instanceof Matrix) {
            $result = new Matrix($this->row, $m->col);
            for ($i = 0; $i < $this->row; $i++) {
                for ($j = 0; $j < $this->col; $j++) {
                    $result->values[$i][$j] = $this->values[$i][$j] * $m->values[$i][$j];
                }
            }
        } else {
            $result = new Matrix($this->row, $this->col);
            if ($this->row == 1 && $this->col == $m->size()) {
                for ($i = 0; $i < $this->col; $i++) {
                    $result->values[0][$i] = $this->values[0][$i] * $m->getValue($i);
                }
            } else {
                if ($this->col == 1 && $this->row == $m->size()) {
                    for ($i = 0; $i < $this->row; $i++) {
                        $result->values[$i][0] = $this->values[$i][0] * $m->getValue($i);
                    }
                }
            }
        }
        return $result;
    }

    /**
     * The sumOfElements method accumulates all the items in values {@link Array} and
     * returns this summation.
     *
     * @return float sum of the items of values {@link Array}.
     */
    public function sumOfElements(): float
    {
        $sum = 0.0;
        for ($i = 0; $i < $this->row; $i++) {
            for ($j = 0; $j < $this->col; $j++) {
                $sum += $this->values[$i][$j];
            }
        }
        return $sum;
    }

    /**
     * The trace method accumulates items of values {@link Array} at the diagonal.
     *
     * @return float sum of items at diagonal.
     */
    public function trace(): float
    {
        $sum = 0.0;
        for ($i = 0; $i < $this->row; $i++) {
            $sum += $this->values[$i][$i];
        }
        return $sum;
    }

    /**
     * The transpose method creates a new {@link Matrix}, then takes the transpose of values {@link Array}
     * and puts transposition to the {@link Matrix}.
     *
     * @return Matrix Matrix type output.
     */
    public function transpose(): Matrix
    {
        $result = new Matrix($this->col, $this->row);
        for ($i = 0; $i < $this->row; $i++) {
            for ($j = 0; $j < $this->col; $j++) {
                $result->values[$j][$i] = $this->values[$i][$j];
            }
        }
        return $result;
    }

    /**
     * The partial method takes 4 integer inputs; rowStart, rowEnd, colStart, colEnd and creates a {@link Matrix} size of
     * rowEnd - rowStart + 1 x colEnd - colStart + 1. Then, puts corresponding items of values {@link Array}
     * to the new result {@link Matrix}.
     *
     * @param int $rowStart integer input for defining starting index of row.
     * @param int $rowEnd integer input for defining ending index of row.
     * @param int $colStart integer input for defining starting index of column.
     * @param int $colEnd integer input for defining ending index of column.
     * @return Matrix result Matrix.
     */
    public function partial(int $rowStart, int $rowEnd, int $colStart, int $colEnd): Matrix
    {
        $result = new Matrix($rowEnd - $rowStart + 1, $colEnd - $colStart + 1, $rowStart + 1, $rowEnd + 1);
        for ($i = $rowStart; $i < $rowEnd; $i++) {
            for ($j = $colStart; $j < $colEnd; $j++) {
                $result[$i - $rowStart][$j - $colStart] = $this->values[$i][$j];
            }
        }
        return $result;
    }

    /**
     * The isSymmetric method compares each item of values {@link Array} at positions (i, j) with (j, i)
     * and returns true if they are equal, false otherwise.
     *
     * @return bool true if items are equal, false otherwise.
     */
    public function isSymmetric(): bool
    {
        for ($i = 0; $i < $this->row; $i++) {
            for ($j = 0; $j < $this->col; $j++) {
                if ($this->values[$i][$j] != $this->values[$j][$i]) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * The determinant method first creates a new {@link Array}, and copies the items of  values
     * {@link Array} into new {@link Array}. Then, calculates the determinant of this
     * new {@link Array}.
     *
     * @return float determinant of values {@link Array}.
     */
    public function determinant(): float
    {
        $det = 1.0;
        $copy = [];
        for ($i = 0; $i < $this->row; $i++) {
            $array = [];
            for ($j = 0; $j < $this->col; $j++) {
                $array[] = $this->values[$i][$j];
            }
            $copy[] = $array;
        }
        for ($i = 0; $i < $this->row; $i++) {
            $det *= $copy[$i][$i];
            if ($det == 0.0) {
                break;
            }
            for ($j = $i + 1; $j < $this->row; $j++) {
                $ratio = $copy[$j][$i] / $copy[$i][$i];
                for ($k = $i; $k < $this->col; $k++) {
                    $copy[$j][$k] -= $ratio * $copy[$i][$k];
                }
            }
        }
        return $det;
    }

    /**
     * The inverse method finds the inverse of values {@link Array}.
     *
     */
    public function inverse(): void
    {
        $b = new Matrix($this->row);
        $indxc = [];
        $indxr = [];
        $ipiv = [];
        for ($i = 0; $i < $this->row; $i++) {
            $ipiv[] = 0.0;
        }
        for ($i = 1; $i <= $this->row; $i++) {
            $big = 0.0;
            $irow = -1;
            $icol = -1;
            for ($j = 1; $j <= $this->row; $j++) {
                if ($ipiv[$j - 1] != 1) {
                    for ($k = 1; $k <= $this->row; $k++) {
                        if ($ipiv[$k - 1] == 0) {
                            if (abs($this->values[$j - 1][$k - 1]) >= $big) {
                                $big = abs($this->values[$j - 1][$k - 1]);
                                $irow = $j;
                                $icol = $k;
                            }
                        }
                    }
                }
            }
            $ipiv[$icol - 1] = $ipiv[$icol - 1] + 1;
            if ($irow != $icol) {
                for ($l = 1; $l <= $this->row; $l++) {
                    $dum = $this->values[$irow - 1][$l - 1];
                    $this->values[$irow - 1][$l - 1] = $this->values[$icol - 1][$l - 1];
                    $this->values[$icol - 1][$l - 1] = $dum;
                }
                for ($l = 1; $l <= $this->row; $l++) {
                    $dum = $b->values[$irow - 1][$l - 1];
                    $b->values[$irow - 1][$l - 1] = $b->values[$icol - 1][$l - 1];
                    $b->values[$icol - 1][$l - 1] = $dum;
                }
            }
            $indxr[] = $irow;
            $indxc[] = $icol;
            $pivinv = 1.0 / $this->values[$icol - 1][$icol - 1];
            $this->values[$icol - 1][$icol - 1] = 1.0;
            for ($l = 1; $l <= $this->row; $l++) {
                $this->values[$icol - 1][$l - 1] = $this->values[$icol - 1][$l - 1] * $pivinv;
            }
            for ($l = 1; $l <= $this->row; $l++) {
                $b->values[$icol - 1][$l - 1] = $b->values[$icol - 1][$l - 1] * $pivinv;
            }
            for ($ll = 1; $ll <= $this->row; $ll++) {
                if ($ll != $icol) {
                    $dum = $this->values[$ll - 1][$icol - 1];
                    $this->values[$ll - 1][$icol - 1] = 0.0;
                    for ($l = 1; $l <= $this->row; $l++) {
                        $this->values[$ll - 1][$l - 1] = $this->values[$ll - 1][$l - 1] - $this->values[$icol - 1][$l - 1] * $dum;
                    }
                    for ($l = 1; $l <= $this->row; $l++) {
                        $b->values[$ll - 1][$l - 1] = $b->values[$ll - 1][$l - 1] - $b->values[$icol - 1][$l - 1] * $dum;
                    }
                }
            }
        }
        for ($l = $this->row; $l >= 1; $l--) {
            if ($indxr[$l - 1] != $indxc[$l - 1]) {
                for ($k = 1; $k <= $this->row; $k++) {
                    $dum = $this->values[$k - 1][$indxr[$l - 1] - 1];
                    $this->values[$k - 1][$indxr[$l - 1] - 1] = $this->values[$k - 1][$indxc[$l - 1] - 1];
                    $this->values[$k - 1][$indxc[$l - 1] - 1] = $dum;
                }
            }
        }
    }

    /**
     * The choleskyDecomposition method creates a new {@link Matrix} and puts the Cholesky Decomposition of values Array
     * into this {@link Matrix}.
     *
     * @return Matrix Matrix type output.
     */
    public function choleskyDecomposition(): Matrix
    {
        $b = new Matrix($this->row, $this->col);
        for ($i = 0; $i < $this->row; $i++) {
            for ($j = 0; $j < $this->col; $j++) {
                $sum = $this->values[$i][$j];
                for ($k = $i - 1; $k >= 0; $k--) {
                    $sum -= $this->values[$i][$k] * $this->values[$j][$k];
                }
                if ($i == $j) {
                    $b->values[$i][$i] = sqrt($sum);
                } else {
                    $b->values[$j][$i] = $sum / $b->values[$i][$i];
                }
            }
        }
        return $b;
    }

    /**
     * The rotate method rotates values {@link Array} according to given inputs.
     *
     * @param float $s double input.
     * @param float $tau double input.
     * @param int $i integer input.
     * @param int $j integer input.
     * @param int $k integer input.
     * @param int $l integer input.
     */
    public function rotate(float $s, float $tau, int $i, int $j, int $k, int $l): void
    {
        $g = $this->values[$i][$j];
        $h = $this->values[$k][$l];
        $this->values[$i][$j] = $g - $s * ($h + $g * $tau);
        $this->values[$k][$l] = $h + $s * ($g - $h * $tau);
    }

    /**
     * The overridden clone method creates new Matrix and copies the content of values {@link Array} into new matrix.
     *
     * @return Matrix Matrix which is the copy of values {@link Array}.
     */
    public function clone(): Matrix
    {
        $copy = new Matrix($this->row, $this->col);
        for ($i = 0; $i < $this->row; $i++) {
            for ($j = 0; $j < $this->col; $j++) {
                $copy->values[$i][$j] = $this->values[$i][$j];
            }
        }
        return $copy;
    }

    /**
     * The characteristics method finds and returns a sorted {@link Array} of {@link Eigenvector}s.
     *
     * @return array a sorted {@link Array} of {@link Eigenvector}s.
     */
    public function characteristics(): array
    {
        $matrix1 = $this->clone();
        $v = new Matrix($this->row, $this->row);
        $d = [];
        $b = [];
        $z = [];
        $EPS = 0.000000000000000001;
        for ($ip = 0; $ip < $this->row; $ip++) {
            for ($iq = 0; $iq < $this->row; $iq++) {
                $v->values[$ip][$iq] = 0.0;
            }
            $v->values[$ip][$ip] = 1.0;
        }
        for ($ip = 0; $ip < $this->row; $ip++) {
            $b[] = $matrix1->values[$ip][$ip];
            $d[] = $matrix1->values[$ip][$ip];
            $z[] = 0.0;
        }
        for ($i = 1; $i <= 50; $i++) {
            $sm = 0.0;
            for ($ip = 0; $ip < $this->row - 1; $ip++) {
                for ($iq = $ip + 1; $iq < $this->row; $iq++) {
                    $sm += abs($matrix1->values[$ip][$iq]);
                }
            }
            if ($sm == 0.0) {
                break;
            }
            if ($i < 4) {
                $threshold = 0.2 * $sm / pow($this->row, 2);
            } else {
                $threshold = 0.0;
            }
            for ($ip = 0; $ip < $this->row - 1; $ip++) {
                for ($iq = $ip + 1; $iq < $this->row; $iq++) {
                    $g = 100.0 * abs($matrix1->values[$ip][$iq]);
                    if ($i > 4 && $g <= $EPS * abs($d[$ip]) && $g <= $EPS * abs($d[$iq])) {
                        $matrix1->values[$ip][$iq] = 0.0;
                    } else {
                        if (abs($matrix1->values[$ip][$iq]) > $threshold) {
                            $h = $d[$iq] - $d[$ip];
                            if ($g <= $EPS * abs($h)) {
                                $t = $matrix1->values[$ip][$iq] / $h;
                            } else {
                                $theta = 0.5 * $h / $matrix1->values[$ip][$iq];
                                $t = 1.0 / (abs($theta) + sqrt(1.0 + pow($theta, 2)));
                                if ($theta < 0.0) {
                                    $t = -$t;
                                }
                            }
                            $c = 1.0 / sqrt(1 + pow($t, 2));
                            $s = $t * $c;
                            $tau = $s / (1.0 + $c);
                            $h = $t * $matrix1->values[$ip][$iq];
                            $z[$ip] -= $h;
                            $z[$iq] += $h;
                            $d[$ip] -= $h;
                            $d[$iq] += $h;
                            $matrix1->values[$ip][$iq] = 0.0;
                            for ($j = 0; $j < $ip; $j++) {
                                $matrix1->rotate($s, $tau, $j, $ip, $j, $iq);
                            }
                            for ($j = $ip + 1; $j < $iq; $j++) {
                                $matrix1->rotate($s, $tau, $ip, $j, $j, $iq);
                            }
                            for ($j = $iq + 1; $j < $this->row; $j++) {
                                $matrix1->rotate($s, $tau, $ip, $j, $iq, $j);
                            }
                            for ($j = 0; $j < $this->row; $j++) {
                                $v->rotate($s, $tau, $j, $ip, $j, $iq);
                            }
                        }
                    }
                }
            }
            for ($ip = 0; $ip < $this->row; $ip++) {
                $b[$ip] = $b[$ip] + $z[$ip];
                $d[$ip] = $b[$ip];
                $z[$ip] = 0.0;
            }
        }
        $result = [];
        for ($i = 0; $i < $this->row; $i++) {
            if ($d[$i] > 0) {
                $result[] = new Eigenvector($d[$i], $v->getColumnVector($i));
            }
        }
        for ($i = 0; $i < count($result); $i++) {
            for ($j = $i + 1; $j < count($result); $j++) {
                if ($result[$i]->getEigenvalue() < $result[$j]->getEigenvalue()) {
                    $tmp = $result[$i];
                    $result[$i] = $result[$j];
                    $result[$j] = $tmp;
                }
            }
        }
        return $result;
    }
}