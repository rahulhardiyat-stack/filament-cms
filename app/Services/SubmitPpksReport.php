<?php

namespace App\Services;

use App\Models\PpksReport;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubmitPpksReport
{
    public function handle(array $data, array $evidence, Student|\App\Models\PublicReporter $reporter): PpksReport
    {
        unset($data['consent'], $data['evidence']);
        $data['reference'] = (string) Str::uuid();
        $data['consented_at'] = now();
        $data['status'] = 'submitted';
        $data['reporter_type'] = $reporter instanceof Student ? 'student' : 'public';

        if ($reporter instanceof \App\Models\PublicReporter) {
            $data['reporter_name'] = $reporter->name;
        }

        $paths = [];
        try {
            foreach ($evidence as $image) {
                $path = $image->store('ppks-evidence/'.$data['reference'], 'local');
                if (! $path) {
                    throw new \RuntimeException('Gagal menyimpan bukti laporan.');
                }
                $paths[] = $path;
            }
            $data['evidence_paths'] = $paths;
            $report = $reporter->reports()->create($data);
        } catch (\Throwable $exception) {
            Storage::disk('local')->delete($paths);
            throw $exception;
        }

        return $report;
    }
}
