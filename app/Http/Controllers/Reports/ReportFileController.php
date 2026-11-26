<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportFileController extends Controller
{
    public function preview(Report $report): BinaryFileResponse
    {
        abort_unless($report->status === Report::STATUS_PUBLISHED && $report->published_at !== null, 404);
        abort_unless($report->file_type === Report::TYPE_PDF, 404);
        abort_unless(Storage::disk(Report::FILE_DISK)->exists($report->file_path), 404);

        $response = response()->file(
            Storage::disk(Report::FILE_DISK)->path($report->file_path),
            [
                'Content-Type' => 'application/pdf',
                'X-Content-Type-Options' => 'nosniff',
                'Cache-Control' => 'private, no-store',
            ],
        );

        $response->setContentDisposition(HeaderUtils::DISPOSITION_INLINE, $report->original_filename);

        return $response;
    }

    public function download(Report $report): StreamedResponse
    {
        $user = auth()->user();

        abort_unless($user?->is_active && $user->hasVerifiedEmail() && $user->isAdmin(), 403);
        abort_unless($report->status === Report::STATUS_PUBLISHED && $report->published_at !== null, 404);
        abort_unless(Storage::disk(Report::FILE_DISK)->exists($report->file_path), 404);

        return Storage::disk(Report::FILE_DISK)->download(
            $report->file_path,
            $report->original_filename,
            ['X-Content-Type-Options' => 'nosniff'],
        );
    }
}
