<?php

namespace Modules\Icommercecheckmo\Entities;

class Checkmoconfig
{
    private $description;
    private $image;
    private $status;
    public function __construct()
    {
        $this->description = setting('Icommercecheckmo::description');
        $this->image = setting('Icommercecheckmo::image');
        $this->status = setting('Icommercecheckmo::status');
    }

    public function getData()
    {
        return (object) [
            'description' => $this->description,
            'image' => url($this->image),
            'status' => $this->status
        ];
    }
}
