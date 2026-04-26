<?php
class Project extends Model
{
    public function getAllWithClient(array $filters = [], int $limit = 0, int $offset = 0): array
    {
        $params = [];
        $where = ['p.is_active = 1'];

        if (!empty($filters['type'])) {
            $where[] = 'p.project_type = ?';
            $params[] = $filters['type'];
        }
        if (!empty($filters['status'])) {
            $where[] = 'p.status = ?';
            $params[] = $filters['status'];
        }
        if (!empty($filters['search'])) {
            $where[] = '(p.title LIKE ? OR p.location LIKE ?)';
            $params[] = '%' . $filters['search'] . '%';
            $params[] = '%' . $filters['search'] . '%';
        }

        $whereSQL = implode(' AND ', $where);
        $limitSQL = $limit > 0 ? "LIMIT {$limit} OFFSET {$offset}" : '';

        $sql = "SELECT p.*, c.name AS client_name 
                FROM projects p 
                LEFT JOIN clients c ON p.client_id = c.id 
                WHERE {$whereSQL} 
                ORDER BY p.created_at DESC 
                {$limitSQL}";
        return $this->rawFetchAll($sql, $params);
    }

    public function getFeatured(int $limit = 3): array
    {
        $sql = "SELECT p.*, c.name AS client_name 
                FROM projects p 
                LEFT JOIN clients c ON p.client_id = c.id 
                WHERE p.is_featured = 1 AND p.is_active = 1 
                ORDER BY p.created_at DESC 
                LIMIT ?";
        return $this->rawFetchAll($sql, [$limit]);
    }

    public function getBySlug(string $slug): ?array
    {
        $sql = "SELECT p.*, c.name AS client_name 
                FROM projects p 
                LEFT JOIN clients c ON p.client_id = c.id 
                WHERE p.slug = ? AND p.is_active = 1 
                LIMIT 1";
        return $this->rawFetchOne($sql, [$slug]);
    }

    public function getAdminList(array $filters = [], int $limit = 15, int $offset = 0): array
    {
        $params = [];
        $where = ['1=1'];

        if (!empty($filters['type'])) {
            $where[] = 'p.project_type = ?';
            $params[] = $filters['type'];
        }
        if (!empty($filters['status'])) {
            $where[] = 'p.status = ?';
            $params[] = $filters['status'];
        }
        if (!empty($filters['search'])) {
            $where[] = '(p.title LIKE ? OR p.location LIKE ?)';
            $params[] = '%' . $filters['search'] . '%';
            $params[] = '%' . $filters['search'] . '%';
        }

        $whereSQL = implode(' AND ', $where);
        $sql = "SELECT p.*, c.name AS client_name 
                FROM projects p 
                LEFT JOIN clients c ON p.client_id = c.id 
                WHERE {$whereSQL} 
                ORDER BY p.created_at DESC 
                LIMIT {$limit} OFFSET {$offset}";
        return $this->rawFetchAll($sql, $params);
    }

    public function countFiltered(array $filters = []): int
    {
        $params = [];
        $where  = ['1=1'];

        if (!empty($filters['type'])) {
            $where[] = 'project_type = ?';
            $params[] = $filters['type'];
        }
        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }
        if (!empty($filters['search'])) {
            $where[] = '(title LIKE ? OR location LIKE ?)';
            $params[] = '%' . $filters['search'] . '%';
            $params[] = '%' . $filters['search'] . '%';
        }

        $sql = "SELECT COUNT(*) FROM projects WHERE " . implode(' AND ', $where);
        return $this->rawCount($sql, $params);
    }

    public function getImages(int $projectId): array
    {
        return $this->rawFetchAll(
            "SELECT * FROM project_images WHERE project_id = ? ORDER BY sort_order ASC",
            [$projectId]
        );
    }

    public function addImage(int $projectId, string $imagePath, string $caption = ''): int|false
    {
        return $this->insert('project_images', [
            'project_id' => $projectId,
            'image_path' => $imagePath,
            'caption'    => $caption,
            'sort_order' => 0,
        ]);
    }

    public function deleteImage(int $imageId): ?string
    {
        $img = $this->findById('project_images', $imageId);
        if ($img) {
            $this->delete('project_images', ['id' => $imageId]);
            return $img['image_path'];
        }
        return null;
    }

    public function getRelated(int $projectId, string $type, int $limit = 3): array
    {
        $sql = "SELECT p.*, c.name AS client_name 
                FROM projects p 
                LEFT JOIN clients c ON p.client_id = c.id 
                WHERE p.is_active = 1 AND p.project_type = ? AND p.id != ? 
                LIMIT ?";
        return $this->rawFetchAll($sql, [$type, $projectId, $limit]);
    }

    public function getExpenseSummary(int $projectId): array
    {
        $sql = "SELECT 
                    SUM(amount) AS total_expenses,
                    COUNT(*) AS total_count 
                FROM project_expenses 
                WHERE project_id = ?";
        return $this->rawFetchOne($sql, [$projectId]) ?? ['total_expenses' => 0, 'total_count' => 0];
    }

    public function getStatsByType(): array
    {
        $sql = "SELECT project_type, COUNT(*) AS cnt FROM projects WHERE is_active = 1 GROUP BY project_type";
        return $this->rawFetchAll($sql);
    }
}
