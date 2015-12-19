<?php

namespace Dnsimple;


class MiscService extends ClientService
{
    public function whoami()
    {
        $result = $this->client->get(Client::versioned("whoami"));
        return $result;
    }
}
