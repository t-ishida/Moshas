<?php
namespace Inpas;

class Matrix implements \ArrayAccess, \Iterator, \Countable
{
    private $array = array();
    public function __construct (/* overload */)
    {
        $count = func_num_args();
        $values = func_get_args();
        if (is_array($values[0])) {
            $this->array = $values[0];
        } elseif (is_file($values[0])) {
            $lines = array();
            $line  = array();
            $buf = '';
            $fp = fopen($values[0], 'r');
            if (!$fp) {
                throw new \RuntimeException('not exists a file...');
            }
            while (!feof($fp)) {
                $char = fgetc($fp);
                if ($char === ' ' || $char === "\t") continue;
                if ($char === '"' || $char === "'") {
                    $quote = $char;
                    while (!feof($fp)) {
                        $char = fgetc($fp);
                        if ($char === '\\') {
                            $next = fgetc($fp);
                            if ($next === 'n') {
                                $buf .= "\n";
                            } elseif ($next === 't') {
                                $buf .= "\t";
                            } else {
                                $buf .= $next;
                            }
                        } elseif ($quote === $char) {
                            $line[] = $buf;
                            $buf = '';
                            while (!feof($fp)) {
                                $char = fgetc($fp);
                                if ($char === ',') break;
                                if ($char === "\n") {
                                    $lines[] = $line;
                                    $line = array();
                                    break;
                                }
                            }
                            break;
                        } else {
                            $buf .= $char;
                        }
                    }
                } elseif ($char === "\n") {
                    $line[] = $buf;
                    $buf = '';
                    $lines[] = $line;
                    $line = array();
                } elseif ($char === ',') {
                    $line[] = $buf;
                    $buf = '';
                } else {
                    $buf .= $char;
                }
            }
            if ($buf !== '') {
                $line[] = $buf;
            }
            if ($line) {
                $lines[] = $line;
            }
            fclose($fp);
            if (isset($values[1])) {
                if (!is_array($values[1])) {
                    unset($values[1]);
                } else {
                    $options = $values[1];
                    if ($options['header'] === true) {
                        $values[1] = array_shift($lines);
                    }
                    if ($options['rowNames'] === true) {
                        array_shift($values[1]);
                        $rowNames = array();
                        foreach ($lines as $key => $line) {
                            $rowNames[] = array_shift($line);
                            $lines[$key] = $line;
                        }
                        $values[2] =  $rowNames;
                    }
                }
            }
            $this->array = $lines;
        } else {
            throw new \InvalidArgumentException('invalid prototype');
        }
        if (!$this->array) {
            throw new \InvalidArgumentException('array is empty');
        }
        if ($count >= 2) {
            if ($count === 2 && !isset($values[2])) {
                $values[2] = range(0, count($values[0]) - 1);
            }
            $array = array();
            $colLabels = $values[1];
            $rowLabels = $values[2];
            if (count($this->array[0]) !== count($colLabels)) {
                throw new \InvalidArgumentException('Invalid col label');
            }
            if (count($this->array) !== count($rowLabels)) {
                throw new \InvalidArgumentException('Invalid row label');
            }
            $i = 0;
            foreach ($this->array as $rowKey => $rowVal) {
                if (isset($array[$rowLabels[$i]])) {
                    throw new \InvalidArgumentException('duplicate row label:' . $rowLabels[$i]);
                }
                $j = 0;
                $row = array();
                foreach ($rowVal as $colKey => $colVal) {
                    if (isset($row[$colLabels[$j]])) {
                        throw new \InvalidArgumentException('duplicate col label:' . $colLabels[$j]);
                    }
                    $row[$colLabels[$j]] = $colVal;
                    $j++;
                }
                $array[$rowLabels[$i]] = $row;
                $i++;
            }
            $this->array = $array;
        }
        foreach ($this->array as $rowKey => $rowVal) {
            foreach ($rowVal as $colVal) {
                if (strval($colVal) !== strval(intval($colVal)) && !is_float($colVal)) {
                    throw new \InvalidArgumentException('invalid table. matrix can use integer or float columns');
                }
            }
        }
    }

    public function devSquare ($key)
    {
    }

    public function populationVariance ($key)
    {
        $ave = $this->average($key);
        return   array_sum(array_map(function($val) use ($ave) {
            return pow($val - $ave,2);
        }, $this->array[$key])) / ($this->count($this->array[$key]) - 1);
    }

    public function average ($key)
    {
        return array_sum($this->array[$key]) / $this->count($this->array[$key]);;
    }

    public function getInnerArray()
    {
        return $this->array;
    }

    public function reverseMatrix()
    {
        $array = array();
        foreach ($this->array as $rowKey => $rowVal) {
            foreach ($rowVal as $colKey => $colVal) {
                $array[$colKey][$rowKey] = $colVal;
            }
        }
        return $array;
    }

    public function minKey($rowNum)
    {
        $min = min($this->array[$key]);
        foreach ($this->array as $k => $val) {
            if ($val === $min) return $k;
        }
    }

    public function maxKey($rowNum)
    {
        $max = max($this->array[$rowNum]);
        foreach ($this->array as $k => $val) {
            if ($val === $max) return $k;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->array[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->array[$offset]) ? $this->array[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->array[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }

    public function rewind()  {
        reset($this->array);
    }

    public function current() {
        return current($this->array);
    }

    public function key()     {
        return key($this->array);
    }

    public function next()    {
        return next($this->array);
    }

    public function valid()   {
        return ($this->current() !== false);
    }

    public function count() {
        return count($this->array);
    }
}