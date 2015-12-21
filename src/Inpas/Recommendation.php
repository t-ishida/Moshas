<?php
namespace Inpas;

abstract class Recommendation
{

    private $datas = array();

    public function __construct(/* overloads */)
    {
        $count = func_num_args();
        $values = func_get_args();
        if ($count === 1 && ($values[0] instanceof Matrix)) {
            $this->datas = $values[0];
        } elseif ($count === 1 && is_array($values[0])) {
            $this->datas = new Matrix($values[0]);
        } else {
            throw new \InvalidArgumentException('invalid prototype');
        }
    }

    public function calc()
    {
        $result = array();
        foreach ($this->datas as $key => $val) {
            foreach ($this->datas as $key2 => $val2) {
                if ($key === $key2) continue;
                $result[$key][$key2] = $this->score($val, $val2);
            }
            arsort($result[$key]);
        }
        return $result;
    }

    public function matches($name)
    {
        if (!isset($this->datas[$name])) {
            throw new \InvalidArgumentException($name . ' is not exists.');
        }
        $result = $this->calc();
        return $result[$name];
    }

    public function topMatches($name)
    {
        if (!isset($this->datas[$name])) {
            throw new \InvalidArgumentException($name . ' is not exists.');
        }
        $result = $this->matches($name);
        return each($result);
    }

    public function similarityItem($itemIndex)
    {
        $array = $this->datas->reverseMatrix();
        $result = array();
        foreach ($array as $key => $val) {
            foreach ($array as $key2 => $val2) {
                if ($key === $key2) continue;
                $result[$key][$key2] = $this->score($val, $val2);
            }
            arsort($result[$key]);
        }
        return $result[$itemIndex];
    }

    public function recommendItem($name)
    {
        if (!isset($this->datas[$name])) {
            throw new \InvalidArgumentException($name . ' is not exists.');
        }
        $result = array();
        foreach ($this->datas as $key => $val) {
            if ($key === $name) continue;
            $sim = $this->score($this->datas[$name], $val);
            if ($sim <= 0) continue;
            foreach ($val as $i => $val2) {
                if ($this->datas[$name][$i] > 0) continue;
                if (!isset($result[$i])) {
                    $result[$i] = array('score' => 0, 'similarity' => 0);
                }
                $result[$i]['score']      += $val[$i] * $sim;
                $result[$i]['similarity'] += $sim;
            }
        }
        foreach ($this->datas[$name] as $i => $val) {
            $result[$i] = !isset($result[$i]) ? 0 : $result[$i]['score'] / $result[$i]['similarity'];
        }
        arsort($result);
        return $result;
    }

    protected abstract function score($a, $b);

    function __toString ()
    {
        return var_export($this->calc(), true);
    }
}