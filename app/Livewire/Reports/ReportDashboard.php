<?php

namespace App\Livewire\Reports;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ReportDashboard extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(as: 'format', except: '')]
    public string $format = '';

    #[Url(as: 'year', except: '')]
    public string $year = '';

    #[Url(as: 'preview', except: '')]
    public string $previewId = '';

    #[Locked]
    public string $notificationsCheckedAt = '';

    /** @var list<string> */
    #[Locked]
    public array $notifiedReportIds = [];

    /** @var list<array{id: string, title: string, period: string}> */
    public array $reportNotifications = [];

    public function mount(): void
    {
        $this->year = filled($this->year) ? $this->year : (string) now()->year;
        $notificationsCheckedAt = Carbon::parse(now()->toDateTimeString());
        $this->notificationsCheckedAt = $notificationsCheckedAt->toDateTimeString();
        $this->notifiedReportIds = Report::published()
            ->where('published_at', '<', $notificationsCheckedAt)
            ->latest('published_at')
            ->limit(100)
            ->pluck('id')
            ->all();
    }

    public function updatedSearch(): void
    {
        $this->resetReportPages();
    }

    public function updatedFormat(): void
    {
        $this->resetReportPages();
    }

    public function updatedYear(): void
    {
        $this->resetReportPages();
        $this->closePreview();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->format = '';
        $this->year = (string) now()->year;
        $this->resetReportPages();
        $this->closePreview();
    }

    public function openPreview(string $reportId): void
    {
        $report = Report::published()->whereKey($reportId)->firstOrFail();

        abort_unless($report->file_type === Report::TYPE_PDF, 404);

        $this->previewId = $report->getKey();
        unset($this->selectedReport);
    }

    public function closePreview(): void
    {
        $this->previewId = '';
        unset($this->selectedReport);
    }

    public function checkForNewReports(): void
    {
        $checkedAt = Carbon::parse($this->notificationsCheckedAt)->subSeconds(2);

        $newReports = Report::published()
            ->where('published_at', '>=', $checkedAt)
            ->orderBy('published_at')
            ->get(['id', 'title', 'period_type', 'report_year', 'period_number', 'published_at']);

        foreach ($newReports as $report) {
            $reportId = (string) $report->getKey();

            if (in_array($reportId, $this->notifiedReportIds, true)) {
                continue;
            }

            $this->notifiedReportIds[] = $reportId;
            $this->reportNotifications[] = [
                'id' => $reportId,
                'title' => $report->title,
                'period' => $report->period_label,
            ];
        }

        $this->notificationsCheckedAt = now()->toDateTimeString();
        $this->notifiedReportIds = array_slice(array_values(array_unique($this->notifiedReportIds)), -100);
        $this->reportNotifications = array_slice($this->reportNotifications, -3);
    }

    public function dismissReportNotification(string $reportId): void
    {
        $this->reportNotifications = array_values(array_filter(
            $this->reportNotifications,
            fn (array $notification): bool => $notification['id'] !== $reportId,
        ));
    }

    #[Computed]
    public function selectedReport(): ?Report
    {
        if (! $this->previewId) {
            return null;
        }

        return Report::published()
            ->whereKey($this->previewId)
            ->where('file_type', Report::TYPE_PDF)
            ->first();
    }

    #[Computed]
    public function availableYears(): array
    {
        return Report::published()
            ->select('report_year')
            ->distinct()
            ->orderByDesc('report_year')
            ->pluck('report_year')
            ->push(now()->year)
            ->unique()
            ->sortDesc()
            ->map(fn (int $year): string => (string) $year)
            ->values()
            ->all();
    }

    #[Computed]
    public function statistics(): array
    {
        $query = Report::published()->where('report_year', (int) $this->year);
        $totals = (clone $query)->selectRaw('COUNT(*) as documents, COALESCE(SUM(file_size), 0) as bytes')->first();

        $formats = (clone $query)
            ->selectRaw('file_type, COUNT(*) as total')
            ->groupBy('file_type')
            ->pluck('total', 'file_type');

        $periods = (clone $query)
            ->selectRaw('period_type, COUNT(*) as total')
            ->groupBy('period_type')
            ->pluck('total', 'period_type');

        $monthly = collect(range(1, 12))->mapWithKeys(fn (int $month): array => [$month => [
            'label' => Carbon::createFromDate((int) $this->year, $month, 1)->locale('fr')->translatedFormat('M'),
            'pdf' => 0,
            'word' => 0,
            'excel' => 0,
            'total' => 0,
        ]]);

        (clone $query)->get(['file_type', 'published_at'])->each(function (Report $report) use ($monthly): void {
            $month = (int) $report->published_at?->format('n');
            $monthStatistics = $monthly->get($month);

            if ($month && is_array($monthStatistics) && array_key_exists($report->file_type, $monthStatistics)) {
                $monthStatistics[$report->file_type]++;
                $monthStatistics['total']++;
                $monthly->put($month, $monthStatistics);
            }
        });

        $documents = (int) ($totals->documents ?? 0);
        $isAdministrator = auth()->user()?->isAdmin() ?? false;
        $formats = collect([
            Report::TYPE_PDF => (int) ($formats[Report::TYPE_PDF] ?? 0),
            Report::TYPE_WORD => (int) ($formats[Report::TYPE_WORD] ?? 0),
            Report::TYPE_EXCEL => (int) ($formats[Report::TYPE_EXCEL] ?? 0),
        ]);

        return [
            'documents' => $documents,
            'bytes' => (int) ($totals->bytes ?? 0),
            'formats' => $formats->all(),
            'periods' => [
                Report::PERIOD_ANNUAL => (int) ($periods[Report::PERIOD_ANNUAL] ?? 0),
                Report::PERIOD_QUARTERLY => (int) ($periods[Report::PERIOD_QUARTERLY] ?? 0),
                Report::PERIOD_MONTHLY => (int) ($periods[Report::PERIOD_MONTHLY] ?? 0),
            ],
            'drafts' => $isAdministrator
                ? Report::query()
                    ->where('status', Report::STATUS_DRAFT)
                    ->where('report_year', (int) $this->year)
                    ->count()
                : null,
            'monthly' => $monthly->values()->all(),
        ];
    }

    protected function reportsQuery(string $periodType): Builder
    {
        return Report::published()
            ->where('report_year', (int) $this->year)
            ->where('period_type', $periodType)
            ->when($this->format !== '', fn (Builder $query): Builder => $query->where('file_type', $this->format))
            ->when(trim($this->search) !== '', function (Builder $query): Builder {
                $search = trim($this->search);

                return $query->where(function (Builder $query) use ($search): void {
                    $query->whereLike('title', '%'.$search.'%')
                        ->orWhereLike('description', '%'.$search.'%')
                        ->orWhereLike('original_filename', '%'.$search.'%');
                });
            });
    }

    public function render(): View
    {
        $periodReports = [];

        foreach ([
            Report::PERIOD_ANNUAL => 'annualPage',
            Report::PERIOD_QUARTERLY => 'quarterlyPage',
            Report::PERIOD_MONTHLY => 'monthlyPage',
        ] as $periodType => $pageName) {
            $periodReports[$periodType] = $this->reportsQuery($periodType)
                ->with('project')
                ->orderByDesc('published_at')
                ->paginate(5, ['*'], $pageName);
        }

        return view('livewire.reports.report-dashboard', [
            'periodReports' => $periodReports,
            'statistics' => $this->statistics,
            'availableYears' => $this->availableYears,
            'selectedReport' => $this->selectedReport,
            'canDownload' => auth()->user()?->isAdmin() ?? false,
        ]);
    }

    private function resetReportPages(): void
    {
        foreach (['annualPage', 'quarterlyPage', 'monthlyPage'] as $pageName) {
            $this->resetPage($pageName);
        }
    }
}
