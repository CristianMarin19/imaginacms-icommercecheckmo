<?php

namespace Modules\Icommercecheckmo\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class IcommerceCheckmo extends Model
{
    use Translatable;

    protected $table = 'icommercecheckmo__icommercecheckmos';
    public $translatedAttributes = [];
    protected $fillable = [];
}
