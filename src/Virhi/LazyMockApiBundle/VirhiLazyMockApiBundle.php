<?php

namespace Virhi\LazyMockApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VirhiLazyMockApiBundle extends Bundle
{
    public function getParent()
    {
        return 'VirhiAdminBundle';
    }
}
