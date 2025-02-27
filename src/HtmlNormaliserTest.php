<?php

namespace App;

use PHPUnit\Framework\TestCase;

class HtmlNormaliserTest extends TestCase
{
    public function testPurpleDangerWithStartAndEnd()
    {
        $this->assertEquals(
            '<span class="text-purple">start</span><span class="text-danger">middle</span><span class="text-purple">end</span>',
            HtmlNormaliser::flattenContent('text-purple', 'text-danger', '<span class="text-purple">start<span class="text-danger">middle</span>end</span>')
        );
    }

    public function testPurpleDangerWithStartOnly()
    {
        $this->assertEquals(
            '<span class="text-purple">start</span><span class="text-danger">middle</span>',
            HtmlNormaliser::flattenContent('text-purple', 'text-danger', '<span class="text-purple">start<span class="text-danger">middle</span></span>')
        );
    }

    public function testPurpleDangerWithEndOnly()
    {
        $this->assertEquals(
            '<span class="text-danger">middle</span><span class="text-purple">end</span>',
            HtmlNormaliser::flattenContent('text-purple', 'text-danger', '<span class="text-purple"><span class="text-danger">middle</span>end</span>')
        );
    }

    public function testDangerPurpleWithStartAndEnd()
    {
        $this->assertEquals(
            '<span class="text-danger">start</span><span class="text-purple">middle</span><span class="text-danger">end</span>',
            HtmlNormaliser::flattenContent('text-danger', 'text-purple', '<span class="text-danger">start<span class="text-purple">middle</span>end</span>')
        );
    }

    public function testDangerPurpleWithStartOnly()
    {
        $this->assertEquals(
            '<span class="text-danger">start</span><span class="text-purple">middle</span>',
            HtmlNormaliser::flattenContent('text-danger', 'text-purple', '<span class="text-danger">start<span class="text-purple">middle</span></span>')
        );
    }

    public function testDangerPurpleWithEndOnly()
    {
        $this->assertEquals(
            '<span class="text-purple">middle</span><span class="text-danger">end</span>',
            HtmlNormaliser::flattenContent('text-danger', 'text-purple', '<span class="text-danger"><span class="text-purple">middle</span>end</span>')
        );
    }
}
