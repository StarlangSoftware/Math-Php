<?php

namespace olcaytaner\Math;

class Distribution
{
    const Z_MAX = 6.0;
    const Z_EPSILON = 0.000001;
    const CHI_EPSILON = 0.000001;
    const CHI_MAX = 99999.0;
    const LOG_SQRT_PI = 0.5723649429247000870717135;
    const I_SQRT_PI = 0.5641895835477562869480795;
    const BIGX = 200.0;
    const I_PI = 0.3183098861837906715377675;
    const F_EPSILON = 0.000001;
    const F_MAX = 9999.0;

    /**
     * The ex method takes a double x as an input, if x is less than -BIGX it returns 0, otherwise it returns Euler's number
     * <i>e</i> raised to the power of x.
     *
     * @param float $x double input.
     * @return float 0 if input is less than -BIGX, Euler's number <i>e</i> raised to the power of x otherwise.
     */
    private static function ex(float $x): float
    {
        if ($x < -Distribution::BIGX) {
            return 0;
        }
        return exp($x);
    }

    /**
     * The beta method takes a double {@link Array} x as an input. It loops through x and accumulates
     * the value of gammaLn(x), also it sums up the items of x and returns (accumulated result - gammaLn of this summation).
     *
     * @param array $x double {@link Array} input.
     * @return float gammaLn(sum).
     */
    static function beta(array $x): float
    {
        $sum = 0.0;
        $result = 0.0;
        for ($i = 0; $i < count($x); $i++) {
            $result += Distribution::gammaLn($x[$i]);
            $sum += $x[$i];
        }
        $result -= Distribution::gammaLn($sum);
        return $result;
    }

    /**
     * The gammaLn method takes a double x as an input and returns the logarithmic result of the gamma distribution at point x.
     *
     * @param float $x double input.
     * @return float the logarithmic result of the gamma distribution at point x.
     */
    static function gammaLn(float $x): float
    {
        $cof = [76.18009172947146, -86.50532032941677, 24.01409824083091
            , -1.231739572450155, 0.1208650973866179e-2, -0.5395239384953e-5];
        $y = $x;
        $tmp = $x + 5.5;
        $tmp -= ($x + 0.5) * log($tmp);
        $ser = 1.000000000190015;
        for ($j = 0; $j <= 5; $j++) {
            $ser += $cof[$j] / ++$y;
        }
        return -$tmp + log(2.5066282746310005 * $ser / $x);
    }

    /**
     * The zNormal method returns the probability of the given input for z normal distribution.
     *
     * @param float $z double input.
     * @return float the probability of the given input.
     */
    static function zNormal(float $z): float
    {
        if ($z == 0.0) {
            $x = 0.0;
        } else {
            $y = 0.5 * abs($z);
            if ($y >= (Distribution::Z_MAX * 0.5)) {
                $x = 1.0;
            } else {
                if ($y < 1.0) {
                    $w = $y * $y;
                    $x = ((((((((0.000124818987 * $w - 0.001075204047) * $w + 0.005198775019) * $w - 0.019198292004) * $w + 0.059054035642) * $w - 0.151968751364) * $w + 0.319152932694) * $w - 0.531923007300) * $w + 0.797884560593) * $y * 2.0;
                } else {
                    $y -= 2.0;
                    $x = (((((((((((((-0.000045255659 * $y + 0.000152529290) * $y - 0.000019538132) * $y - 0.000676904986) * $y + 0.001390604284) * $y - 0.000794620820) * $y - 0.002034254874) * $y + 0.006549791214) * $y - 0.010557625006) * $y + 0.011630447319) * $y - 0.009279453341) * $y + 0.005353579108) * $y - 0.002141268741) * $y + 0.000535310849) * $y + 0.999936657524;
                }
            }
        }
        if ($z > 0.0) {
            return (($x + 1.0) * 0.5);
        } else {
            return ((1.0 - $x) * 0.5);
        }
    }

    /**
     * The zInverse method returns the Z-Inverse of given probability value.
     *
     * @param float $p double probability.
     * @return float the Z-Inverse of given probability.
     */
    static function zInverse(float $p): float
    {
        $minz = -Distribution::Z_MAX;
        $maxz = Distribution::Z_MAX;
        $zval = 0.0;
        if ($p <= 0.0 || $p >= 1.0) {
            return (0.0);
        }
        while ($maxz - $minz > Distribution::Z_EPSILON) {
            $pval = Distribution::zNormal($zval);
            if ($pval > $p) {
                $maxz = $zval;
            } else {
                $minz = $zval;
            }
            $zval = ($maxz + $minz) * 0.5;
        }
        return $zval;
    }

    /**
     * The chiSquare method returns the probability of the given input for chi square distribution.
     *
     * @param float $x double input.
     * @param int $freedom integer input for degrees of freedom.
     * @return float the probability of the given input.
     */
    static function chiSquare(float $x, int $freedom): float
    {
        $y = 0;
        if ($x <= 0.0 || $freedom < 1) {
            return 1.0;
        }
        $a = 0.5 * $x;
        $even = ($freedom % 2 == 0);
        if ($freedom > 1) {
            $y = Distribution::ex(-$a);
        }
        if ($even) {
            $s = $y;
        } else {
            $s = (2.0 * Distribution::zNormal(-sqrt($x)));
        }
        if ($freedom > 2) {
            $x = 0.5 * ($freedom - 1.0);
            if ($even) {
                $z = 1.0;
            } else {
                $z = 0.5;
            }
            if ($a > Distribution::BIGX) {
                if ($even) {
                    $e = 0.0;
                } else {
                    $e = Distribution::LOG_SQRT_PI;
                }
                $c = log($a);
                while ($z <= $x) {
                    $e = log($z) + $e;
                    $s += Distribution::ex($c * $z - $a - $e);
                    $z += 1.0;
                }
                return $s;
            } else {
                if ($even) {
                    $e = 1.0;
                } else {
                    $e = (Distribution::I_SQRT_PI / sqrt($a));
                }
                $c = 0.0;
                while ($z <= $x) {
                    $e = $e * ($a / $z);
                    $c = $c + $e;
                    $z += 1.0;
                }
                return $c * $y + $s;
            }
        } else {
            return $s;
        }
    }

    /**
     * The chiSquareInverse method returns the Chi Square-Inverse of given probability value with given degree of freedom.
     *
     * @param float $p double probability.
     * @param int $freedom integer input for degrees of freedom.
     * @return float the chiSquare-Inverse of given probability.
     */
    static function chiSquareInverse(float $p, int $freedom): float
    {
        $minchisq = 0.0;
        $maxchisq = Distribution::CHI_MAX;
        if ($p <= 0.0) {
            return $maxchisq;
        } else {
            if ($p >= 1.0) {
                return 0.0;
            }
        }
        $chisqval = $freedom / sqrt($p);
        while ($maxchisq - $minchisq > Distribution::CHI_EPSILON) {
            if (Distribution::chiSquare($chisqval, $freedom) < $p) {
                $maxchisq = $chisqval;
            } else {
                $minchisq = $chisqval;
            }
            $chisqval = ($maxchisq + $minchisq) * 0.5;
        }
        return $chisqval;
    }

    /**
     * The fDistribution method returns the probability of the given input for F distribution.
     *
     * @param float $F double input.
     * @param int $freedom1 integer input for degrees of freedom.
     * @param int $freedom2 integer input for degrees of freedom.
     * @return float the probability of the given input.
     */
    static function fDistribution(float $F, int $freedom1, int $freedom2): float
    {
        if ($freedom1 % 2 != 0) {
            if ($F < Distribution::F_EPSILON || $freedom1 < 1 || $freedom2 < 1) {
                return (1.0);
            }
            $a = 1;
        } else {
            $a = 2;
        }
        if ($freedom2 % 2 != 0) {
            $b = 1;
        } else {
            $b = 2;
        }
        $w = ($F * $freedom1) / $freedom2;
        $z = 1.0 / (1.0 + $w);
        if ($a == 1) {
            if ($b == 1) {
                $p = sqrt($w);
                $y = Distribution::I_PI;
                $d = $y * $z / $p;
                $p = 2.0 * $y * atan($p);
            } else {
                $p = sqrt($w * $z);
                $d = 0.5 * $p * $z / $w;
            }
        } else {
            if ($b == 1) {
                $p = sqrt($z);
                $d = 0.5 * $z * $p;
                $p = 1.0 - $p;
            } else {
                $d = $z * $z;
                $p = $w * $z;
            }
        }
        $y = 2.0 * $w / $z;
        for ($j = $b + 2; $j <= $freedom2; $j += 2) {
            $d *= (1.0 + $a / ($j - 2.0)) * $z;
            if ($a == 1) {
                $p = $p + $d * $y / ($j - 1.0);
            } else {
                $p = ($p + $w) * $z;
            }
        }
        $y = $w * $z;
        $z = 2.0 / $z;
        $b = $freedom2 - 2;
        for ($i = $a + 2; $i <= $freedom1; $i += 2) {
            $j = $i + $b;
            $d *= $y * $j / ($i - 2.0);
            $p -= $z * $d / $j;
        }
        if ($p < 0.0) {
            $p = 0.0;
        } else {
            if ($p > 1.0) {
                $p = 1.0;
            }
        }
        return 1.0 - $p;
    }

    /**
     * The fDistributionInverse method returns the F-Distribution Inverse of given probability value.
     *
     * @param float $p double probability.
     * @param int $freedom1 integer input for degrees of freedom.
     * @param int $freedom2 integer input for degrees of freedom.
     * @return float the F-Distribution Inverse of given probability.
     */
    static function fDistributionInverse(float $p, int $freedom1, int $freedom2): float
    {
        $maxf = Distribution::F_MAX;
        $minf = 0.0;
        if ($p <= 0.0 || $p >= 1.0) {
            return 0.0;
        }
        if ($freedom1 == $freedom2 && $freedom1 > 2500) {
            return 1 + 4.0 / $freedom1;
        }
        $fval = 1.0 / $p;
        while (abs($maxf - $minf) > Distribution::F_EPSILON) {
            if (Distribution::fDistribution($fval, $freedom1, $freedom2) < $p) {
                $maxf = $fval;
            } else {
                $minf = $fval;
            }
            $fval = ($maxf + $minf) * 0.5;
        }
        return $fval;
    }

    /**
     * The tDistribution method returns the probability of the given input for t distribution.
     *
     * @param float $T double input.
     * @param int $freedom integer input for degrees of freedom.
     * @return float the probability of the given input.
     */
    static function tDistribution(float $T, int $freedom): float
    {
        if ($T >= 0) {
            return Distribution::fDistribution($T * $T, 1, $freedom) / 2;
        } else {
            return 1 - Distribution::fDistribution($T * $T, 1, $freedom) / 2;
        }
    }

    /**
     * The tDistributionInverse method returns the T-Distribution Inverse of given probability value.
     *
     * @param float $p       double probability.
     * @param int $freedom integer input for degrees of freedom.
     * @return float the T-Distribution Inverse of given probability.
     */
    static function tDistributionInverse(float $p, int $freedom): float
    {
        if ($p < 0.5) {
            return sqrt(Distribution::fDistributionInverse($p * 2, 1, $freedom));
        } else {
            return -sqrt(Distribution::fDistributionInverse((1 - $p) * 2, 1, $freedom));
        }
    }

}