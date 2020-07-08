<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineBotController extends Controller
{

    public function getMessage(Request $request)
    {
        //實體化linebot物件
        $httpClient = new CurlHTTPClient(env('LINEBOT_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSecret' => env('LINEBOT_SECRET')]);

        //取得使用者id和訊息內容
        $text = $request->events[0]['message']['text'];
        $user_id = $request->events[0]['source']['userId'];

        //透過dialogFlow判斷訊息意圖
//        $dialog = $this->dialog($text);
//        $noLimit = !strpos($dialog->content(), 'Vague response');

        //將以上拿到的資訊寫進log裡，debug用
        Log::info($request->input());
        Log::info('message is : ' . $text);
        $reply = new TextMessageBuilder($text);
        $bot->replyMessage($request->events[0]['replyToken'], $reply);
//        $bot->replyMessage($request->events[0]['replyToken'], $text);
//        Log::info('reply is : ' . $text);
//        Log::debug($dialog->content());
        return "OK";

    }
}
