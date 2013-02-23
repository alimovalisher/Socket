<?php

namespace Aysheka\Socket\Protocol;

class TCP implements Protocol
{
    function getType()
    {
        return SOL_TCP;
    }

}
