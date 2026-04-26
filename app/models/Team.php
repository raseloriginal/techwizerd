<?php
class Team extends Model
{
    public function getActive(): array
    {
        return $this->findAll('team_members', ['is_active' => 1], 'sort_order ASC, name ASC');
    }

    public function getAll(): array
    {
        return $this->findAll('team_members', [], 'sort_order ASC, name ASC');
    }

    public function getGroupedByDepartment(): array
    {
        $members = $this->findAll('team_members', ['is_active' => 1], 'sort_order ASC');
        $grouped = [];
        foreach ($members as $member) {
            $dept = $member['department'] ?: 'General';
            $grouped[$dept][] = $member;
        }
        return $grouped;
    }

    public function getLeaders(int $limit = 4): array
    {
        return $this->findAll('team_members', ['is_active' => 1], 'sort_order ASC', $limit);
    }
}
