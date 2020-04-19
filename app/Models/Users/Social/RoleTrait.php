<?php


namespace App\Models\Users\Social;


trait RoleTrait
{
    public function setClicker()
    {
        return $this->editRole(IRoles::CLICKER);
    }

    public function setModerator()
    {
        return $this->editRole(IRoles::MODERATOR);
    }

    public function setAdmin()
    {
        return $this->editRole(IRoles::ADMIN);
    }

    private function editRole(int $role)
    {
        $this->role = $role;
        $this->save();
        return $this;
    }
}
