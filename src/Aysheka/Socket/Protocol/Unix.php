<?php

namespace Aysheka\Socket\Protocol;

class Unix implements Protocol
{
    function getType()
    {
        return SOL_UDP;
    }

}
