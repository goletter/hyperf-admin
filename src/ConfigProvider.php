<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Goletter\Admin;

use Hyperf\HttpServer\Router\Router;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                // 绑定依赖
            ],
            'commands' => [
                // 控制台命令
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__, // 扫描 Controller 用注解方式注册
                    ],
                ],
            ],
            'routes' => function () {
                Router::addServer('http', function () {
                    require_once __DIR__ . '/../routes/routes.php';
                });
            },
        ];
    }
}
