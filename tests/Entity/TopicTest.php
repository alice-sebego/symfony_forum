<?php
namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Topic;

class TopicTest extends TestCase{
    public function testSetTitle(){
        $topic = new Topic();
        $topic->setTitle("C'est le week-end");
        $this->assertEquals("C'est le week-end", $topic->getTitle());
    }
}