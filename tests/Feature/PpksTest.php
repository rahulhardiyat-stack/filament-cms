<?php

namespace Tests\Feature;

use App\Filament\Resources\PpksReportResource\Pages\EditPpksReport;
use App\Filament\Resources\PpksReportResource\Pages\ListPpksReports;
use App\Filament\Resources\StudentResource\Pages\CreateStudent;
use App\Filament\Resources\StudentResource\Pages\EditStudent;
use App\Filament\Resources\StudentResource\Pages\ListStudents;
use App\Models\PpksReport;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PpksTest extends TestCase
{
    use RefreshDatabase;

    public function createApplication(): \Illuminate\Foundation\Application
    {
        $app = parent::createApplication();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        return $app;
    }

    protected function student(array $attributes = []): Student
    {
        return Student::create(array_merge([
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

    public function test_guests_must_login_and_login_page_renders(): void
    {
        $this->get('/lapor')->assertRedirect('/lapor/login');
        $this->post('/lapor', $this->payload())->assertRedirect('/lapor/login');
        $this->get('/lapor/login')->assertOk()->assertSee('NIM')->assertSee('Tanggal lahir');
        $this->assertDatabaseCount('ppks_reports', 0);
    }

    public function test_student_login_uses_hashed_birth_date_and_separate_guard(): void
    {
        $student = $this->student();
        $this->assertNotEquals('2003-05-17', $student->birth_date_password);
        $this->assertTrue(Hash::check('2003-05-17', $student->birth_date_password));
        $this->post('/lapor/login', ['nim' => $student->nim, 'birth_date' => '2003-05-17'])->assertRedirect('/lapor');
        $this->assertAuthenticatedAs($student, 'student');
        $this->assertGuest('web');
        $this->get('/lapor')->assertOk()->assertSee($student->name)->assertSee('Form pelaporan');
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_wrong_birth_date_and_inactive_accounts_are_rejected(): void
    {
        $student = $this->student();
        $this->post('/lapor/login', ['nim' => $student->nim, 'birth_date' => '2003-05-18'])->assertSessionHasErrors('nim');
        $this->assertGuest('student');
        $student->update(['is_active' => false]);
        $this->post('/lapor/login', ['nim' => $student->nim, 'birth_date' => '2003-05-17'])->assertSessionHasErrors('nim');
        $this->assertGuest('student');
    }

    public function test_login_attempts_are_limited(): void
    {
        $student = $this->student();
        for ($i = 0; $i < 5; $i++) {
            $this->post('/lapor/login', ['nim' => $student->nim, 'birth_date' => '2003-05-18'])->assertSessionHasErrors('nim');
        }
        $this->post('/lapor/login', ['nim' => $student->nim, 'birth_date' => '2003-05-17'])->assertSessionHasErrors('nim');
        $this->assertGuest('student');
    }

    public function test_report_is_owned_by_authenticated_student_and_sensitive_data_is_encrypted(): void
    {
        $student = $this->student();
        $other = $this->student(['nim' => '20260002']);
        $payload = $this->payload();
        $this->actingAs($student, 'student')->post('/lapor', array_merge($payload, [
            'student_id' => $other->id, 'status' => 'completed', 'response' => 'Forged',
        ]))->assertRedirect('/lapor')->assertSessionHas('success');
        $report = PpksReport::sole();
        $this->assertEquals($student->id, $report->student_id);
        $this->assertEquals('submitted', $report->status);
        $this->assertNull($report->response);
        $this->assertEquals($payload['chronology'], $report->chronology);
        $this->assertNotEquals($payload['chronology'], DB::table('ppks_reports')->value('chronology'));
        $report->update(['response' => 'Tanggapan privat petugas']);
        $this->get('/lapor')->assertOk()->assertSee($report->reference)->assertSee('Tanggapan privat petugas');
        $this->actingAs($other, 'student')->get('/lapor')->assertOk()->assertDontSee($report->reference)->assertDontSee('Tanggapan privat petugas');
    }

    public function test_report_requires_consent_and_valid_incident_date(): void
    {
        $this->actingAs($this->student(), 'student')->post('/lapor', array_merge($this->payload(), [
            'consent' => '0', 'incident_date' => now()->addDay()->toDateString(), 'chronology' => 'Singkat',
        ]))->assertSessionHasErrors(['consent', 'incident_date', 'chronology']);
        $this->assertDatabaseCount('ppks_reports', 0);
    }

    public function test_deactivated_student_session_cannot_submit(): void
    {
        $student = $this->student();
        $this->actingAs($student, 'student');
        $student->update(['is_active' => false]);
        $this->post('/lapor', $this->payload())->assertRedirect('/lapor/login');
        $this->assertGuest('student');
        $this->assertDatabaseCount('ppks_reports', 0);
    }

    public function test_logout_clears_student_authentication(): void
    {
        $this->actingAs($this->student(), 'student')->post('/lapor/logout')->assertRedirect('/lapor/login');
        $this->assertGuest('student');
        $this->get('/lapor')->assertRedirect('/lapor/login');
    }

    public function test_admin_can_create_and_edit_student_without_resetting_birth_date(): void
    {
        $this->actingAs(User::factory()->create(), 'web');
        Livewire::test(CreateStudent::class)->fillForm([
            'nim' => '20269999', 'name' => 'Mahasiswa Admin', 'program_studi' => 'Hukum',
            'birth_date_password' => '2003-05-17 00:00:00', 'is_active' => true,
        ])->call('create')->assertHasNoFormErrors();
        $student = Student::sole();
        Livewire::test(ListStudents::class)->assertCanSeeTableRecords([$student]);
        $this->assertTrue(Hash::check('2003-05-17', $student->birth_date_password));
        $hash = $student->birth_date_password;
        Livewire::test(EditStudent::class, ['record' => $student->id])
            ->assertFormSet(['birth_date_password' => null])
            ->fillForm(['name' => 'Nama diubah'])->call('save')->assertHasNoFormErrors();
        $this->assertEquals($hash, $student->fresh()->birth_date_password);
        Livewire::test(EditStudent::class, ['record' => $student->id])
            ->fillForm(['birth_date_password' => '2003-05-18 00:00:00'])->call('save')->assertHasNoFormErrors();
        $this->assertTrue(Hash::check('2003-05-18', $student->fresh()->birth_date_password));
    }

    public function test_admin_can_respond_without_changing_original_report(): void
    {
        $this->actingAs($this->student(), 'student')->post('/lapor', $this->payload());
        Auth::guard('student')->logout();
        $report = PpksReport::sole();
        $this->actingAs(User::factory()->create(), 'web');
        Livewire::test(ListPpksReports::class)->assertCanSeeTableRecords([$report]);
        Livewire::test(EditPpksReport::class, ['record' => $report->id])
            ->fillForm(['status' => 'handling', 'response' => 'Petugas akan menghubungi Anda.', 'chronology' => 'Diubah'])
            ->call('save')->assertHasNoFormErrors();
        $this->assertEquals('handling', $report->fresh()->status);
        $this->assertEquals('Petugas akan menghubungi Anda.', $report->fresh()->response);
        $this->assertEquals($this->payload()['chronology'], $report->fresh()->chronology);
    }

    public function test_three_evidence_images_are_private_and_only_owner_or_admin_can_view(): void
    {
        Storage::fake('local');
        Storage::fake('public');
        $owner = $this->student();
        $other = $this->student(['nim' => '20260002']);
        $this->actingAs($owner, 'student')->post('/lapor', array_merge($this->payload(), [
            'evidence' => [
                UploadedFile::fake()->image('bukti1.jpg'),
                UploadedFile::fake()->image('bukti2.png'),
                UploadedFile::fake()->image('bukti3.webp'),
            ],
        ]))->assertRedirect('/lapor')->assertSessionHasNoErrors();
        $report = PpksReport::sole();
        $this->assertCount(3, $report->evidence_paths);
        foreach ($report->evidence_paths as $path) {
            Storage::disk('local')->assertExists($path);
            Storage::disk('public')->assertMissing($path);
        }
        $this->assertStringNotContainsString('ppks-evidence', DB::table('ppks_reports')->value('evidence_paths'));
        $url = route('lapor.evidence', [$report->reference, 0]);
        $this->get('/lapor')->assertOk()->assertSee($url, false);
        $this->get($url)->assertOk()->assertHeader('Content-Type', 'image/jpeg');
        $this->get(route('lapor.evidence', [$report->reference, 3]))->assertNotFound();
        $this->actingAs($other, 'student')->get($url)->assertNotFound();
        Auth::guard('student')->logout();
        $this->get($url)->assertNotFound();
        $owner->update(['is_active' => false]);
        $this->actingAs($owner, 'student')->get($url)->assertNotFound();
        Auth::guard('student')->logout();
        $this->actingAs(User::factory()->create(), 'web')->get($url)->assertOk();
        Livewire::test(EditPpksReport::class, ['record' => $report->id])->assertSee('Lihat bukti 1');
    }

    public function test_more_than_three_evidence_images_are_rejected(): void
    {
        Storage::fake('local');
        $this->actingAs($this->student(), 'student')->post('/lapor', array_merge($this->payload(), [
            'evidence' => array_map(fn ($index) => UploadedFile::fake()->image('bukti'.$index.'.jpg'), range(1, 4)),
        ]))->assertSessionHasErrors('evidence');
        $this->assertDatabaseCount('ppks_reports', 0);
        $this->assertEmpty(Storage::disk('local')->allFiles());
    }

    public function test_invalid_or_oversized_evidence_is_rejected(): void
    {
        Storage::fake('local');
        $this->actingAs($this->student(), 'student')->post('/lapor', array_merge($this->payload(), [
            'evidence' => [
                UploadedFile::fake()->create('dokumen.pdf', 10, 'application/pdf'),
                UploadedFile::fake()->image('besar.jpg')->size(2049),
                UploadedFile::fake()->create('gambar.svg', 10, 'image/svg+xml'),
            ],
        ]))->assertSessionHasErrors(['evidence.0', 'evidence.1', 'evidence.2']);
        $this->assertDatabaseCount('ppks_reports', 0);
        $this->assertEmpty(Storage::disk('local')->allFiles());
    }
}
