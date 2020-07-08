<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineBotController extends Controller
{
    protected $bot;

    public function __construct()
    {
        //實體化linebot物件
        $httpClient = new CurlHTTPClient('4RBjfX2CZL/BXouPnK7glKev3cIlp7ygWudHWQj+o4O/uC6bJ2GJiD1dlQdIQQT1HlpGCOlJU6TLzkh96Zk/wn5ZWKsTh0Kt2p3/8eI4T422bA3YikkaplLQvZmo9TMv9Osv8s82gmclfyP3koZlxAdB04t89/1O/w1cDnyilFU=');
        $this->bot = new LINEBot($httpClient, ['channelSecret' => '835b6d9640121f6642547b7ec80992ad']);
    }

    public function getMessage(Request $request)
    {
        //取得使用者id和訊息內容
        $text = $request->events[0]['message']['text'];
        $user_id = $request->events[0]['source']['userId'];

        //透過dialogFlow判斷訊息意圖
//        $dialog = $this->dialog($text);
//        $noLimit = !strpos($dialog->content(), 'Vague response');

        //將以上拿到的資訊寫進log裡，debug用
        Log::info('message is : ' . $text);
        $reply = new TextMessageBuilder($text);
        $this->bot->replyMessage($request->events[0]['replyToken'], $reply);
//        $bot->replyMessage($request->events[0]['replyToken'], $text);
//        Log::info('reply is : ' . $text);
//        Log::debug($dialog->content());
        return "OK";

    }
}
