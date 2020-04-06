<?php


namespace App\Models\Users\Social;


trait ParamsTrait
{
    public function createParams(array $params): void
    {
        $this->params = json_encode($params);
        $this->save();
    }

    public function clearParams(): void
    {
        $this->params = null;
        $this->save();
    }

    public function addParams(array $newParams): void
    {
        $oldParams = json_decode($this->params, true);
        $params = array_merge($newParams, $oldParams);
        $this->createParams($params);
    }
}
