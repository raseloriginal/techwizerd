<?php
class Client extends Model
{
    public function getActive(): array
    {
        return $this->findAll('clients', ['is_active' => 1], 'sort_order ASC, name ASC');
    }

    public function getAll(): array
    {
        return $this->findAll('clients', [], 'sort_order ASC, name ASC');
    }

    public function getDropdown(): array
    {
        return $this->rawFetchAll("SELECT id, name FROM clients WHERE is_active = 1 ORDER BY name ASC");
    }
}
