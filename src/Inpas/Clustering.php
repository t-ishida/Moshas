<?php
namespace Inpas;
class Clustering
{
    private $data = null;

    public function __construct(Matrix $matrix)
    {
        $this->data = $matrix;
    }

    public function calc($k)
    {
        $data = $this->data->getInnerArray();
        if ($k <= 0) {
            throw new \InvalidArgumentException("ERROR: K must be a positive integer greater than 0");
        }
        $oldCentroids = $this->randomCentroids($k);
        while (true) {
            $clusters = $this->assignPoints($oldCentroids, $k);
            $newCentroids = $this->calcCenter($clusters);
            if ($oldCentroids === $newCentroids) {
                return (array("centroids" => $newCentroids, "clusters" => $clusters));
            }
            $oldCentroids = $newCentroids;
        }
    }

    function calcCenter($clusters)
    {
        $data = $this->data->getInnerArray();
        $clusterElementsCoords = array();
        foreach ($clusters as $numCluster => $clusterElements) {
            foreach ($clusterElements as $clusterElement) {
                $clusterElementsCoords[$numCluster][] = $data[$clusterElement];
            }
        }
        $clusterCenters = array();
        foreach ($clusterElementsCoords as $clusterElementCoords) {
            $clusterCenters[] = $this->recenter($clusterElementCoords);
        }
        return $clusterCenters;
    }

    function recenter($coords)
    {
        $rowKeys = array_keys($coords);
        $columnKeys = array_keys($coords[$rowKeys[0]]);
        $dim = count($columnKeys);
        $axis = array();
        foreach ($coords as $k) {
            for ($a = 0; $a < $dim; $a++) {
                if (!isset($axis[$a])) {
                    $axis[$a] = 0;
                }
                $axis[$a] += $k[$columnKeys[$a]];
            }
        }
        for ($a = 0; $a < $dim; $a++) {
            $center[$a] = round($axis[$a] / count($coords), 2);
        }
        return $center;
    }

    public function randomCentroids($k)
    {
        $axis = array();
        $data = $this->data->getInnerArray();
        $rowNames = array_keys($data);
        $columnNames = array_keys($data[$rowNames[0]]);
        $dim = count($columnNames);
        foreach ($data as $j) {
            for ($a = 0; $a < $dim; $a++) {
                $axis[$a][] = $j[$columnNames[$a]];
            }
        }
        $centroids = array();
        for ($kk = 0; $kk < $k; $kk++) {
            for ($a = 0; $a < $dim; $a++) {
                $centroids[$kk][$a] = rand(min($axis[$a]), max($axis[$a]));
            }
        }
        return $centroids;
    }

    function dist($v1, $v2)
    {
        $dim = count($v1);
        $columnNames = array_keys($v1);
        $d = array();
        for ($a = 0; $a < $dim; $a++) {
            $d[] = pow(abs($v1[$columnNames[$a]] - $v2[$a]), 2);
        }
        return round(sqrt(array_sum($d)), 2);
    }

    function assignPoints($centroids, $k)
    {
        $distances = array();
        $tentativeClusters = array();
        foreach ($this->data as $datumIndex => $datum) {
            foreach ($centroids as $centroid) {
                $distances[$datumIndex][] = $this->dist($datum, $centroid);
            }
        }
        $distancesFromClusters = array();
        foreach ($distances as $distanceIndex => $distance) {
            $whichCluster = $this->minKey($distance);
            $tentativeClusters[$whichCluster][] = $distanceIndex;
            $distancesFromClusters = array("$distanceIndex" => $distance);
        }

        $clusters = array();
        if (count($tentativeClusters) < $k) {
            $pointAsCluster = $this->maxKey($distancesFromClusters);
            foreach ($tentativeClusters as $tentativeIndex => $tentativeCluster) {
                foreach ($tentativeCluster as $tentativeElement) {
                    if ($tentativeElement === $pointAsCluster) {
                        $clusters[$k + 1][] = $tentativeElement;
                    } else $clusters[$tentativeIndex][] = $tentativeElement;
                }
            }
        } else {
            $clusters = $tentativeClusters;
        }
        return $clusters;
    }

    function minKey($array)
    {
        $min = min($array);
        foreach ($array as $k => $val) {
            if ($val === $min) return $k;
        }
    }

    function maxKey($array)
    {
        $max = max($array);
        foreach ($array as $k => $val) {
            if ($val === $max) return $k;
        }
    }

    public function __toString()
    {
        $result = '';
        try {
            $clusters = $this->calc(4)['clusters'];
            foreach ($clusters as $cluster => $values) {
                foreach ($values as $value) {
                    $result .= "$cluster\t$value\n";
                }
            }
        } catch (\Exception $e) {
            $result = var_export($e, true);
        }
        return $result;
    }
}
