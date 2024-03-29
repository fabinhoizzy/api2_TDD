<?php

namespace Tests\Feature\ShortUrl;
use App\Facades\Actions\CodeGenerator;
use App\Models\ShortUrl;
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

    /** @test */
    public function url_should_be_valid()
    {
        $this->postJson(
            route('api.short-url.store'),
            ['url' => 'not-valid-url']
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                  'url' => __('validation.url', ['attribute' => 'url']),
            ]);
    }

    /** @test */
    public function it_should_return_the_existed_code_if_the_url_is_the_same()
    {
        ShortUrl::factory()->create([
           'url' => 'https://www.google.com',
            'short_url' => config('app.url') . '/123456',
            'code' => '123456'
        ]);

        $this->postJson(route('api.short-url.store'),
        ['url' => 'https://www.google.com']
            )->assertJson([
                'short_url' => config('app.url') . '/123456',
        ]);

        $this->assertDatabaseCount('short_urls', 1);

    }
}
