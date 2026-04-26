<?php
class Setting extends Model
{
    private array $cache = [];

    public function get(string $key, string $default = ''): string
    {
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }
        $row = $this->findOne('settings', ['setting_key' => $key]);
        $value = $row ? $row['setting_value'] : $default;
        $this->cache[$key] = $value;
        return $value;
    }

    public function set(string $key, string $value): bool
    {
        $existing = $this->findOne('settings', ['setting_key' => $key]);
        if ($existing) {
            return $this->update('settings', ['setting_value' => $value], ['setting_key' => $key]);
        } else {
            return (bool)$this->insert('settings', ['setting_key' => $key, 'setting_value' => $value]);
        }
    }

    public function getAll(): array
    {
        $rows = $this->findAll('settings');
        $result = [];
        foreach ($rows as $row) {
            $result[$row['setting_key']] = $row['setting_value'];
        }
        return $result;
    }

    public function updateMany(array $data): bool
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
        return true;
    }
}
