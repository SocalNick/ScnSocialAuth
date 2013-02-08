<?php

namespace ScnSocialAuth\View\Helper;

use ScnSocialAuth\Mapper\UserProvider;
use ScnSocialAuth\Mapper\UserProviderInterface;
use Zend\View\Helper\AbstractHelper;
use ZfcUser\Entity\UserInterface;

class ScnUserProvider extends AbstractHelper
{
    /**
     * @var UserProvider
     */
    protected $userProviderMapper;

    /**
     * @param UserInterface $user
     * @param string $providerName
     * @return UserProviderInterface|bool
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
     * @return UserProviderInterface
     */
    protected function getUserProviderMapper()
    {
        return $this->userProviderMapper;
    }

    /**
     * @param UserProviderInterface $userProviderMapper
     * @return ScnUserProvider
     */
    public function setUserProviderMapper(UserProviderInterface $userProviderMapper)
    {
        $this->userProviderMapper = $userProviderMapper;
        return $this;
    }
}
