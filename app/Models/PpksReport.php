<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpksReport extends Model
{
    public const STATUSES = [
        'submitted' => 'Diterima',
        'reviewing' => 'Sedang ditinjau',
        'handling' => 'Dalam penanganan',
        'completed' => 'Selesai',
    ];

    public const TYPES = ['student' => 'Mahasiswa', 'public' => 'Masyarakat umum'];

    protected $hidden = ['access_token_hash'];

    public const ROLES = ['victim' => 'Korban', 'witness' => 'Saksi'];

    protected $fillable = [
        'reference', 'reporter_role', 'incident_date', 'location', 'reported_person',
        'chronology', 'contact', 'support_needed', 'consented_at', 'status', 'response',
        'evidence_paths', 'reporter_type', 'reporter_name', 'access_token_hash',
    ];

    protected $casts = [
        'reporter_name' => 'encrypted',
        'incident_date' => 'date',
        'consented_at' => 'datetime',
        'location' => 'encrypted',
        'reported_person' => 'encrypted',
        'chronology' => 'encrypted',
        'contact' => 'encrypted',
        'support_needed' => 'encrypted',
        'response' => 'encrypted',
        'evidence_paths' => 'encrypted:array',
    ];

    public function publicReporter(): BelongsTo
    {
        return $this->belongsTo(PublicReporter::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
