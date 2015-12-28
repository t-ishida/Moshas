<?php
/**
 * Date: 15/12/22
 * Time: 18:08.
 */

namespace Inpas;


class NaiveBayes
{
    private $words = array();
    private $wordCount = array();
    private $categoryCount = array();

    public function __construct ()
    {
    }

    public function wordCountUp($category, $word)
    {
        if (!isset($this->wordCount[$category])) {
            $this->wordCount[$category] = array();
        }
        if (!isset($this->wordCount[$category][$word])) {
            $this->wordCount[$category][$word] = 0;
        }
        $this->wordCount[$category][$word]++;
        $this->words[] = $word;
    }

    public function categoryCountUp($category)
    {
        if (!isset($this->categoryCount[$category])) {
            $this->wordCount[$category] = 0;
        }
        $this->categoryCount[$category]++;
    }

    public function train($text, $category)
    {
    }
}