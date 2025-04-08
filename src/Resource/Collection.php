<?php
namespace Goletter\Admin\Resource;

use Hyperf\Resource\Json\AnonymousResourceCollection;

class Collection extends AnonymousResourceCollection
{
    public function __construct(
        $resource,
        string $collects,
        $codeStatus = 200,
        public string $message = ''
    ) {
        parent::__construct($resource, $collects);
    }

    public function with(): array
    {
        return [
            'success' => true,
            'status' => 'success',
            'code' => 200,
            'message' => $this->message ?: '',
        ];
    }
}
