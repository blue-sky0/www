<?php

namespace core;

/**
 * 模型基类
 *
 * 封装 Dao（PDO 封装），提供：
 * - query() / exec(): 直接 SQL 执行
 * - prepare() / execute(): 预处理语句（防 SQL 注入）
 * - getTable(): 带前缀表名构造
 * - 通用 CRUD: addTableData / updateTableData / deleteTableData / getAll / getById
 */
class Model
{
    /** @var Dao 数据访问对象实例 */
    protected $dao;

    /** @var array|null 当前表的字段列表 ['字段名', ..., 'Key' => '主键名'] */
    protected $fields;

    public function __construct()
    {
        // 加载配置文件
        global $config;

        // 实例化DAO
        $this->dao = new Dao($config['database'], $config['drivers']);

        // 初始化字段信息
        // $this->getFields();
    }

    /**
     * 执行写操作（INSERT / UPDATE / DELETE）
     *
     * @param string $sql SQL 语句
     * @return int|false 影响行数
     */
    protected function exec(string $sql)
    {
        return $this->dao->dao_exec($sql);
    }

    /**
     * 获取最后插入的 ID
     *
     * @return int|false
     */
    public function getLastId()
    {
        return $this->dao->dao_insert_id();
    }

    /**
     * 执行读操作（SELECT）
     *
     * @param string $sql SQL 语句
     * @param bool   $all 是否返回全部记录
     * @return array|false
     */
    protected function query(string $sql, $all = false)
    {
        return $this->dao->dao_query($sql, $all);
    }

    /**
     * 安全的预处理查询（防 SQL 注入）
     *
     * @param string $sql    SQL 语句（含 ? 占位符）
     * @param array  $params 参数列表
     * @param bool   $all    是否返回全部记录
     * @return array|false
     */
    protected function prepare(string $sql, array $params = [], $all = false)
    {
        return $this->dao->prepare($sql, $params, $all);
    }

    /**
     * 安全的预处理执行（用于增删改）
     *
     * @param string $sql    SQL 语句（含 ? 占位符）
     * @param array  $params 参数列表
     * @return bool
     */
    protected function execute(string $sql, array $params = [])
    {
        return $this->dao->execute($sql, $params);
    }

    /**
     * 构造完整表名（带前缀）
     *
     * @param string $table 表名（不含前缀），为空时使用 $this->table
     * @return string 完整表名（如 S_user）
     */
    protected function getTable(string $table = '')
    {
        global $config;

        $table = empty($table) ? $this->table : $table;

        return $config['database']['prefix'] . $table;
    }

    // 创建数据表
    protected function createTables()
    {

    }

    /**
     * 获取当前数据库所有表
     *
     * @return array
     */
    protected function getAllTablesName()
    {
        $sql = "SHOW TABLES";
        return $this->query($sql, true);
    }

    /**
     * 获取当前表的字段属性
     *
     * @return array
     */
    protected function getTableAttribute()
    {
        $sql = "SHOW COLUMNS FROM {$this->getTable()}";
        return $this->query($sql, true);
    }

    /**
     * 获取当前表全部数据
     *
     * @return array
     */
    protected function getAll()
    {
        $sql = "SELECT * FROM {$this->getTable()}";
        return $this->query($sql, true);
    }

    /**
     * 按字段筛选记录（预处理）
     *
     * @param string $field 字段名
     * @param mixed  $value 字段值
     * @return array
     */
    protected function getChoice($field, $value)
    {
        $sql = "SELECT * FROM {$this->getTable()} WHERE {$field} = ?";
        return $this->prepare($sql, [$value], true);
    }

    /**
     * 分页查询（预处理）
     *
     * @param int $offset  偏移量
     * @param int $perPage 每页条数
     * @return array
     */
    protected function getPageViewData($offset, $perPage){
        $sql = "SELECT * FROM {$this->getTable()} LIMIT ?, ?";
        return $this->prepare($sql, [(int)$offset, (int)$perPage], true);
    }

    /**
     * 获取表字段信息（仅调用一次后缓存）
     */
    private function getFields()
    {
        $sql = "DESC {$this->getTable()}";
        $rows = $this->query($sql, true);

        foreach ($rows as $row) {
            $this->fields[] = $row['Field'];
            if ($row['Key'] == 'PRI') {
                $this->fields['Key'] = $row['Field'];
            }
        }
    }

    /**
     * 通过主键获取记录
     *
     * @param int|string $id 主键值
     * @return array|false
     */
    public function getById($id)
    {
        if (!$this->fields) {
            $this->getFields();
        }

        if (!isset($this->fields['Key'])) {
            return false;
        }

        $sql = "SELECT * FROM {$this->getTable()} WHERE {$this->fields['Key']} = ?";
        return $this->prepare($sql, [$id]);
    }

    /**
     * 重命名当前表
     *
     * @param string $newName 新表名（不含前缀）
     */
    protected function renameTableName($newName)
    {
        $sql = "RENAME TABLE {$this->getTable()} TO {$newName}";
        $this->exec($sql);
    }

    /**
     * 新增字段
     *
     * @param string $column 字段定义（如 `email` VARCHAR(100)）
     */
    protected function addTableField($column)
    {
        $sql = "ALTER TABLE {$this->getTable()} ADD {$column}";
        $this->exec($sql);
    }

    /**
     * 修改字段名/类型
     *
     * @param string $column CHANGE 子句（如 `old_name` `new_name` VARCHAR(100)）
     */
    protected function chageTableFieldName($column)
    {
        $sql = "ALTER TABLE {$this->getTable()} CHANGE {$column}";
        $this->exec($sql);
    }

    /**
     * 新增数据（预处理安全版本）
     *
     * @param array $data 键值对数据
     * @return bool
     */
    protected function addTableData(array $data)
    {
        $fields = '`' . implode('`, `', array_keys($data)) . '`';
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$this->getTable()} ({$fields}) VALUES ({$placeholders})";
        return $this->execute($sql, array_values($data));
    }

    /**
     * 更新数据（推荐使用预处理版本）
     *
     * @param string $data      SET 子句（如 `name` = ?, `age` = ?）
     * @param string $condition WHERE 子句（如 `id` = ?）
     * @param array  $params    参数列表（使用预处理时提供）
     * @return bool
     */
    protected function updateTableData($data, $condition, $params = [])
    {
        if (!empty($params)) {
            $sql = "UPDATE {$this->getTable()} SET {$data} WHERE {$condition}";
            return $this->execute($sql, $params);
        } else {
            $sql = "UPDATE {$this->getTable()} SET {$data} WHERE {$condition}";
            return $this->exec($sql);
        }
    }

    /**
     * 删除数据（推荐使用预处理版本）
     *
     * @param string $condition WHERE 子句
     * @param array  $params    参数列表（使用预处理时提供）
     * @return bool
     */
    protected function deleteTableData($condition, $params = []){
        if (!empty($params)) {
            $sql = "DELETE FROM {$this->getTable()} WHERE {$condition}";
            return $this->execute($sql, $params);
        } else {
            $sql = "DELETE FROM {$this->getTable()} WHERE {$condition}";
            return $this->exec($sql);
        }
    }
}
