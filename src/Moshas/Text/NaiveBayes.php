<?php
/**
 * see http://gihyo.jp/dev/serial/01/machine-learning/0003
 */
namespace Moshas\Text;
use Moshas\Worker;

class NaiveBayes implements Worker
{
    private $words = array();
    private $client = null;
    private $wordCount = array();
    private $categoryCount = array();

    public function __construct ($client, $trainingData = null)
    {
        $this->client = $client;
        if ($trainingData) {
            foreach ($trainingData as $data) {
                $this->train($data->document, $data->category);
            }
        }
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
            $this->categoryCount[$category] = 0;
        }
        $this->categoryCount[$category]++;
    }

    public function train($doc, $category)
    {
        foreach ($this->client->analyze($doc) as $word) {
            $this->wordCountUp($category, $word->getSurface());
        }
        $this->categoryCountUp($category);
    }

    public function priorProb($category)
    {
        return $this->categoryCount[$category] /
            array_sum(array_values($this->categoryCount));
    }


    public function inCategory($category, $word)
    {
        if (isset($this->wordCount[$category][$word])){
            return $this->wordCount[$category][$word];
        }
        return 0.0;
    }

    public function wordProbably($category, $word)
    {
        return  ($this->inCategory($category, $word) + 1.0) /
            (array_sum(array_values($this->wordCount[$category])) +
                count($this->words) * 1.0);

    }

    public function score($category, $word)
    {
        $score = log($this->priorprob($category));
        foreach ($word as $w) {
            $score += log($this->wordProbably($category, $w));
        }
        return $score;
    }

    public function classifier($doc, $words = null)
    {
        $best = null;
        $max = -1 * PHP_INT_MAX;
        if (!$words) {
            $words = array_map(
                function($row) {return $row->getSurface();},
                $doc instanceof Entity ? $doc->getWords() : $this->client->analyze($doc)
            );
        }

        foreach (array_keys($this->categoryCount) as $category){
            $probably = $this->score($category, $words);
            if ($probably > $max) {
                $max = $probably;
                $best = $category;
            }
        }
        return $best;
    }

    public function work($entity)
    {
        return new Entity(
            $entity,
            $entity->getWords(),
            $this->classifier($entity)
        );
    }
}
