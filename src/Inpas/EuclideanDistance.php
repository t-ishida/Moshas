<?php
namespace Inpas;

class EuclideanDistance extends Recommendation
{
    protected function score ($a, $b)
    {
        $score = 0;
        foreach ($a as $i => $val) {
            $score += pow(($a[$i] - $b[$i]), 2);
        }
        return (float)(1 / (1 + $score));
    }
}