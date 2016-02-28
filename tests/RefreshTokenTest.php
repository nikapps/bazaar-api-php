<?php
namespace Nikapps\BazaarApi\Tests;

use Nikapps\BazaarApi\Bazaar;
use Nikapps\BazaarApi\Client\ClientInterface;
use Nikapps\BazaarApi\Models\Token;

class RefreshTokenTest extends TestCase
{
    /** @test */
    public function it_should_refresh_the_token()
    {
        $bazaar = $this->makeBazaar();

        $this->setClient(
            'post',
            $this->makeTokenUrl(),
            [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'client_id' => 'client-id',
                    'client_secret' => 'client-secret',
                    'refresh_token' => 'refresh-token'
                ]
            ],
            [
                "access_token" => "123456",
                "token_type" => "Bearer",
                "expires_in" => 3600,
                "scope" => "androidpublisher"
            ]
        );

        $token = $bazaar->refreshToken();

        $this->assertFalse($token->failed());
        $this->assertEquals('123456', $token->accessToken());
        $this->assertEquals('Bearer', $token->type());
        $this->assertEquals(3600, $token->lifetime());
        $this->assertEquals('refresh-token', $token->refreshToken());
        $this->assertEquals('androidpublisher', $token->scope());
    }

    /** @test */
    public function it_should_refresh_the_token_and_store_it()
    {
        $bazaar = $this->makeBazaar();

        $this->setClient(
            'post',
            $this->makeTokenUrl(),
            [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'client_id' => 'client-id',
                    'client_secret' => 'client-secret',
                    'refresh_token' => 'refresh-token'
                ]
            ],
            [
                "access_token" => "123456",
                "token_type" => "Bearer",
                "expires_in" => 3600,
                "scope" => "androidpublisher"
            ]
        );

        $this->storage
            ->save(new Token([
                "access_token" => "123456",
                "token_type" => "Bearer",
                "expires_in" => 3600,
                "scope" => "androidpublisher",
                'refresh_token' => 'refresh-token'
            ]))
            ->shouldBeCalled();

        $token = $bazaar->refreshTokenAndStore();

        $this->assertFalse($token->failed());
        $this->assertEquals('123456', $token->accessToken());
    }
}
