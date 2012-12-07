<?php

namespace ScnSocialAuth\Entity;

interface UserProviderInterface
{
    /**
     * @return the $userId
     */
    public function getUserId();

    /**
     * @param  integer               $userId
     * @return UserProviderInterface
     */
    public function setUserId($userId);

    /**
     * @return the $providerId
     */
    public function getProviderId();

    /**
     * @param  integer               $providerId
     * @return UserProviderInterface
     */
    public function setProviderId($providerId);

    /**
     * @return the $provider
     */
    public function getProvider();

    /**
     * @param  string                $provider
     * @return UserProviderInterface
     */
    public function setProvider($provider);
}
