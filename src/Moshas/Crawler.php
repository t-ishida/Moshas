<?php
namespace Moshas;

class Crawler
{
    private $clients = null;
    private $workers = null;
    private $reducers = null;
    public function __construct (array $clients, array $works = null, array $reducers = null)
    {
        $this->clients  = $clients;
        $this->workers  = $works;
        $this->reducers = $reducers;
    }

    public function execute()
    {
        $src = array();
        foreach ($this->clients as $client) {
            foreach ($client->run() as $row) {
                $src[] = $row;
            }
        }
        if ($this->workers && $src) {
            foreach($this->workers as $worker){
                $temp = array();
                foreach ($src as $entity) {
                    $result = $worker->work($entity);
                    if ($result){
                        $temp[] = $result;
                    }
                }
                $src = $temp;
            }
        }
        if ($this->reducers && $src) {
            foreach($this->reducers as $reducer) {
                $src = $reducer->reduce($src);
                if (!$src) {
                    $src = array();
                    break;
                }
            }
        }
        return $src;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getReducers()
    {
        return $this->reducers;
    }

    public function getWorkers()
    {
        return $this->workers;
    }
}