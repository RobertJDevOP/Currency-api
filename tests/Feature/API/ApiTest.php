<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;

class ApiTest extends TestCase
{

    public function test_it_can_api_exceptions(): void
    {
        $response = $this->getJson('/api/v1/convert');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_response_is_json(): void
    {
        $response = $this->getJson('/api/v1/convert');
        $response->assertHeader('content-type', 'application/json');
    }


    public function test_making_an_api_request_convert(): void
    {
        $response = $this->json( 'GET','api/v1/convert/USD/COP/1000/2021-11-21',);
        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('source', 'USD')
                ->where('code', 200)
                ->etc()
            );
    }

    public function test_making_an_api_request_convert_return_valid_format(): void
    {
        $this->json('GET', 'api/v1/convert/USD/COP/1000/2021-11-21')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                            'source',
                            'success',
                            'code',
                            'created_at',
                            'result' => [
                                '*' => [
                                    'COP',
                                    'convert',
                                ]
                            ]
                ]
            );
    }

    public function test_making_an_api_request_multiple_convert_return_valid_format(): void
    {
        $this->getJson('api/v1/multipleConvert?'.http_build_query(['from'=>'USD','to'=>'COP-EUR','amount'=>1200]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'source',
                    'success',
                    'code',
                    'created_at',
                    'result' => [
                        '*' => [ ]
                    ]
                ]
            );
    }

    public function test_making_an_api_request_multiple_convert(): void
    {
        $response = $this->getJson('api/v1/multipleConvert?'.http_build_query(['from'=>'USD','to'=>'COP-EUR','amount'=>1200]));
        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('source', 'USD')
                ->where('code', 200)
                ->etc()
            );
    }
    
}
