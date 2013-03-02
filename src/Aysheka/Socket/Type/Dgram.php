<?php

namespace Aysheka\Socket\Type;

class Dgram implements Type
{
    function getType()
    {
        return SOCK_DGRAM;
    }
}
