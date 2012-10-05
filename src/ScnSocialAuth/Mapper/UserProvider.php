<?php

namespace ScnSocialAuth\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Stdlib\Hydrator\HydratorInterface;

class UserProvider extends AbstractDbMapper implements UserProviderInterface
{
    protected $tableName  = 'user_provider';

    public function findUserByProviderId($providerId, $provider)
    {
        $select = $this
            ->getSelect()
            ->from($this->tableName)
            ->where(
                array(
                    'provider_id' => $providerId,
                    'provider' => $provider,
                )
            );

        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        return parent::insert($entity, $tableName, $hydrator);
    }
}
