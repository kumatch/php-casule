<?php

namespace Kumatch\Casule;

class Casule
{
    /** @var string  */
    protected $salt = "";
    /** @var string  */
    protected $algo = "sha1";

    /**
     * @param string|null $salt
     * @param string|null $algo
     */
    public function __construct($salt = null, $algo = null)
    {
        if ($salt && is_string($salt)) {
            $this->salt = $salt;
        }

        if ($algo && is_string($algo)) {
            $this->algo = $algo;
        }
    }

    /**
     * @param array|null $attributes
     * @return string
     * @throws \Exception
     */
    public function create(array $attributes = null)
    {
        if (is_null($attributes)) {
            $attributes = array();
        }

        $data = null;
        ksort($attributes);
        foreach ($attributes as $key => $value) {
            $data .= sprintf('%s=%s;', $key, $value);
        }

        return base64_encode(hash_hmac($this->algo, $data, $this->salt, true));
    }

    /**
     * @param $token
     * @param array|null $attributes
     * @return bool
     */
    public function challenge($token, array $attributes = null)
    {
        return ($token === $this->create($attributes));
    }
}