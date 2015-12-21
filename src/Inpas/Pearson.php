<?php
namespace Inpas;

class Pearson extends Recommendation
{
    protected function score ($a, $b)
    {
        $sumA = 0;
        $sumASquare = 0;
        $sumB = 0;
        $sumBSquare = 0;
        $total = 0;
        $l = 0;
        foreach ($a as $i => $val) {
            if (!$b[$i]) continue;
            $sumA += $a[$i];
            $sumB += $b[$i];
            $sumASquare += pow($a[$i], 2);
            $sumBSquare += pow($b[$i], 2);
            $total += ($a[$i] * $b[$i]);
            $l++;
        }
        if (!$l) return 0;
        $num = $total - ($sumA * $sumB / $l);
        $den = sqrt(
            ($sumASquare - pow($sumA, 2) / $l) *
            ($sumBSquare - pow($sumB, 2) / $l)
        );
        return $den > 0 ? (float)($num / $den) : 0;
    }
}