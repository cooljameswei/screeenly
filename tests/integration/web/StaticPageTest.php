<?php


class StaticPageTest extends TestCase
{
    /** @test */
    public function it_loads_terms_of_service_page()
    {
        $this->visit('/terms');
    }

    /** @test */
    public function it_loads_aboug_page()
    {
        $this->visit('/about');
    }

    /** @test */
    public function it_loads_imprint_page()
    {
        $this->visit('/imprint');
    }

    /** @test */
    public function it_loads_privacy_page()
    {
        $this->visit('/privacy');
    }
}
