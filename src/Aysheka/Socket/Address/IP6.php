<?php

namespace Aysheka\Socket\Address;

class IP6 implements Address
{
    function getType()
    {
        return AF_INET6;
    }
}
