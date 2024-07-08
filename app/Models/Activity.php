<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Activity extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'activities';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'description',
        'link',
        'icon',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const ICON_SELECT = [
        'Aluguer de viaturas' => 'fas fa-car-alt icon',
        'Trabalhar com viatura própria' => 'fas fa-user-tag icon',
        'Stand de viaturas' => 'fas fa-search-dollar icon',
        'Estafetas' => 'fas fa-parachute-box icon',
        'Formação' => 'fas fa-chalkboard-teacher icon',
        'Acessórios' => 'fas fa-shopping-cart icon',
        'Transfers e Tours' => 'fas fa-bus icon',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /*

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    */

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();
        if ($file) {
            $file->url = $file->getUrl();
        }

        return $file;
    }

}
