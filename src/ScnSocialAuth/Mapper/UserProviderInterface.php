<?php

namespace ScnSocialAuth\Mapper;

interface UserProviderInterface
{
    public function findUserByProviderId($providerId, $provider);
}
