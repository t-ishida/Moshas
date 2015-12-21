<?php
/**
 * Date: 15/12/21
 * Time: 11:17.
 */

namespace Moshas\Text\Parse;


interface Strategy
{
    public function analyze($sentence);
}