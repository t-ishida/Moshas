<?php
/**
 * Date: 15/11/25
 * Time: 18:54.
 */

namespace Inpas;


class MatrixTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    public function setUp()
    {
        $this->target = new Matrix(array(
                array(1, 2, 3),
                array(4, 5, 6),
                array(7, 8, 9),
            ),
            array('col1', 'col2', 'col3'),
            array('row1', 'row2', 'row3')
        );
    }

    public function testLabel ()
    {
        $this->assertSame(array(
            'row1' => array('col1' => 1, 'col2' => 2, 'col3' => 3),
            'row2' => array('col1' => 4, 'col2' => 5, 'col3' => 6),
            'row3' => array('col1' => 7, 'col2' => 8, 'col3' => 9),
        ), $this->target->getInnerArray());
    }

    public function testReverse ()
    {
        $this->assertSame(array(
            'col1' => array('row1' => 1, 'row2' => 4, 'row3' => 7),
            'col2' => array('row1' => 2, 'row2' => 5, 'row3' => 8),
            'col3' => array('row1' => 3, 'row2' => 6, 'row3' => 9),
        ), $this->target->reverseMatrix());
    }



    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructNotArray()
    {
        new Matrix(1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidArgumentNumber()
    {
        new Matrix(array(), array(), array(), array());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructEmptyArray()
    {
        new Matrix(array());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidRowLabel()
    {
        new Matrix(
            array(array(1), array(2), array(3)),
            array('colLabel1'),
            array('rowLabel1', 'rowLabel2')
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidColLabel()
    {
        new Matrix(
            array(array(1), array(2), array(3)),
            array('colLabel1', 'colLabel2'),
            array('rowLabel1', 'rowLabel2', 'rowLabel3')
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructRowLabelDuplicate()
    {
        new Matrix(
            array(array(1), array(2), array(3)),
            array('colLabel1'),
            array('rowLabel1', 'rowLabel2', 'rowLabel2')
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructColLabelDuplicate()
    {
        new Matrix(
            array(array(1, 2), array(2, 3), array(3, 4)),
            array('colLabel1', 'colLabel1'),
            array('rowLabel1', 'rowLabel2', 'rowLabel3')
        );
    }

}
