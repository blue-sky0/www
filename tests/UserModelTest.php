<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use models\UserModel;

class UserModelTest extends TestCase
{
    private $userModel;

    protected function setUp(): void
    {
        $this->userModel = new UserModel();
    }

    public function testRegisterAndAuthenticate()
    {
        $username = 'testuser_' . time();
        $password = 'testpass123';

        $result = $this->userModel->register($username, $password);
        $this->assertTrue($result !== false);

        $user = $this->userModel->authenticate($username, $password);
        $this->assertIsArray($user);
        $this->assertEquals($username, $user['username']);

        // 错误密码应返回 false
        $failed = $this->userModel->authenticate($username, 'wrongpassword');
        $this->assertFalse($failed);

        // 清理
        $this->userModel->execute(
            "DELETE FROM {$this->userModel->getTable()} WHERE username = ?",
            [$username]
        );
    }

    public function testExists()
    {
        $this->assertFalse($this->userModel->exists('nonexistent_user_' . time()));
    }
}
