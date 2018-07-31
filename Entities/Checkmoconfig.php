<?php

namespace Modules\IcommerceCheckmo\Entities;

class Checkmoconfig
{
    private $description;
    private $image;
    private $status;
    public function __construct()
    {
        $this->description = setting('IcommerceCheckmo::description');
        $this->image = setting('IcommerceCheckmo::image');
        $this->status = setting('IcommerceCheckmo::status');
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
