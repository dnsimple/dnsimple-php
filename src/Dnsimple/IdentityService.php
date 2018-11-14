<?php

namespace Dnsimple;


class IdentityService extends ClientService
{
    /**
     * Retrieves the details about the current authenticated entity used to access the API.
     *
     * @return  Response
     */
    public function whoami()
    {
        $response = $this->client->get(Client::versioned("/whoami"));

        return new Response($response);
    }
}
