<?php


namespace App\Models\Users\Social;


use App\Models\Bot\Bot;

trait ParamsTrait
{
    private function setParam($param, $value)
    {
        $paramsUser = collect($this->params);
        $paramsUser->put($param, $value);
        $this->params = $paramsUser;
        $this->save();
        return $this;
    }

    private function removeParam($param)
    {
        $paramsUser = collect($this->params);
        if($paramsUser->has($param)){
            $paramsUser->forget($param);
            $this->params = $paramsUser;
            $this->save();
        }
        return $this;
    }

    private function addEvent($value)
    {
        $message = Bot::getBotSocial('vk')->eventMessage()->where('name', $value)->first();
        if($message){
            if(isset($message->expected_response)){
                $this->addResponse($message->expected_response);
            }else{
                $this->removeResponse();
            }
        }else{
            return $this;
        }
        return $this->setParam('event', $value);
    }

    public function removeEvent()
    {
        return $this->removeParam('event');
    }

    public function addResponse($value)
    {
        return $this->setParam('response', $value);
    }

    public function removeResponse()
    {
        return $this->removeParam('response');
    }

    public function addKeyBoard(int $value)
    {
        return $this->setParam('keyboard', $value);
    }

    public function removeKeyBoard()
    {
        return $this->removeParam('keyboard');
    }

    public function addComment($value)
    {
        return $this->setParam('comment', $value);
    }

    public function removeComment()
    {
        return $this->removeParam('comment');
    }

    public function addOrder(int $value)
    {
        return $this->setParam('order', $value);
    }

    public function removeOrder()
    {
        return $this->removeParam('order');
    }

    public function addAnswer($name, $value)
    {
        $answer = [$name => $value];
        if(isset($this->params['answer'])){
            $answer = array_merge($this->params['answer'], [$name => $value]);
        }
        return $this->setParam('answer', $answer);
    }

    public function removeAnswer()
    {
        return $this->removeParam('answer');
    }
}
