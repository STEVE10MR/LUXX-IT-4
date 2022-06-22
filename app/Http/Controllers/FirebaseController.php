<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


class FirebaseController extends Controller
{
    private $firebase;
    private $db;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile('../key/realtime-9e386-firebase-adminsdk-bz0ag-5f86b33375.json');
        $this->firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://realtime-9e386-default-rtdb.firebaseio.com/')
        ->create();

        $this->database = $this->firebase->getDatabase();
    }
    public function Map()
    {
        $reference = $this->database->getReference('delivery/coord');
        $reference->push(['delivery_id'=>1,'lat'=>2,'lon'=>1]);

        print_r($reference->getvalue());
    }
    public function index()
    {
        $reference = $this->database->getReference('delivery/coord');
        $reference->push(['delivery_id'=>1,'lat'=>2,'lon'=>1]);

        print_r($reference->getvalue());
    }
}

