<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'summary',
        'problem_text',
        'solution_text',
        'tech_stack',
        'cover_image_path',
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
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }

            if (is_string($project->tech_stack)) {
                $project->tech_stack = array_filter(array_map('trim', explode(',', $project->tech_stack)));
            }
        });

        static::saving(function (Project $project) {
            if (is_string($project->tech_stack)) {
                $project->tech_stack = array_filter(array_map('trim', explode(',', $project->tech_stack)));
            }

            if (is_array($project->tech_stack)) {
                $project->tech_stack = array_values(array_filter($project->tech_stack));
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->published();
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('display_order');
    }

    public function getPrimaryImageAttribute(): ?string
    {
        if ($this->cover_image_path) {
            return $this->cover_image_path;
        }

        $firstImage = $this->images->first();

        return $firstImage?->file_path;
    }

    public function getCategoryLabelAttribute(): string
    {
        $map = [
            'web' => 'Web Application',
            'mobile' => 'Mobile Application',
            'design' => 'Product Design',
        ];

        return $map[$this->category] ?? Str::headline($this->category ?? 'Project');
    }
}
