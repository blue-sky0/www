<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use core\Model;

class ModelTest extends TestCase
{
    public function testGetTablePrefix()
    {
        $model = $this->getMockForAbstractClass(Model::class);
        $reflection = new \ReflectionMethod($model, 'getTable');
        $reflection->setAccessible(true);

        // 测试默认表名
        $model->table = 'nav';
        $result = $reflection->invoke($model);
        $this->assertStringStartsWith('S_', $result);
    }
}
