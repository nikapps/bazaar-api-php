<?php
namespace Nikapps\BazaarApi\Storage;

use Nikapps\BazaarApi\Models\Token;

interface TokenStorageInterface
{
    /**
     * @param Token $token
     */
    public function save(Token $token);

    public function retrieve();

    public function expired();
}