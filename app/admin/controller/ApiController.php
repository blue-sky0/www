<?php
namespace admin\controller;

abstract class ApiController {
    protected $request;
    protected $response;
    
    public function __construct() {
        $this->setupHeaders();
        $this->parseRequest();
    }
    
    // 设置响应头
    protected function setupHeaders() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN'] ?? '*');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, X-CSRF-Token');
        header('Access-Control-Allow-Credentials: true');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit;
        }
    }
    
    // 解析请求数据
    protected function parseRequest() {
        $this->request = [
            'method' => $_SERVER['REQUEST_METHOD'],
            'path' => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            'query' => $_GET,
            'body' => $this->getRequestBody()
        ];
    }
    
    // 获取请求体
    protected function getRequestBody() {
        $input = file_get_contents('php://input');
        
        if (strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
            return json_decode($input, true) ?? [];
        }
        
        return $_POST;
    }
    
    // 成功响应
    protected function success($data = null, $message = 'success', $code = 200) {
        http_response_code($code);
        
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'timestamp' => time()
        ];
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // 错误响应
    protected function error($message = 'error', $code = 400, $errors = []) {
        http_response_code($code);
        
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => time()
        ];
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // 验证 CSRF Token
    protected function validateCsrfToken() {
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? 
                ($this->request['body']['csrf_token'] ?? '');
        
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        
        if (empty($sessionToken) || !hash_equals($sessionToken, $token)) {
            $this->error('CSRF token validation failed', 403);
        }
    }
    
    // 验证请求参数
    protected function validate(array $rules) {
        $errors = [];
        $data = array_merge($this->request['query'], $this->request['body']);
        
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? null;
            
            if (strpos($rule, 'required') !== false && empty($value)) {
                $errors[$field] = "{$field} is required";
                continue;
            }
            
            if (!empty($value)) {
                if (strpos($rule, 'email') !== false && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "{$field} must be a valid email";
                }
                
                if (strpos($rule, 'numeric') !== false && !is_numeric($value)) {
                    $errors[$field] = "{$field} must be numeric";
                }
                
                if (strpos($rule, 'min:') !== false) {
                    preg_match('/min:(\d+)/', $rule, $matches);
                    if (strlen($value) < $matches[1]) {
                        $errors[$field] = "{$field} must be at least {$matches[1]} characters";
                    }
                }
            }
        }
        
        if (!empty($errors)) {
            $this->error('Validation failed', 422, $errors);
        }
        
        return $data;
    }
}