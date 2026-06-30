<?php

namespace admin\model;

use core\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';

    public function getGroup($group)
    {
        $sql = "SELECT `key_name`, `value` FROM {$this->getTable()} WHERE group_name = ?";
        $rows = $this->prepare($sql, [$group], true);
        $result = [];
        foreach ($rows as $row) {
            $result[$row['key_name']] = $row['value'];
        }
        return $result;
    }

    public function set($group, $key, $value)
    {
        $sql = "SELECT COUNT(*) as cnt FROM {$this->getTable()} WHERE group_name = ? AND key_name = ?";
        $exists = $this->prepare($sql, [$group, $key]);
        if ($exists && $exists['cnt'] > 0) {
            $sql = "UPDATE {$this->getTable()} SET `value` = ?, updated_at = NOW() WHERE group_name = ? AND key_name = ?";
            return $this->execute($sql, [$value, $group, $key]);
        } else {
            $sql = "INSERT INTO {$this->getTable()} (group_name, key_name, `value`) VALUES (?, ?, ?)";
            return $this->execute($sql, [$group, $key, $value]);
        }
    }

    public function getAllGrouped()
    {
        $sql = "SELECT group_name, key_name, `value` FROM {$this->getTable()} ORDER BY group_name, key_name";
        $rows = $this->prepare($sql, [], true);
        $result = [];
        foreach ($rows as $row) {
            $result[$row['group_name']][$row['key_name']] = $row['value'];
        }
        return $result;
    }
}
