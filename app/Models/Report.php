<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ReportFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Report extends Model
{
    public const PERIOD_ANNUAL = 'annual';

    public const PERIOD_QUARTERLY = 'quarterly';

    public const PERIOD_MONTHLY = 'monthly';

    public const TYPE_PDF = 'pdf';

    public const TYPE_WORD = 'word';

    public const TYPE_EXCEL = 'excel';

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const FILE_DISK = 'local';

    /** @use HasFactory<ReportFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'period_type',
        'report_year',
        'project_id',
        'period_number',
        'file_path',
        'original_filename',
        'mime_type',
        'file_type',
        'file_size',
        'status',
        'published_at',
    ];

    protected static function booted(): void
    {
        static::saving(function (Report $report): void {
            if ($report->isDirty('file_path')) {
                if (filled($report->file_path) && Storage::disk(self::FILE_DISK)->exists($report->file_path)) {
                    $report->file_size = Storage::disk(self::FILE_DISK)->size($report->file_path);
                    $report->mime_type = Storage::disk(self::FILE_DISK)->mimeType($report->file_path);
                    $report->file_type = self::typeForFilename($report->original_filename ?: $report->file_path);
                } elseif (blank($report->file_path)) {
                    $report->original_filename = null;
                    $report->mime_type = null;
                    $report->file_type = null;
                    $report->file_size = 0;
                }
            }

            if ($report->status === self::STATUS_PUBLISHED) {
                $report->published_at ??= now();
            } else {
                $report->published_at = null;
            }
        });

        static::updated(function (Report $report): void {
            if (! $report->wasChanged('file_path')) {
                return;
            }

            $previousFilePath = $report->getOriginal('file_path');

            if (filled($previousFilePath) && $previousFilePath !== $report->file_path) {
                Storage::disk(self::FILE_DISK)->delete($previousFilePath);
            }
        });

        static::deleting(function (Report $report): void {
            if (filled($report->file_path)) {
                Storage::disk(self::FILE_DISK)->delete($report->file_path);
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->whereNotNull('file_path')
            ->where('file_path', '!=', '');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getFormatLabelAttribute(): string
    {
        if (blank($this->file_path)) {
            return 'Aucun fichier';
        }

        return match ($this->file_type) {
            self::TYPE_PDF => 'PDF',
            self::TYPE_WORD => 'Word',
            self::TYPE_EXCEL => 'Excel',
            default => 'Document',
        };
    }

    public function getPeriodLabelAttribute(): string
    {
        return match ($this->period_type) {
            self::PERIOD_ANNUAL => "Rapport annuel {$this->report_year}",
            self::PERIOD_QUARTERLY => 'T'.$this->period_number." · {$this->report_year}",
            self::PERIOD_MONTHLY => Carbon::createFromDate((int) $this->report_year, (int) $this->period_number, 1)
                ->locale('fr')
                ->translatedFormat('F Y'),
            default => (string) $this->report_year,
        };
    }

    public function getFormattedFileSizeAttribute(): string
    {
        if (blank($this->file_path)) {
            return '—';
        }

        $bytes = (int) $this->file_size;

        if ($bytes >= 1_000_000_000) {
            return number_format($bytes / 1_000_000_000, 1, ',', ' ').' Go';
        }

        if ($bytes >= 1_000_000) {
            return number_format($bytes / 1_000_000, 1, ',', ' ').' Mo';
        }

        if ($bytes >= 1_000) {
            return number_format($bytes / 1_000, 0, ',', ' ').' Ko';
        }

        return $bytes.' o';
    }

    public static function typeForFilename(string $filename): string
    {
        return match (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
            'pdf' => self::TYPE_PDF,
            'doc', 'docx' => self::TYPE_WORD,
            'xls', 'xlsx' => self::TYPE_EXCEL,
            default => 'other',
        };
    }

    protected function casts(): array
    {
        return [
            'report_year' => 'integer',
            'period_number' => 'integer',
            'file_size' => 'integer',
            'published_at' => 'datetime',
        ];
    }
}
