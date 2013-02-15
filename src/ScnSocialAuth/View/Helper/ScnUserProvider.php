<?php

namespace ScnSocialAuth\View\Helper;

use ScnSocialAuth\Mapper\UserProviderInterface as UserProviderMapper;
use Zend\View\Helper\AbstractHelper;
use ZfcUser\Entity\UserInterface;

class ScnUserProvider extends AbstractHelper
{
    /**
     * @var UserProviderMapper
     */
    protected $userProviderMapper;

    /**
     * @param  UserInterface           $user
     * @param  string                  $providerName
     * @return UserProviderMapper|bool
     */
    public function __invoke(UserInterface $user, $providerName)
    {
        if ($this->getUserProviderMapper()) {
            return $this->getUserProviderMapper()->findProviderByUser($user, $providerName);
        } else {
            return false;
        }
    }

    /**
     * @return UserProviderMapper
     */
    protected function getUserProviderMapper()
    {
        return $this->userProviderMapper;
    }

    /**
     * @param  UserProviderMapper $userProviderMapper
     * @return ScnUserProvider
     */
    public function setUserProviderMapper(UserProviderMapper $userProviderMapper)
    {
        $this->userProviderMapper = $userProviderMapper;

        return $this;
    }
}
