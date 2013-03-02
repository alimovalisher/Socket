<?php

namespace Aysheka\Socket\Address;

class IP4 implements Address
{
    function getType()
    {
        return AF_INET;
    }
}
