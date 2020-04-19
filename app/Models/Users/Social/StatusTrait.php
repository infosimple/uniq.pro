<?php


namespace App\Models\Users\Social;


trait StatusTrait
{
    public function activate()
    {
        return $this->editStatus(IStatuses::ACTIVATE);
    }

    public function disabled()
    {
        return $this->editStatus(IStatuses::DISABLED);
    }

    public function moderation()
    {
        return $this->editStatus(IStatuses::MODERATION);
    }

    private function editStatus(int $status)
    {
        $this->status = $status;
        $this->save();
        return $this;
    }

}
