<?php
class Contact extends Model
{
    public function getAll(bool $unreadOnly = false): array
    {
        if ($unreadOnly) {
            return $this->findAll('contact_messages', ['is_read' => 0], 'created_at DESC');
        }
        return $this->findAll('contact_messages', [], 'created_at DESC');
    }

    public function countUnread(): int
    {
        return $this->count('contact_messages', ['is_read' => 0]);
    }

    public function markRead(int $id): bool
    {
        return $this->update('contact_messages', ['is_read' => 1], ['id' => $id]);
    }

    public function getRecent(int $limit = 5): array
    {
        return $this->findAll('contact_messages', ['is_read' => 0], 'created_at DESC', $limit);
    }
}
