<?php
namespace Nikapps\BazaarApi\Storage;

use Nikapps\BazaarApi\Models\Token;

interface TokenStorageInterface
{
    /**
     * Store access token
     *
     * @param Token $token
     */
    public function save(Token $token);

    /**
     * Retrieve access token
     *
     * @return string|null
     */
    public function retrieve();

    /**
     * Is token expired?
     *
     * @return bool
     */
    public function expired();
}