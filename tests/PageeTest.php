<?php

class PageeTest extends PHPUnit_Framework_TestCase
{
    public $pagee;

    public function setUp()
    {
        $this->pagee = new Pagee(array(
            'base_url'       => 'http://www.hoge.com/answers.php',
            'total_count'    => 100,
            'requested_page' => 3
        ));
    }

    public function tearDown()
    {
        unset($_GET['page']);
    }

    public function testLimitOffset()
    {
        $this->assertEquals(20, $this->pagee->limit());
        $this->assertEquals(40, $this->pagee->offset());
    }

    public function testLinks()
    {
        $this->assertEquals('<li><a href="http://www.hoge.com/answers.php?page=2">前へ</a></li>', $this->pagee->prev_link());
        $this->assertEquals('<li><a href="http://www.hoge.com/answers.php?page=1">1</a></li>', $this->pagee->first_link());
        $this->assertEquals('<li class="active"><span>...</span><a href="#">3</a><span>...</span></li>', $this->pagee->around_link());
        $this->assertEquals('<li><a href="http://www.hoge.com/answers.php?page=5">5</a></li>', $this->pagee->last_link());
        $this->assertEquals('<li><a href="http://www.hoge.com/answers.php?page=4">次へ</a></li>', $this->pagee->next_link());
    }

    public function testAppendParams()
    {
        $this->pagee->append_params(array(
            'project_id' => 100, 'user_type' => 'hoge'
        ));

        $this->assertEquals('<li><a href="http://www.hoge.com/answers.php?page=2&project_id=100&user_type=hoge">前へ</a></li>', $this->pagee->prev_link());
    }


    public function testCustomPerPage()
    {
        $pagee = new Pagee(array(
            'per_page'       => 10, //default is 20
            'total_count'    => 100,
            'requested_page' => 3
        ));

        $this->assertEquals(10, $pagee->limit());
        $this->assertEquals(20, $pagee->offset());
    }

    public function testInvalidParams()
    {
        $pagee = new Pagee(array(
            'total_count'    => 100,
            'requested_page' => -10
        ));
        $this->assertEquals(1, $pagee->current());

        $pagee = new Pagee(array(
            'total_count'    => 100,
            'requested_page' => 'hoge'
        ));
        $this->assertEquals(1, $pagee->current());
    }
}