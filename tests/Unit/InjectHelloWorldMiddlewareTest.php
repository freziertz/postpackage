<?php

namespace Freziertz\PostPackage\Tests\Unit;

use Illuminate\Http\Request;
use Freziertz\PostPackage\Http\Middleware\InjectHelloWorld;
use Freziertz\PostPackage\Tests\TestCase;

class InjectHelloWorldMiddlewareTest extends TestCase
{
    /** @test */
    function it_checks_for_a_hello_word_in_response()
    {
        // Given we have a request
        $request = new Request();

        // when we pass the request to this middleware,
        // the response should contain 'Hello World'
        $response = (new InjectHelloWorld())->handle($request, function ($request) { });

       

        $this->assertStringContainsString('Hello World', $response);
    }
}
