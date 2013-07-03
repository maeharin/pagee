<?php

class PageeTest extends PHPUnit_Framework_TestCase
{
    public $pagee;

    public function setUp()
    {
        $this->pagee = Pagee::create(array(
            'base_url'       => 'http://www.hoge.com/answers.php',
            'total_count'    => 1010,
            'requested_page' => '6'
        ));
    }

    public function tearDown()
    {
    }

    public function testLimitOffset()
    {
        $this->assertEquals(20, $this->pagee->limit());
        $this->assertEquals(100, $this->pagee->offset());
    }

    public function testBaseValues()
    {
        $this->assertEquals(6, $this->pagee->current());
        $this->assertEquals(51, $this->pagee->last());
        $this->assertEquals(1010, $this->pagee->total_count());
    }

    public function testLinks()
    {
        $this->assertEquals('<li><a href="http://www.hoge.com/answers.php?page=5">prev</a></li>', $this->pagee->prev_link());
        $this->assertEquals('<li><a href="http://www.hoge.com/answers.php?page=1">1</a></li>', $this->pagee->first_link());
        $this->assertEquals('<li class="active"><span>6</span></li>', $this->pagee->current_element());
        $this->assertEquals('<li><a href="http://www.hoge.com/answers.php?page=51">51</a></li>', $this->pagee->last_link());
        $this->assertEquals('<li><a href="http://www.hoge.com/answers.php?page=7">next</a></li>', $this->pagee->next_link());
    }

    public function testAppendParams()
    {
        $this->pagee->append_params(array(
            'project_id' => 100, 'user_type' => 'hoge'
        ));

        $this->assertEquals('<li><a href="http://www.hoge.com/answers.php?page=5&project_id=100&user_type=hoge">prev</a></li>', $this->pagee->prev_link());
    }

    public function testFirstPage()
    {
        $pagee = Pagee::create(array(
            'total_count'    => 100,
            'requested_page' => '1'
        ));

        $this->assertTrue($pagee->is_first());
        $this->assertEquals('', $pagee->prev_link());
        $this->assertEquals('', $pagee->first_link());
    }

    public function testLastPage()
    {
        $pagee = Pagee::create(array(
            'total_count'    => 100,
            'requested_page' => '5'
        ));

        $this->assertTrue($pagee->is_last());
        $this->assertEquals('', $pagee->next_link());
        $this->assertEquals('', $pagee->last_link());
    }

    public function testCustomPerPage()
    {
        $pagee = Pagee::create(array(
            'per_page'       => 10, //default is 20
            'total_count'    => 100,
            'requested_page' => '3'
        ));

        $this->assertEquals(10, $pagee->limit());
        $this->assertEquals(20, $pagee->offset());
    }

    public function testInvalidParams()
    {
        $pagee = Pagee::create(array(
            'total_count'    => 100,
            'requested_page' => '-10'
        ));
        $this->assertEquals(1, $pagee->current());

        $pagee = Pagee::create(array(
            'total_count'    => 100,
            'requested_page' => 'hoge'
        ));
        $this->assertEquals(1, $pagee->current());

        $pagee = Pagee::create(array(
            'total_count'    => 100,
            'requested_page' => '0'
        ));
        $this->assertEquals(1, $pagee->current());
    }
}
