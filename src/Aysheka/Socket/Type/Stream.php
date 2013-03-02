<?php

namespace Aysheka\Socket\Type;

class Stream implements Type
{
    function getType()
    {
        return SOCK_STREAM;
    }
}
