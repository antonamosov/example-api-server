<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfficeCollection;
use App\Models\Client;

class ClientOfficeController extends Controller
{
    public function index(Client $client)
    {
        return new OfficeCollection($client->company->offices);
    }
}
