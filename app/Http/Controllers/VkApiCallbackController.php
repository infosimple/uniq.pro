<?php

namespace App\Http\Controllers;

use App\Core\Bot\Vk\MessageNewHandler;
use App\Models\Bot\Bot;
use Illuminate\Http\Request;

class VkApiCallbackController extends Controller
{
    public function execute(Request $request)
    {
        $bot = Bot::where('soc', 'vk')->with(['button', 'keyboard', 'message', 'messagegroup'])->first();

        //Если секрет не совпадает финиш
        if(!$bot OR $bot->config['secret_key']
            != $request->secret OR $bot->config['group_id']
            != $request->group_id){
            return false;
        }
        //Верификация сервера
        if ($request->type === 'confirmation') {
            return $bot->config['access_key'];
        }
        //Отправка 'ok' на любой запрос от VKphp
        $this->sendOK();
        //Обрабатываем поступившее сообщение
        if ($request->type === 'message_new') {
            $newMessage = new MessageNewHandler;
            $newMessage->handle($request, $bot);
        }
    }

    private function sendOK()
    {
        echo 'ok';
        $response_length = ob_get_length();
        if (is_callable('fastcgi_finish_request')) {
            session_write_close();
            fastcgi_finish_request();

            return;
        }
        ignore_user_abort(true);
        ob_start();
        header('HTTP/1.1 200 OK');
        header('Content-Encoding: none');
        header('Content-Length: ' . $response_length);
        header('Connection: close');
        ob_end_flush();
        ob_flush();
        flush();
    }
}
