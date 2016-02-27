<?php
namespace Nikapps\BazaarApi\Tests;

use Nikapps\BazaarApi\Bazaar;
use Nikapps\BazaarApi\Client\ClientInterface;

class AccessTokenTest extends TestCase
{
    /** @test */
    public function it_should_fetch_access_token()
    {
        $bazaar = $this->makeBazaar();

        $redirectUrl = 'http://example.com/callback';

        $bazaar = $this->makeBazaar();

        $this->setClient(
            'post',
            $this->makeTokenUrl(),
            [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => 'client-id',
                    'client_secret' => 'client-secret',
                    'code' => 'code-123456',
                    'redirect_uri' => $redirectUrl
                ]
            ],
            [
                "access_token" => "123456",
                "token_type" => "Bearer",
                "expires_in" => 3600,
                "refresh_token" => "refresh-123456",
                "scope" => "androidpublisher"
            ]
        );

        $token = $bazaar->token($redirectUrl, ['code' => 'code-123456']);

        $this->assertFalse($token->failed());
        $this->assertEquals('123456', $token->accessToken());
        $this->assertEquals('Bearer', $token->type());
        $this->assertEquals(3600, $token->lifetime());
        $this->assertEquals('refresh-123456', $token->refreshToken());
        $this->assertEquals('androidpublisher', $token->scope());
    }
}