<?php

namespace Tests\Feature;

use App\Filament\Resources\PpksReportResource\Pages\EditPpksReport;
use App\Models\PpksReport;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

class PublicPpksTest extends \Tests\TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    public function createApplication(): \Illuminate\Foundation\Application
    {
        $app = parent::createApplication();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);

        return $app;
    }

    protected function student(array $attributes = []): \App\Models\Student
    {
        return \App\Models\Student::create(array_merge([
            'nim' => '20260001', 'name' => 'Mahasiswa Uji', 'program_studi' => 'Informatika',
            'birth_date_password' => '2003-05-17', 'is_active' => true,
        ], $attributes));
    }

    protected function payload(): array
    {
        return [
            'reporter_role' => 'witness', 'incident_date' => now()->subDay()->toDateString(),
            'location' => 'Lokasi rahasia', 'reported_person' => 'Keterangan terlapor',
            'chronology' => 'Kronologi kejadian yang dilaporkan oleh mahasiswa.',
            'contact' => 'mahasiswa@example.test', 'support_needed' => 'Pendampingan', 'consent' => '1',
        ];
    }

    protected function publicReporter(string $username = 'pelapor'): \App\Models\PublicReporter
    {
        return \App\Models\PublicReporter::create(['username' => $username, 'name' => 'Pelapor Umum', 'password' => 'PasswordAman123']);
    }

    public function test_registration_login_and_separate_guard(): void
    {
        $this->get('/lapor/umum')->assertRedirect('/lapor/umum/login');
        $this->post('/lapor/umum', $this->payload())->assertRedirect('/lapor/umum/login');
        $this->get('/lapor/umum/login')->assertOk()->assertSee('Username')->assertDontSee('Tanggal lahir');
        $this->get('/lapor/umum/registrasi')->assertOk()->assertSee('Konfirmasi password');
        $this->post('/lapor/umum/registrasi', ['name' => 'Nama Masyarakat', 'username' => ' Pelapor.Test ', 'password' => 'PasswordAman123', 'password_confirmation' => 'PasswordAman123'])->assertRedirect('/lapor/umum');
        $reporter = \App\Models\PublicReporter::sole();
        $this->assertSame('pelapor.test', $reporter->username);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('PasswordAman123', $reporter->password));
        $this->assertNotEquals('Nama Masyarakat', DB::table('public_reporters')->value('name'));
        $this->assertAuthenticatedAs($reporter, 'public_reporter');
        $this->assertGuest('web');
        $this->assertGuest('student');
        $this->post('/lapor/umum/logout')->assertRedirect('/lapor/umum/login');
        $this->assertGuest('public_reporter');
        $this->post('/lapor/umum/login', ['username' => 'PELAPOR.TEST', 'password' => 'PasswordAman123'])->assertRedirect('/lapor/umum');
        $this->get('/lapor/umum')->assertOk()->assertSee('Nama Masyarakat');
    }

    public function test_registration_rejects_duplicate_username_and_weak_password(): void
    {
        $this->publicReporter();
        $this->post('/lapor/umum/registrasi', ['name' => 'Nama', 'username' => 'PELAPOR', 'password' => 'short', 'password_confirmation' => 'wrong'])->assertSessionHasErrors(['username', 'password']);
        $this->assertDatabaseCount('public_reporters', 1);
        $this->assertNull(session('_old_input.password'));
    }

    public function test_login_throttle_and_inactive_accounts(): void
    {
        $reporter = $this->publicReporter();
        $reporter->forceFill(['is_active' => false])->save();
        $this->post('/lapor/umum/login', ['username' => 'pelapor', 'password' => 'PasswordAman123'])->assertSessionHasErrors('username');
        $reporter->forceFill(['is_active' => true])->save();
        for ($i = 0; $i < 4; $i++) {
            $this->post('/lapor/umum/login', ['username' => 'pelapor', 'password' => 'wrong'])->assertSessionHasErrors('username');
        }
        $this->post('/lapor/umum/login', ['username' => 'pelapor', 'password' => 'PasswordAman123'])->assertSessionHasErrors('username');
        $this->assertGuest('public_reporter');
    }

    public function test_public_reports_and_evidence_are_owned_by_account(): void
    {
        Storage::fake('local');
        $owner = $this->publicReporter();
        $other = $this->publicReporter('other');
        $this->actingAs($owner, 'public_reporter')->post('/lapor/umum', array_merge($this->payload(), [
            'public_reporter_id' => $other->id, 'reporter_name' => 'Forged', 'student_id' => 123, 'status' => 'completed',
            'evidence' => [UploadedFile::fake()->image('bukti.jpg')],
        ]))->assertRedirect('/lapor/umum');
        $report = PpksReport::sole();
        $this->assertEquals($owner->id, $report->public_reporter_id);
        $this->assertNull($report->student_id);
        $this->assertSame($owner->name, $report->reporter_name);
        $this->assertSame('public', $report->reporter_type);
        $this->assertSame('submitted', $report->status);
        $report->update(['response' => 'Tanggapan privat masyarakat']);
        $url = route('lapor.evidence', [$report->reference, 0]);
        $response = $this->get('/lapor/umum')->assertOk()->assertSee('Tanggapan privat masyarakat');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('private', $response->headers->get('Cache-Control'));
        $this->get($url)->assertOk();
        $this->actingAs($other, 'public_reporter')->get('/lapor/umum')->assertDontSee($report->reference)->assertDontSee('Tanggapan privat masyarakat');
        $this->get($url)->assertNotFound();
        \Illuminate\Support\Facades\Auth::guard('public_reporter')->logout();
        $this->withSession(['public_report_id' => $report->id])->get($url)->assertNotFound();
        $this->actingAs(User::factory()->create(), 'web');
        Livewire::test(EditPpksReport::class, ['record' => $report->id])->assertSee('Pelapor Umum')
            ->fillForm(['status' => 'handling', 'response' => 'Tindak lanjut umum'])->call('save')->assertHasNoFormErrors();
        $this->get($url)->assertOk();
        $owner->forceFill(['is_active' => false])->save();
        \Illuminate\Support\Facades\Auth::guard('web')->logout();
        $this->actingAs($owner, 'public_reporter')->get($url)->assertNotFound();
        $this->post('/lapor/umum', $this->payload())->assertRedirect('/lapor/umum/login');
    }

    public function test_public_submission_requires_consent_and_is_rate_limited(): void
    {
        $this->actingAs($this->publicReporter(), 'public_reporter');
        $this->post('/lapor/umum', array_merge($this->payload(), ['consent' => '0']))->assertSessionHasErrors('consent');
        for ($i = 0; $i < 4; $i++) {
            $this->post('/lapor/umum', [])->assertSessionHasErrors();
        }
        $this->post('/lapor/umum', [])->assertStatus(429);
        $this->assertDatabaseCount('ppks_reports', 0);
    }

    public function test_student_seeder_preserves_existing_students(): void
    {
        $student = $this->student(['nim' => '2026100001', 'name' => 'Nama asli', 'is_active' => false]);
        $originalPassword = $student->birth_date_password;
        $this->seed(\Database\Seeders\StudentSeeder::class);
        $this->seed(\Database\Seeders\StudentSeeder::class);
        $this->assertSame('Nama asli', $student->fresh()->name);
        $this->assertDatabaseCount('students', 5);
        $this->assertSame($originalPassword, $student->fresh()->birth_date_password);
        $this->assertFalse($student->fresh()->is_active);
        $seededStudent = \App\Models\Student::where('nim', '2026100002')->sole();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('2026-10-07', $seededStudent->birth_date_password));
        $this->post('/lapor/login', ['nim' => $seededStudent->nim, 'birth_date' => '2026-10-07'])
            ->assertRedirect('/lapor');
        $this->assertAuthenticatedAs($seededStudent, 'student');
    }
}
