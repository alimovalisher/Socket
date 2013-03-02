<?php

namespace Aysheka\Socket\Transport;

class TCP implements Transport
{
    function getType()
    {
        return SOL_TCP;
    }
}
