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
            ->select()
            ->from($this->tableName)
            ->where(
                array(
                    'provider_id' => $providerId,
                    'provider' => $provider,
                )
            );

        $entity = $this->selectWith($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }
}
