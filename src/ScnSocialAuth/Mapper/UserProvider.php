<?php

namespace ScnSocialAuth\Mapper;

use Hybrid_User_Profile;
use ScnSocialAuth\Entity\UserProvider as UserProviderEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZfcBase\Mapper\AbstractDbMapper;
use ZfcUser\Entity\UserInterface;

class UserProvider extends AbstractDbMapper implements UserProviderInterface
{
    protected $tableName  = 'user_provider';

    /**
     * @param  int                $providerId
     * @param  string             $provider
     * @return UserProviderEntity
     */
    public function findUserByProviderId($providerId, $provider)
    {
        $sql    = $this->getSql();
        $select = $sql->select();
        $select->from($this->tableName)
               ->where(array(
                   'provider_id' => $providerId,
                   'provider'    => $provider,
               ));

        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    /**
     * @param  UserInterface               $user
     * @param  string                      $provider
     * @return UserProviderInterface|false
     */
    public function findProviderByUser(UserInterface $user, $provider)
    {
        $select = $this->getSelect()
            ->where(array(
                'user_id' => $user->getId(),
                'provider' => $provider,
            ));

        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    /**
     * @param  UserInterface $user
     * @return array
     */
    public function findProvidersByUser(UserInterface $user)
    {
        $select = $this->getSelect()
            ->where(array(
                'user_id' => $user->getId(),
            ));

        $result = $this->select($select);
        $return = array();
        foreach ($result as $entity) {
            $return[$entity->getProvider()] = $entity;
            $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        }

        return $return;
    }

    /**
     * Proxy to parent protected method
     *
     * @param  object|array                $entity
     * @param  string|TableIdentifier|null $tableName
     * @param  HydratorInterface|null      $hydrator
     * @return ResultInterface
     */
    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        return parent::insert($entity, $tableName, $hydrator);
    }

    /**
     * @param UserInterface       $user
     * @param Hybrid_User_Profile $hybridUserProfile
     * @param string              $provider
     * @param array               $accessToken
     */
    public function linkUserToProvider(UserInterface $user, Hybrid_User_Profile $hybridUserProfile, $provider, array $accessToken = null)
    {
        $userProvider = $this->findUserByProviderId($hybridUserProfile->identifier, $provider);

        if (false != $userProvider) {
            if ($user->getId() == $userProvider->getUserId()) {
                // already linked
                return;
            }
            throw new Exception\RuntimeException('This ' . ucfirst($provider) . ' profile is already linked to another user.');
        }

        $userProvider = clone($this->getEntityPrototype());
        $userProvider->setUserId($user->getId())
            ->setProviderId($hybridUserProfile->identifier)
            ->setProvider($provider);
        $this->insert($userProvider);
    }
}
