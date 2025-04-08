<?php

namespace Goletter\Admin\Resource;

use Goletter\Admin\Exception\BusinessException;
use Goletter\Admin\Resource\Collection;
use Goletter\Admin\Resource\Resource;
use Hyperf\DbConnection\Model\Model;

use function Hyperf\Support\class_basename;

trait ApiResponse
{
    public function success(
        $data = null,
        ?string $resource = null,
        $codeStatus = 200,
        $message = '',
    ): Resource {
        return match (true) {
            $resource !== null => new $resource($data, $codeStatus, $message),
            $data instanceof Model => call_user_func(function () use ($data, $codeStatus, $message) {
                $classBasename = class_basename($data);
                if (
                    class_exists($class = 'Goletter\Admin\Resource\\' . $classBasename)
                    || class_exists($class = 'Goletter\Admin\Resource\\' . $classBasename . 'Resource')
                ) {
                    return new $class($data, $codeStatus, $message);
                }
                return new Resource($data, $codeStatus, $message);
            }),
            default => new Resource($data, $codeStatus, $message),
        };
    }

    public function collection(
        $data,
        ?string $resource = null,
        $codeStatus = 200,
        $message = '',
    ): Collection {
        if (is_array($data)) {
            $data = new \Hyperf\Collection\Collection($data);
        }

        if ($resource !== null) {
            return forward_static_call([$resource, 'collection'], $data, $codeStatus, $message);
        }

        $item = $data->first();

        if ($item instanceof Model) {
            $classBasename = class_basename($item);
            if (
                class_exists($class = 'Goletter\Admin\Resource\\' . $classBasename)
                || class_exists($class = 'Goletter\Admin\Resource\\' . $classBasename . 'Resource')
            ) {
                return forward_static_call([$class, 'collection'], $data, $codeStatus, $message);
            }
        }

        return new Collection($data, Resource::class, $codeStatus, $message);
    }

    /**
     * @param mixed $codeStatus
     * @throws BusinessException
     */
    public function fail($codeStatus, string $message = '')
    {
        return $this->throwBusinessException($codeStatus, $message);
    }

    /**
     * 业务异常返回.
     * @param mixed $codeStatus
     * @throws BusinessException
     */
    protected function throwBusinessException($codeStatus, string $message = '')
    {
        throw new BusinessException($codeStatus, $message);
    }
}
