<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class CardTest extends TestComponent
{
    public function testCardComponent()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info bg-white">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-card>test</x-card>');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::card>test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card') test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentColor()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-primary bg-white">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-card color="primary">test</x-card>');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::card color="primary">test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['color' => 'primary']) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentbgColor()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-primary bg-primary">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-card color="primary" bg-color="primary">test</x-card>');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::card color="primary" bg-color="primary">test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['color' => 'primary', 'bg-color' => 'primary']) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithoutOutline()
    {
        $expected = <<<'HTML'
<div class="card card-info bg-white">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-card outline=false>test</x-card>');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::card :outline=false>test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['outline' => false]) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithTitle()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info bg-white">
    <div class="card-header border-bottom-0">
        <h3 class="card-title">Dashboard</h3>
    </div>
    <div class="card-body pt-0">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-card title="boilerplate::layout.dashboard">test</x-card>');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::card title="boilerplate::layout.dashboard">test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['title' => 'boilerplate::layout.dashboard']) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithTitleAndTools()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info bg-white">
    <div class="card-header border-bottom-0">
        <h3 class="card-title">title</h3>
        <div class="card-tools">
            <a href="#">close</a>
        </div>
    </div>
    <div class="card-body pt-0">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-card title="title"><x-slot name="tools"><a href="#">close</a></x-slot> test</x-card>');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::card title="title"><x-slot name="tools"><a href="#">close</a></x-slot> test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['title' => 'title'])@slot('tools')<a href=\"#\">close</a> @endslot test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithHeader()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info bg-white">
    <div class="card-header border-bottom-0">
        <a href="#">link</a>
    </div>
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-card><x-slot name="header"><a href="#">link</a></x-slot> test</x-card>');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::card><x-slot name="header"><a href="#">link</a></x-slot> test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card')@slot('header')<a href=\"#\">link</a> @endslot test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithFooter()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info bg-white">
    <div class="card-body">test</div>
    <div class="card-footer"><a href="#">link</a></div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-card><x-slot name="footer"><a href="#">link</a></x-slot> test</x-card>');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::card><x-slot name="footer"><a href="#">link</a></x-slot> test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card')@slot('footer')<a href=\"#\">link</a> @endslot test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithTabs()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-outline-tabs card-info bg-white">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-card tabs="true">test</x-card>');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::card tabs="true">test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['tabs' => true]) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithAttributes()
    {
        $expected = <<<'HTML'
<div class="card card-info bg-white" id="test" data-test="ok">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-card outline=false id="test" data-test="ok">test</x-card>');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::card :outline=false id="test" data-test="ok">test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['outline' => false, 'id' => 'test', 'data-test' => 'ok']) test @endcomponent");
        $this->assertEquals($expected, $view);
    }
}
