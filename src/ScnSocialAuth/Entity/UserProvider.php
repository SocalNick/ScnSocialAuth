<?php

namespace ScnSocialAuth\Entity;

class UserProvider implements UserProviderInterface
{
    protected $userId;

    protected $providerId;

    protected $provider;

    /**
     * @return the $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param  integer      $userId
     * @return UserProvider
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return the $providerId
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * @param  integer      $providerId
     * @return UserProvider
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;

        return $this;
    }

    /**
     * @return the $provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param  string       $provider
     * @return UserProvider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }
}
