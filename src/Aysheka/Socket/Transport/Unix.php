<?php

namespace Aysheka\Socket\Transport;

class Unix implements Transport
{
    function getType()
    {
        return SOL_UDP;
    }
}
