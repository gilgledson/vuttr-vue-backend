<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ToolTag;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tool extends Model
{
    protected $fillable = ['name', 'link', 'description'];
    protected $appends = ['tags'];
    public  function getTagsAttribute()
    {
       return ToolTag::where('tool_id', $this->id)->pluck('tag');
    }
}
