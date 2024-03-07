<?php

namespace Tests\Feature\ShortUrl;
use App\Facades\Actions\CodeGenerator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_create_a_short_url()
    {
        $random = Str::random(5);

        CodeGenerator::shouldReceive('run')
            ->once()
            ->andReturn($random);

        $this->withExceptionHandling();

        $this->postJson(
            route('api.short-url.store'),
            ['url' => 'https://www.google.com']
        )->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'short_url' => config('app.url'). '/' . $random,
            ]);

        $this->assertDatabaseHas('short_urls', [
            'url' => 'https://www.google.com',
            'short_url' => config('app.url') . '/' . $random,
            'code' => $random,
        ]);
    }
}
