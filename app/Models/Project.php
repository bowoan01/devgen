<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    public const CATEGORIES = ['web', 'mobile', 'design'];

    protected $fillable = [
        'title',
        'slug',
        'category',
        'summary',
        'problem_text',
        'solution_text',
        'tech_stack',
        'testimonial_author',
        'testimonial_text',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }

            if (is_string($project->tech_stack)) {
                $project->tech_stack = array_filter(array_map('trim', explode(',', $project->tech_stack)));
            }
        });
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('display_order');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->published();
    }

    public function techStackList(): Collection
    {
        return collect($this->tech_stack ?? []);
    }
}
