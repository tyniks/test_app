<?php

namespace App\Listeners;

use App\Events\UserLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class UserRegistrationAPI
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserLogin $event)
    {
        //CHECKING IF EXIST
        $response = Http::post('https://b24-t9xeb1.bitrix24.ua/rest/1/7f79c3xgkj1aztlr/crm.duplicate.findbycomm.json', [
            'type' => 'EMAIL',
            'values' => array($event->email),
            'entity_type' => 'CONTACT'
        ]);
        $result = json_decode($response->body());

        if (empty($result->result)) {
            //IF NOT EXIST EMAIL IN CONTACTS IN BITRIX CREATE
            $clienIp = request()->ip();
            $response = Http::post('https://b24-t9xeb1.bitrix24.ua/rest/1/7f79c3xgkj1aztlr/crm.contact.add.json', [
                "fields" => [
                    'NAME' => $event->email,
                    'EMAIL' => array(
                        array(
                            "VALUE" => $event->email,
                            "VALUE_TYPE" => "WORK"
                        )
                    ),
                    'UF_CRM_1642863605858' => array("VALUE" => $clienIp)
                ]
            ]);
        }

    }
}
