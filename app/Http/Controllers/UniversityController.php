<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Support\Facades\Http;

class UniversityController extends Controller
{
    function index()
    {
        $o = 0;
        $a = [];
        for ($i = 0; $i < 10; $i++) {
            $u = University::select('name as text','uuid')->offset($o)->limit(1000)->get()->map->only('text','uuid');

            $res = Http::withHeaders([
                    'authority' => 'api.cognitive.microsofttranslator.com',
                    'sec-ch-ua' => ' " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"',
                    'accept' => ' application/json, text/javascript, /; q=0.01',
                    'content-type' => ' application/json',
                    'sec-ch-ua-mobile' => ' ?0',
                    'user-agent' => ' Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',
                    'ocp-apim-subscription-key' => ' 5b912f68fd6a48839a3a68cf362f364d',
                    'sec-ch-ua-platform' => ' "Linux"',
                    'sec-gpc' => ' 1',
                    'origin' => 'https://hotpot.ai/',
                    'sec-fetch-site' => 'cross-site',
                    'sec-fetch-mode' => 'cors',
                    'sec-fetch-dest' => 'empty',
                    'referer' => "https://hotpot.ai/",
                    'accept-language' => 'en-US,en;q=0.9,hy;q=0.8,ru;q=0.7'
                ]

            )->post(
                'https://api.cognitive.microsofttranslator.com/translate?api-version=3.0&to=ru',
                $u
            );
//            return

            $o += 1000;
            $a = array_merge($a,$res->json());
        }

        $univer = University::all();

        foreach ($univer as $k=>$w){
            University::whereUuid($w->uuid)->update([
              'name' => $a[$k]['translations'][0]['text']
            ]);
        }

    }
}
