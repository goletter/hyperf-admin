<?php

namespace Goletter\Admin\Controller;

use Goletter\Admin\Exception\ValidateException;
use Hyperf\Context\ApplicationContext;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected RequestInterface $request;

    #[Inject]
    protected ResponseInterface $response;

    /**
     * 自定义控制器验证器.
     * @param mixed ...$arg
     */
    protected function validate(...$arg)
    {
        $validator = ApplicationContext::getContainer()->get(ValidatorFactoryInterface::class)->make(...$arg);
        if ($validator->fails()) {
            throw new ValidateException($validator->errors()->first(), 422);
        }
    }
}
