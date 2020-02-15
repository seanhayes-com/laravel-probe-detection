<?php

namespace SeanHayes\Probe\Tests;

use SeanHayes\Probe\Probe;

class ProbeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->assertCount(0, Probe::all());
    }

   /** @test */
   public function it_can_create_a_probe_log()
   {
       $probe = Probe::findOrCreateFromString('string');

       $this->assertCount(1, Probe::all());
   }
}
