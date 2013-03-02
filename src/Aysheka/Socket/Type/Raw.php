<?php

namespace Aysheka\Socket\Type;

class Raw implements Type
{
    function getType()
    {
        return SOCK_RAW;
    }
}
