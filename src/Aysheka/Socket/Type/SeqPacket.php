<?php

namespace Aysheka\Socket\Type;

class SeqPacket implements Type
{
    function getType()
    {
        return SOCK_SEQPACKET;
    }
}
