<?php
namespace Nikapps\BazaarApi\Storage;

use Nikapps\BazaarApi\Models\Token;

class FileTokenStorage implements TokenStorageInterface
{
    /**
     * Path to token file
     *
     * @var string
     */
    private $path;

    /**
     * FileTokenStorage constructor.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Token $token)
    {
        $expireTime = time() + $token->lifetime();

        $data = json_encode([
            'expireTime' => $expireTime,
            'token' => $token->accessToken()
        ]);

        file_put_contents($this->path, $data);
    }


    /**
     * {@inheritdoc}
     */
    public function retrieve()
    {
        if (!is_null($data = $this->read())) {
            return $data['token'];
        }

        return null;

    }

    /**
     * {@inheritdoc}
     */
    public function expired()
    {
        if (!is_null($data = $this->read())) {
            return $data['expireTime'] < time();
        }

        return true;
    }

    /**
     * Read token file
     *
     * @return array|null
     */
    protected function read()
    {
        if (!file_exists($this->path)) {
            return null;
        }

        $data = json_decode(file_get_contents($this->path), true);

        if (!$data || empty($data) || !isset($data['token'], $data['expireTime'])) {
            return null;
        }

        return $data;
    }
}