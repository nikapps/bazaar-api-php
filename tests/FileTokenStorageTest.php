<?php
namespace Nikapps\BazaarApi\Tests;

use Nikapps\BazaarApi\Models\Token;
use Nikapps\BazaarApi\Storage\FileTokenStorage;

class FileTokenStorageTest extends TestCase
{
    /** @test */
    public function it_should_save_the_token()
    {
        $tempFile = tempnam("/tmp", "FOO");

        $storage = new FileTokenStorage($tempFile);

        $token = new Token([
            "access_token" => "123456",
            "token_type" => "Bearer",
            "expires_in" => 3600,
            "scope" => "androidpublisher",
            'refresh_token' => 'refresh-token'
        ]);

        $storage->save($token);

        $this->assertFalse($storage->expired());
        $this->assertEquals('123456', $storage->retrieve());
    }

    /** @test */
    public function it_should_say_token_has_been_expired_when_token_does_not_exist()
    {
        $tempFile = tempnam("/tmp", "FOO");

        $storage = new FileTokenStorage($tempFile);

        $this->assertTrue($storage->expired());
        $this->assertNull($storage->retrieve());
    }
}
