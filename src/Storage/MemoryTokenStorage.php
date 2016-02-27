<?php
namespace Nikapps\BazaarApi\Storage;

use Nikapps\BazaarApi\Models\Token;

class MemoryTokenStorage implements TokenStorageInterface
{

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var int
     */
    protected $expireTime;

    /**
     * @param Token $token
     */
    public function save(Token $token)
    {
        $this->token = $token;
        $this->expireTime = $token->lifetime() + time();
    }

    public function retrieve()
    {
        if (is_null($this->token)) {
            return null;
        }

        return $this->token->accessToken();
    }

    public function expired()
    {
        return time() > $this->expireTime;
    }
}