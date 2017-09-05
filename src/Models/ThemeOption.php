<?php namespace Tukecx\Base\ThemesManagement\Models;

use Tukecx\Base\ThemesManagement\Models\Contracts\ThemeOptionModelContract;
use Tukecx\Base\Core\Models\EloquentBase as BaseModel;

class ThemeOption extends BaseModel implements ThemeOptionModelContract
{
    protected $table = 'theme_options';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public $timestamps = false;

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }
}
