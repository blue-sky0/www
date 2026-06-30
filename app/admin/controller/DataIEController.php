<?php

namespace admin\controller;

use core\Security;

class DataIEController extends BaseController
{
    private $excludeTables = [
        'S_operation_logs',
        'S_online_users',
        'S_access_logs',
        'S_login_history',
        'S_page_stats',
        'S_daily_stats',
    ];

    private $readonlyTables = [
        'S_daily_stats',
        'S_page_stats',
    ];

    public function index()
    {
        $this->assignCommon();
        $this->setActiveSidebar('DataIE');

        $allFunction = new \admin\model\AllFunctionModel();
        $tables = $allFunction->getLibTablesName();

        $exclude = [];
        foreach ($this->excludeTables as $t) {
            $exclude[] = str_replace('S_', '', $t);
        }
        foreach ($this->readonlyTables as $t) {
            $exclude[] = str_replace('S_', '', $t);
        }
        $tables = array_diff($tables, $exclude);
        $tables = array_values($tables);

        $this->assign('tables', $tables);
        $this->assign('excludeTablesJson', json_encode($this->excludeTables));
        $this->assign('readonlyTablesJson', json_encode($this->readonlyTables));
        $this->assign("tableData", "");

        $model = new \admin\model\DataIEModel();
        $subjects = $model->getSubjectList();
        $this->assign('subjects', $subjects);

        $this->assign('success_msg', $_SESSION['success_msg'] ?? '');
        $this->assign('error_msg', $_SESSION['error_msg'] ?? '');
        unset($_SESSION['success_msg'], $_SESSION['error_msg']);

        $this->display('dataie.php');
    }

    public function schema()
    {
        $tableName = $_GET['table'] ?? '';
        if (empty($tableName)) {
            echo json_encode(['error' => '请选择表']);
            exit;
        }

        if ($this->isExcluded($tableName)) {
            echo json_encode(['error' => '该表不允许操作']);
            exit;
        }

        $model = new \admin\model\DataIEModel();
        $columns = $model->getTableColumns($tableName);

        if (empty($columns)) {
            echo json_encode(['error' => '获取表结构失败']);
            exit;
        }

        $primaryKey = '';
        $columnList = [];
        foreach ($columns as $col) {
            $columnList[] = [
                'field'   => $col['Field'],
                'type'    => $col['Type'],
                'null'    => $col['Null'],
                'key'     => $col['Key'],
                'default' => $col['Default'],
                'extra'   => $col['Extra'],
            ];
            if ($col['Key'] === 'PRI') {
                $primaryKey = $col['Field'];
            }
        }

        echo json_encode([
            'columns'    => $columnList,
            'primaryKey' => $primaryKey,
            'rowCount'   => $model->getRowCount($tableName),
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function preview()
    {
        $tableName = $_GET['table'] ?? '';
        $page = max(1, intval($_GET['page'] ?? 1));
        $pageSize = min(100, max(10, intval($_GET['pageSize'] ?? 20)));

        if (empty($tableName)) {
            echo json_encode(['error' => '请选择表']);
            exit;
        }

        $model = new \admin\model\DataIEModel();
        $result = $model->getPageData($tableName, $page, $pageSize);

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function export()
    {
        $this->checkCsrf();

        $tableName = $_GET['table'] ?? '';
        $format = $_GET['format'] ?? 'csv';
        $where = $_GET['where'] ?? '';

        if (empty($tableName)) {
            $_SESSION['error_msg'] = '请选择要导出的表';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        if ($this->isExcluded($tableName)) {
            $_SESSION['error_msg'] = '该表不允许导出';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        if (!in_array($format, ['csv', 'excel', 'sql'])) {
            $_SESSION['error_msg'] = '不支持的导出格式';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        $model = new \admin\model\DataIEModel();
        $columns = $model->getTableColumns($tableName);
        $data = $model->getAllData($tableName, $where);

        Security::generateCsrfToken();
        $this->logOperation('data_ie', 'export', "导出 {$tableName} 为 {$format}，共 " . count($data) . " 条");

        switch ($format) {
            case 'csv':
                $this->exportCsv($tableName, $columns, $data);
                break;
            case 'excel':
                $this->exportExcel($tableName, $columns, $data);
                break;
            case 'sql':
                $this->exportSql($tableName, $columns, $data);
                break;
        }
        exit;
    }

    public function import()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }
        $this->checkCsrf();

        $tableName = $_POST['table'] ?? '';
        $importType = $_POST['importType'] ?? 'insert';

        if (empty($tableName)) {
            $_SESSION['error_msg'] = '请选择目标表';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        if ($this->isExcluded($tableName) || $this->isReadonly($tableName)) {
            $_SESSION['error_msg'] = '该表不允许导入数据';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        if (!in_array($importType, ['insert', 'replace', 'update'])) {
            $importType = 'insert';
        }

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error_msg'] = '文件上传失败';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        $file = $_FILES['file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ['csv', 'xlsx', 'xls', 'sql'])) {
            $_SESSION['error_msg'] = '不支持的文件格式，仅支持 CSV、Excel(xlsx/xls)、SQL 文件';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        $model = new \admin\model\DataIEModel();

        try {
            switch ($ext) {
                case 'csv':
                    $result = $this->importCsv($model, $tableName, $file['tmp_name'], $importType);
                    break;
                case 'xlsx':
                case 'xls':
                    $result = $this->importExcel($model, $tableName, $file['tmp_name'], $ext, $importType);
                    break;
                case 'sql':
                    $result = $this->importSql($model, $tableName, $file['tmp_name'], $importType);
                    break;
                default:
                    $_SESSION['error_msg'] = '不支持的文件格式';
                    header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
                    exit;
            }

            if ($result['success']) {
                $_SESSION['success_msg'] = $result['message'];
                $this->logOperation('data_ie', 'import', "导入 {$tableName}，" . $result['imported'] . " 条，" . ($result['skipped'] ?? 0) . " 条跳过");
            } else {
                $_SESSION['error_msg'] = $result['message'];
            }
        } catch (\Exception $e) {
            $_SESSION['error_msg'] = '导入失败：' . $e->getMessage();
        }

        Security::generateCsrfToken();
        header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
        exit;
    }

    public function template()
    {
        $tableName = $_GET['table'] ?? '';
        if (empty($tableName)) {
            $_SESSION['error_msg'] = '请先选择表';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        $model = new \admin\model\DataIEModel();
        $columns = $model->getTableColumns($tableName);

        $headers = [];
        foreach ($columns as $col) {
            if ($col['Extra'] === 'auto_increment') continue;
            $headers[] = $col['Field'];
        }

        $this->downloadCsvHeaders($tableName . '_template.csv');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, $headers);
        fclose($out);
        exit;
    }

    public function clearTable()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_msg'] = '非法请求方法';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }
        $this->checkCsrf();

        $tableName = $_POST['table'] ?? '';
        $confirm = $_POST['confirm_text'] ?? '';

        if (empty($tableName)) {
            $_SESSION['error_msg'] = '请选择表';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        if ($this->isExcluded($tableName) || $this->isReadonly($tableName)) {
            $_SESSION['error_msg'] = '该表不允许清空';
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        if ($confirm !== 'CONFIRM_CLEAR_' . strtoupper($tableName)) {
            $_SESSION['error_msg'] = '确认文本不正确，请输入 CONFIRM_CLEAR_' . strtoupper($tableName);
            header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
            exit;
        }

        $model = new \admin\model\DataIEModel();
        $model->truncateTable($tableName);

        Security::generateCsrfToken();
        $_SESSION['success_msg'] = "表 {$tableName} 已清空";
        $this->logOperation('data_ie', 'clear', "清空表 {$tableName}");

        header('Location: ' . URL . 'index.php?p=admin&c=DataIE');
        exit;
    }

    public function fetch()
    {
        $this->assignCommon();
        $this->setActiveSidebar('DataIE');

        $allFunction = new \admin\model\AllFunctionModel();
        $tables = $allFunction->getLibTablesName();
        $this->assign('tables', $tables);

        $model = new \admin\model\DataIEModel();
        $subjects = $model->getSubjectList();
        $this->assign('subjects', $subjects);

        $this->assign('success_msg', $_SESSION['success_msg'] ?? '');
        $this->assign('error_msg', $_SESSION['error_msg'] ?? '');
        unset($_SESSION['success_msg'], $_SESSION['error_msg']);

        $this->display('dataie.php');
    }

    private $allowedFetchDomains = [
        'example.com', 'example.org',
        'tutorialspoint.com', 'w3schools.com',
        'mozilla.org', 'php.net', 'github.com',
        'developer.mozilla.org',
    ];

    public function analyzeUrl()
    {
        header('Content-Type: application/json; charset=utf-8');
        $url = trim($_GET['url'] ?? '');

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            echo json_encode(['error' => '请输入有效的网址']);
            exit;
        }

        $host = parse_url($url, PHP_URL_HOST);
        $allowed = false;
        foreach ($this->allowedFetchDomains as $domain) {
            if ($host === $domain || str_ends_with($host, '.' . $domain)) {
                $allowed = true;
                break;
            }
        }
        if (!$allowed) {
            echo json_encode(['error' => "域名 {$host} 不在允许列表中，无法抓取"]);
            exit;
        }

        try {
            $result = $this->fetchUrlContent($url);
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            echo json_encode(['error' => '抓取失败：' . $e->getMessage()]);
        }
        exit;
    }

    public function doFetch()
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => '非法请求']);
            exit;
        }
        $this->checkCsrf();

        $url = trim($_POST['url'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $page = trim($_POST['page'] ?? '');
        $content = $_POST['content'] ?? '';
        $downloadImages = isset($_POST['download_images']) ? 1 : 0;

        if (empty($url) || empty($subject) || empty($page)) {
            echo json_encode(['error' => '请填写完整信息']);
            exit;
        }

        $page = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $page);
        $page = strtolower($page);

        $finalContent = $content;
        $downloadedImages = [];
        if ($downloadImages && !empty($content)) {
            $result = $this->downloadImagesFromHtml($content, $url);
            $finalContent = $result['html'];
            $downloadedImages = $result['images'];
        }

        $data = [
            'subject'    => $subject,
            'page'       => $page,
            'content'    => $finalContent,
            'create_date' => date('Y-m-d H:i:s'),
            'alter_date' => date('Y-m-d H:i:s'),
        ];

        $model = new \admin\model\DataIEModel();
        $existing = $model->checkPageExists($subject, $page);
        if ($existing) {
            $result = $model->updateContent($subject, $page, $data);
        } else {
            $result = $model->insertContent($data);
        }

        Security::generateCsrfToken();

        if ($result) {
            $this->logOperation('data_ie', 'fetch_import', "从 {$url} 抓取导入 {$subject}/{$page}，下载图片 " . count($downloadedImages) . " 张");
            echo json_encode([
                'success' => true,
                'message' => '导入成功',
                'images'  => $downloadedImages,
                'page_id' => $result,
            ]);
        } else {
            echo json_encode(['error' => '写入数据库失败']);
        }
        exit;
    }

    private function exportCsv($tableName, $columns, $data)
    {
        $this->downloadCsvHeaders($tableName . '_' . date('Ymd_His') . '.csv');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

        $headers = array_column($columns, 'Field');
        fputcsv($out, $headers);

        foreach ($data as $row) {
            $line = [];
            foreach ($headers as $h) {
                $line[] = $row[$h] ?? '';
            }
            fputcsv($out, $line);
        }
        fclose($out);
    }

    private function exportExcel($tableName, $columns, $data)
    {
        if (!class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            $this->exportCsv($tableName, $columns, $data);
            return;
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle(substr($tableName, 0, 31));

        $headers = array_column($columns, 'Field');
        $colLetter = 'A';
        foreach ($headers as $header) {
            $cell = $sheet->getStyle($colLetter . '1');
            $sheet->setCellValue($colLetter . '1', $header);
            $cell->getFont()->setBold(true);
            $cell->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                  ->getStartColor()->setRGB('F0F0F0');
            $colLetter++;
        }

        $rowNum = 2;
        foreach ($data as $row) {
            $colLetter = 'A';
            foreach ($headers as $h) {
                $value = $row[$h] ?? '';
                if (is_numeric($value) && strlen($value) < 15) {
                    $sheet->setCellValue($colLetter . $rowNum, $value + 0);
                } else {
                    $sheet->setCellValueExplicit($colLetter . $rowNum, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                }
                $colLetter++;
            }
            $rowNum++;
        }

        foreach (range('A', $colLetter) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $tableName . '_' . date('Ymd_His') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    private function exportSql($tableName, $columns, $data)
    {
        $fullTable = 'S_' . $tableName;

        header('Content-Type: text/plain; charset=utf-8');
        header('Content-Disposition: attachment;filename="' . $tableName . '_' . date('Ymd_His') . '.sql"');

        echo "-- 导出表：{$fullTable}\n";
        echo "-- 导出时间：" . date('Y-m-d H:i:s') . "\n";
        echo "-- 记录数：" . count($data) . "\n\n";

        echo "TRUNCATE TABLE `{$fullTable}`;\n\n";

        $fields = array_column($columns, 'Field');
        $fieldList = '`' . implode('`, `', $fields) . '`';

        foreach ($data as $row) {
            $values = [];
            foreach ($fields as $f) {
                $val = $row[$f] ?? null;
                if ($val === null) {
                    $values[] = 'NULL';
                } else {
                    $values[] = "'" . addslashes($val) . "'";
                }
            }
            $valueStr = implode(', ', $values);
            echo "INSERT INTO `{$fullTable}` ({$fieldList}) VALUES ({$valueStr});\n";
        }

        echo "\n-- 导出完成，共 " . count($data) . " 条记录\n";
    }

    private function importCsv($model, $tableName, $tmpPath, $importType)
    {
        $handle = fopen($tmpPath, 'r');
        if (!$handle) {
            return ['success' => false, 'message' => '无法读取文件'];
        }

        $bom = fread($handle, 3);
        if ($bom !== chr(0xEF) . chr(0xBB) . chr(0xBF)) {
            rewind($handle);
        }

        $headers = fgetcsv($handle);
        if (!$headers || empty($headers)) {
            fclose($handle);
            return ['success' => false, 'message' => 'CSV 文件格式错误：缺少表头'];
        }

        $headers[0] = preg_replace('/^[\x00-\x1F\xFE-\xFF]/', '', $headers[0]);

        $dbColumns = $model->getTableColumns($tableName);
        $dbFields = array_column($dbColumns, 'Field');
        $autoIncrement = '';
        foreach ($dbColumns as $col) {
            if ($col['Extra'] === 'auto_increment') {
                $autoIncrement = $col['Field'];
                break;
            }
        }

        $invalidHeaders = array_diff($headers, $dbFields);
        if (!empty($invalidHeaders)) {
            fclose($handle);
            return ['success' => false, 'message' => '无效的字段名：' . implode(', ', $invalidHeaders)];
        }

        $imported = 0;
        $skipped = 0;
        $errors = [];
        $lineNum = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $lineNum++;
            if (count($row) !== count($headers)) {
                $skipped++;
                continue;
            }

            $data = array_combine($headers, $row);
            if ($autoIncrement && (empty($data[$autoIncrement]) || $data[$autoIncrement] === 'NULL')) {
                unset($data[$autoIncrement]);
            }

            try {
                $result = $model->insertRow($tableName, $data, $importType);
                if ($result) {
                    $imported++;
                } else {
                    $skipped++;
                }
            } catch (\Exception $e) {
                $skipped++;
                if (count($errors) < 10) {
                    $errors[] = "第{$lineNum}行: " . $e->getMessage();
                }
            }
        }

        fclose($handle);

        $message = "导入完成：{$imported} 条成功";
        if ($skipped > 0) $message .= "，{$skipped} 条跳过";
        if (!empty($errors)) $message .= "，错误：" . implode('; ', $errors);

        return ['success' => true, 'message' => $message, 'imported' => $imported, 'skipped' => $skipped];
    }

    private function importExcel($model, $tableName, $tmpPath, $ext, $importType)
    {
        if (!class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
            return ['success' => false, 'message' => '请先安装 PhpSpreadsheet 库：composer require phpoffice/phpspreadsheet'];
        }

        try {
            $reader = $ext === 'xlsx'
                ? new \PhpOffice\PhpSpreadsheet\Reader\Xlsx()
                : new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            $spreadsheet = $reader->load($tmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Excel 解析失败：' . $e->getMessage()];
        }

        if (empty($rows) || count($rows) < 2) {
            return ['success' => false, 'message' => 'Excel 文件为空或只有表头'];
        }

        $headers = $rows[0];
        $headers = array_map('trim', $headers);

        $dbColumns = $model->getTableColumns($tableName);
        $dbFields = array_column($dbColumns, 'Field');
        $autoIncrement = '';
        foreach ($dbColumns as $col) {
            if ($col['Extra'] === 'auto_increment') {
                $autoIncrement = $col['Field'];
                break;
            }
        }

        $invalidHeaders = array_diff($headers, $dbFields);
        if (!empty($invalidHeaders)) {
            return ['success' => false, 'message' => '无效的字段名：' . implode(', ', $invalidHeaders)];
        }

        $imported = 0;
        $skipped = 0;
        $errors = [];

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (count($row) !== count($headers)) {
                $skipped++;
                continue;
            }

            $data = [];
            foreach ($headers as $idx => $header) {
                $value = $row[$idx] ?? '';
                if ($value instanceof \PhpOffice\PhpSpreadsheet\Shared\Date) {
                    $value = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeString($value);
                } elseif (is_object($value) && method_exists($value, '__toString')) {
                    $value = (string)$value;
                }
                if ($value === '' || $value === null) {
                    $data[$header] = null;
                } else {
                    $data[$header] = $value;
                }
            }

            if ($autoIncrement && (empty($data[$autoIncrement]) || $data[$autoIncrement] === 'NULL')) {
                unset($data[$autoIncrement]);
            }

            try {
                $result = $model->insertRow($tableName, $data, $importType);
                if ($result) {
                    $imported++;
                } else {
                    $skipped++;
                }
            } catch (\Exception $e) {
                $skipped++;
                if (count($errors) < 10) {
                    $errors[] = "第" . ($i + 1) . "行: " . $e->getMessage();
                }
            }
        }

        $message = "导入完成：{$imported} 条成功";
        if ($skipped > 0) $message .= "，{$skipped} 条跳过";
        if (!empty($errors)) $message .= "，错误：" . implode('; ', $errors);

        return ['success' => true, 'message' => $message, 'imported' => $imported, 'skipped' => $skipped];
    }

    private function importSql($model, $tableName, $tmpPath, $importType)
    {
        $content = file_get_contents($tmpPath);
        if (empty($content)) {
            return ['success' => false, 'message' => 'SQL 文件为空'];
        }

        $fullTable = 'S_' . $tableName;
        $pattern = '/INSERT\s+INTO\s+`?' . preg_quote($fullTable, '/') . '`?\s*(\([^)]*\))?\s*VALUES\s*(\([^;]+\));/si';
        preg_match_all($pattern, $content, $matches);

        if (empty($matches[0])) {
            return ['success' => false, 'message' => "未找到 {$fullTable} 表的 INSERT 语句"];
        }

        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($matches[0] as $insertSql) {
            try {
                $model->executeRawInsert($tableName, $insertSql);
                $imported++;
            } catch (\Exception $e) {
                $skipped++;
                if (count($errors) < 10) {
                    $errors[] = $e->getMessage();
                }
            }
        }

        $message = "导入完成：{$imported} 条成功";
        if ($skipped > 0) $message .= "，{$skipped} 条跳过";
        if (!empty($errors)) $message .= "，错误：" . implode('; ', $errors);

        return ['success' => true, 'message' => $message, 'imported' => $imported, 'skipped' => $skipped];
    }

    private function fetchUrlContent($url)
    {
        $context = stream_context_create([
            'http' => [
                'timeout'  => 15,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'follow_location' => 1,
                'max_redirects' => 3,
                'ignore_errors' => true,
            ],
            'ssl' => [
                'verify_peer' => !APP_DEBUG,
                'verify_peer_name' => !APP_DEBUG,
            ],
        ]);

        $html = @file_get_contents($url, false, $context);
        if ($html === false) {
            throw new \Exception('无法连接目标网站或超时');
        }

        $html = $this->detectAndConvertEncoding($html);

        $title = '';
        if (preg_match('/<title[^>]*>([^<]+)<\/title>/si', $html, $m)) {
            $title = trim($m[1]);
            $title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        $description = '';
        if (preg_match('/<meta[^>]*name=["\']description["\'][^>]*content=["\']([^"\']+)["\']/si', $html, $m) ||
            preg_match('/<meta[^>]*content=["\']([^"\']+)["\'][^>]*name=["\']description["\']/si', $html, $m)) {
            $description = trim($m[1]);
        }

        $content = $this->extractMainContent($html);

        $images = [];
        if (preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/si', $content, $matches)) {
            foreach ($matches[1] as $src) {
                $absUrl = $this->makeAbsoluteUrl($src, $url);
                if ($absUrl) {
                    $images[] = ['src' => $absUrl, 'thumb' => $absUrl];
                }
            }
        }

        $content = preg_replace('/<script[^>]*>.*?<\/script>/si', '', $content);
        $content = preg_replace('/<style[^>]*>.*?<\/style>/si', '', $content);
        $content = preg_replace('/<!--.*?-->/s', '', $content);
        $content = preg_replace('/<nav[^>]*>.*?<\/nav>/si', '', $content);
        $content = preg_replace('/<footer[^>]*>.*?<\/footer>/si', '', $content);
        $content = preg_replace('/<header[^>]*>.*?<\/header>/si', '', $content);

        $content = $this->makeImagesAbsolute($content, $url);

        return [
            'title'       => $title,
            'description' => $description,
            'content'     => $content,
            'images'      => array_slice($images, 0, 20),
            'url'         => $url,
        ];
    }

    private function extractMainContent($html)
    {
        if (preg_match('/<meta[^>]*property=["\']og:article:body["\'][^>]*content=["\']([^"\']+)["\']/si', $html, $m) ||
            preg_match('/<meta[^>]*content=["\']([^"\']+)["\'][^>]*property=["\']og:article:body["\']/si', $html, $m)) {
            return html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        if (preg_match('/<article[^>]*>(.*?)<\/article>/si', $html, $m)) {
            return trim($m[1]);
        }
        if (preg_match('/<main[^>]*>(.*?)<\/main>/si', $html, $m)) {
            return trim($m[1]);
        }

        $selectors = [
            '/<div[^>]*(?:class|id)=["\'][^"\']*(?:content|article|post|entry|main-text)[^"\']*["\'][^>]*>(.*?)<\/div>/si',
            '/<div[^>]*id=["\'][^"\']*(?:content|article|post|entry)[^"\']*["\'][^>]*>(.*?)<\/div>/si',
        ];
        foreach ($selectors as $selector) {
            if (preg_match_all($selector, $html, $matches)) {
                $best = '';
                foreach ($matches[1] as $block) {
                    if (strlen(strip_tags($block)) > strlen(strip_tags($best))) {
                        $best = $block;
                    }
                }
                if (strlen(strip_tags($best)) > 200) {
                    return trim($best);
                }
            }
        }

        if (preg_match('/<body[^>]*>(.*?)<\/body>/si', $html, $m)) {
            $body = $m[1];
            $body = preg_replace('/<script[^>]*>.*?<\/script>/si', '', $body);
            $body = preg_replace('/<style[^>]*>.*?<\/style>/si', '', $body);
            $body = preg_replace('/<!--.*?-->/s', '', $body);
            $body = preg_replace('/<nav[^>]*>.*?<\/nav>/si', '', $body);
            $body = preg_replace('/<header[^>]*>.*?<\/header>/si', '', $body);
            $body = preg_replace('/<footer[^>]*>.*?<\/footer>/si', '', $body);
            $body = preg_replace('/<aside[^>]*>.*?<\/aside>/si', '', $body);
            return trim($body);
        }

        return $html;
    }

    private function detectAndConvertEncoding($html)
    {
        if (!function_exists('mb_convert_encoding') || !function_exists('mb_check_encoding')) {
            return $html;
        }
        if (preg_match('/<meta[^>]*charset=["\']?([^"\'\s>]+)/i', $html, $m)) {
            $charset = strtolower(trim($m[1]));
            if ($charset !== 'utf-8' && $charset !== 'utf8') {
                $html = @mb_convert_encoding($html, 'UTF-8', $charset);
            }
        } elseif (!@mb_check_encoding($html, 'UTF-8')) {
            foreach (['gb2312', 'gbk', 'big5', 'shift_jis', 'euc-kr'] as $enc) {
                $converted = @mb_convert_encoding($html, 'UTF-8', $enc);
                if ($converted && @mb_check_encoding($converted, 'UTF-8')) {
                    $html = $converted;
                    break;
                }
            }
        }
        return $html;
    }

    private function makeAbsoluteUrl($src, $baseUrl)
    {
        $src = trim($src);
        if (empty($src) || str_starts_with($src, 'data:') || str_starts_with($src, 'javascript:') || str_starts_with($src, '#')) {
            return null;
        }

        $src = html_entity_decode($src, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if (str_starts_with($src, '//')) {
            $scheme = parse_url($baseUrl, PHP_URL_SCHEME);
            return $scheme . ':' . $src;
        }
        if (str_starts_with($src, '/')) {
            $parsed = parse_url($baseUrl);
            return ($parsed['scheme'] ?? 'https') . '://' . ($parsed['host'] ?? '') . $src;
        }
        if (!str_starts_with($src, 'http')) {
            $parsed = parse_url($baseUrl);
            $baseDir = dirname($parsed['path'] ?? '/');
            return ($parsed['scheme'] ?? 'https') . '://' . ($parsed['host'] ?? '') . $baseDir . '/' . ltrim($src, '/');
        }
        return $src;
    }

    private function makeImagesAbsolute($html, $baseUrl)
    {
        return preg_replace_callback('/<img([^>]+)src=["\']([^"\']+)["\']([^>]*)>/i', function ($m) use ($baseUrl) {
            $src = $this->makeAbsoluteUrl($m[2], $baseUrl);
            if ($src) {
                return "<img{$m[1]}src=\"{$src}\"{$m[3]}>";
            }
            return '';
        }, $html);
    }

    private function downloadImagesFromHtml($html, $sourceUrl)
    {
        $uploadDir = ROOT_PATH . 'public/images/remote/';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        $downloadedImages = [];

        $html = preg_replace_callback('/<img([^>]+)src=["\']([^"\']+)["\']([^>]*)>/i', function ($m) use ($uploadDir, $sourceUrl, &$downloadedImages) {
            $src = $m[2];
            $absUrl = $this->makeAbsoluteUrl($src, $sourceUrl);
            if (!$absUrl) return $m[0];

            $ext = strtolower(pathinfo(parse_url($absUrl, PHP_URL_PATH), PATHINFO_EXTENSION)) ?: 'jpg';
            $ext = preg_replace('/[^a-z0-9]/', '', $ext);
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                $ext = 'jpg';
            }

            $filename = md5($absUrl) . '.' . $ext;
            $localPath = $uploadDir . $filename;
            $webPath = '/public/images/remote/' . $filename;

            $context = stream_context_create([
                'http' => ['timeout' => 10, 'user_agent' => 'Mozilla/5.0'],
            ]);

            $content = @file_get_contents($absUrl, false, $context);
            if ($content !== false && strlen($content) > 100 && strlen($content) < 10 * 1024 * 1024) {
                file_put_contents($localPath, $content);
                $downloadedImages[] = [
                    'original' => $absUrl,
                    'local'    => $webPath,
                    'file'     => $filename,
                ];
                return '<img' . $m[1] . 'src="' . $webPath . '"' . $m[3] . '>';
            }

            return '<img' . $m[1] . 'src="' . $absUrl . '"' . $m[3] . '>';
        }, $html);

        return ['html' => $html, 'images' => $downloadedImages];
    }

    private function downloadCsvHeaders($filename)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    }

    private function isExcluded($shortName)
    {
        $fullName = 'S_' . $shortName;
        return in_array($fullName, $this->excludeTables);
    }

    private function isReadonly($shortName)
    {
        $fullName = 'S_' . $shortName;
        return in_array($fullName, $this->readonlyTables);
    }
}
