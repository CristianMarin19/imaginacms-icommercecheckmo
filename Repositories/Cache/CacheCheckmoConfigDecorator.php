<?php

namespace Modules\Icommercecheckmo\Repositories\Cache;

use Modules\Icommercecheckmo\Repositories\CheckmoConfigRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCheckmoconfigDecorator extends BaseCacheDecorator implements CheckmoConfigRepository
{
    public function __construct(CheckmoConfigRepository $checkmoconfig)
    {
        parent::__construct();
        $this->entityName = 'icommercecheckmo.checkmoconfigs';
        $this->repository = $checkmoconfig;
    }
}
