<?php
class Service extends Model
{
    public function getActive(int $limit = 0): array
    {
        return $this->findAll('services', ['is_active' => 1], 'sort_order ASC', $limit);
    }

    public function getAll(): array
    {
        return $this->findAll('services', [], 'sort_order ASC');
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->findOne('services', ['slug' => $slug, 'is_active' => 1]);
    }
}
