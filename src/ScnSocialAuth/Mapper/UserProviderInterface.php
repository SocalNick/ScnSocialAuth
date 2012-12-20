<?php

namespace ScnSocialAuth\Mapper;

use Hybrid_User_Profile;
use ScnSocialAuth\Entity\UserProvider as UserProviderEntity;
use ZfcUser\Entity\UserInterface;

interface UserProviderInterface
{
    /**
     * @param  int                $providerId
     * @param  string             $provider
     * @return UserProviderEntity
     */
    public function findUserByProviderId($providerId, $provider);

    /**
     * @param  UserInterface               $user
     * @param  string                      $provider
     * @return UserProviderInterface|false
     */
    public function findProviderByUser(UserInterface $user, $provider);

    /**
     * @param  UserInterface $user
     * @return array
     */
    public function findProvidersByUser(UserInterface $user);

    /**
     * @param UserInterface       $user
     * @param Hybrid_User_Profile $hybridUserProfile
     * @param string              $provider
     * @param array               $accessToken
     */
    public function linkUserToProvider(UserInterface $user, Hybrid_User_Profile $hybridUserProfile, $provider, array $accessToken = null);
}
