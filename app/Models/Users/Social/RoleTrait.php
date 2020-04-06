<?php


namespace App\Models\Users\Social;


trait RoleTrait
{
    public function setClicker()
    {
        return $this->editRole(IRoles::ROLE_CLICKER);
    }

    public function setModerator()
    {
        return $this->editRole(IRoles::ROLE_MODERATOR);
    }

    public function setAdmin()
    {
        return $this->editRole(IRoles::ROLE_ADMIN);
    }

    public function setClient()
    {
        return $this->editRole(IRoles::ROLE_CLIENT);
    }

    private function editRole(int $role)
    {
        $this->role = $role;
        $this->save();
        return $this;
    }
}
