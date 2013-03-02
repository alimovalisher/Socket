<?php

namespace Aysheka\Socket\Address;

class Unix implements Address
{
    function getType()
    {
        return AF_UNIX;
    }
}
