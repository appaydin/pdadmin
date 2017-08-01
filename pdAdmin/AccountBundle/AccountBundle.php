<?php

namespace AccountBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AccountBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
