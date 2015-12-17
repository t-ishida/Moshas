<?php
namespace DDP\GangLeader;
class ScoreSorterTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    public function setUp()
    {
        $this->target = new ScoreSorter();
    }

    public function testReducer()
    {
        $entity1 = new Score();
        $entity1->setScore(1);

        $entity2 = new Score();
        $entity2->setScore(2);

        $entity3 = new Score();
        $entity3->setScore(3);
        $result = $this->target->reduce(array(
            $entity1, $entity2, $entity3
        ));
        $this->assertSame($entity3, $result[0]);
        $this->assertSame($entity2, $result[1]);
        $this->assertSame($entity1, $result[2]);
    }
}