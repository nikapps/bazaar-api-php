<?php
namespace Nikapps\BazaarApi\Storage;

use Nikapps\BazaarApi\Models\Token;

class MemoryTokenStorage implements TokenStorageInterface
{

    /**
     * token object
     *
     * @var Token
     */
    protected $token;

    /**
     * expire time
     *
     * @var int
     */
    protected $expireTime;

    /**
     * {@inheritdoc}
     */
    public function save(Token $token)
    {
        $this->token = $token;
        $this->expireTime = $token->lifetime() + time();
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve()
    {
        if (is_null($this->token)) {
            return null;
        }

        return $this->token->accessToken();
    }

    /**
     * {@inheritdoc}
     */
    public function expired()
    {
        return time() > $this->expireTime;
    }
}
