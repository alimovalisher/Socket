<?php

namespace Aysheka\Socket\Type;

class Rdm implements Type
{
    function getType()
    {
        return SOCK_RDM;
    }
}
