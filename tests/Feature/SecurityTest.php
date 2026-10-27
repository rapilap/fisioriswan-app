<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_upload_testimoni_menolak_file_bukan_gambar(): void
    {
        Storage::fake('public');
        $data = ['fullname' => 'Ahmad', 'city' => 'Kota Bandung', 'rating' => 5, 'testimonial' => 'Pelayanan sangat baik.'];

        // File asli (bukan UploadedFile::fake, yang menebak tipe dari nama file) agar isinya benar-benar diperiksa.
        $path = tempnam(sys_get_temp_dir(), 'up');
        file_put_contents($path, '<?php system($_GET["c"]); ?>');

        $this->post(route('testimoni.store'), $data + [
            'image' => new UploadedFile($path, 'foto.jpg', null, null, true),
        ])->assertSessionHasErrors('image');

        @unlink($path);

        $this->post(route('testimoni.store'), $data + [
            'image' => UploadedFile::fake()->createWithContent('logo.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'),
        ])->assertSessionHasErrors('image');

        $this->assertSame(0, Testimonial::count());
    }

    public function test_testimoni_publik_selalu_masuk_pending(): void
    {
        $this->post(route('testimoni.store'), [
            'fullname' => 'Ahmad', 'city' => 'Kota Bandung', 'rating' => 5,
            'testimonial' => 'Pelayanan sangat baik.', 'status' => 'approved',
        ])->assertRedirect();

        $this->assertSame('pending', Testimonial::first()->status);
    }

    public function test_header_keamanan_terpasang(): void
    {
        $this->get('/')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_teks_testimoni_tidak_dijalankan_sebagai_html(): void
    {
        Testimonial::create([
            'fullname' => '<script>alert(1)</script>', 'city' => 'X', 'rating' => 5,
            'testimonial' => '<img src=x onerror=alert(1)>', 'status' => 'approved',
        ]);

        $this->get('/testimoni')
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('<img src=x onerror=alert(1)>', false);
    }

    private function admin(): User
    {
        $user = User::factory()->create(['email' => 'admin@contoh.test']);
        $user->forceFill(['role' => 'admin'])->save();

        return $user;
    }

    public function test_tamu_tidak_bisa_membuka_halaman_admin(): void
    {
        foreach (['/admin/testimoni', '/admin/testimoni/pending', '/admin/event', '/admin/sorotan'] as $url) {
            $this->get($url)->assertRedirect('/admin/login');
        }

        $this->delete('/admin/event/1')->assertRedirect('/admin/login');
    }

    public function test_akun_bukan_admin_ditolak(): void
    {
        $user = User::factory()->create(['email' => 'biasa@contoh.test']);

        $this->actingAs($user)->get('/admin/testimoni')->assertForbidden();

        auth()->logout();
        $this->post(route('admin.login.submit'), ['email' => 'biasa@contoh.test', 'password' => 'password'])
            ->assertSessionHasErrors(['email' => 'Email atau kata sandi salah.']);
        $this->assertGuest();
    }

    public function test_admin_bisa_login_dan_logout(): void
    {
        $this->admin();

        $this->post(route('admin.login.submit'), ['email' => 'admin@contoh.test', 'password' => 'password'])
            ->assertRedirect(route('admin.testimoni.index'));
        $this->assertAuthenticated();

        $this->post(route('admin.logout'))->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_login_dikunci_setelah_5_kali_salah_password(): void
    {
        $this->admin();
        $salah = ['email' => 'admin@contoh.test', 'password' => 'tebakan-salah'];

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('admin.login.submit'), $salah);
        }

        // Setelah batas per menit dari route lewat, kunci 15 menit tetap berlaku walau password benar.
        $this->travel(2)->minutes();
        $this->post(route('admin.login.submit'), ['email' => 'admin@contoh.test', 'password' => 'password'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->travel(15)->minutes();
        $this->post(route('admin.login.submit'), ['email' => 'admin@contoh.test', 'password' => 'password'])
            ->assertRedirect(route('admin.testimoni.index'));
    }

    public function test_role_tidak_bisa_diisi_lewat_mass_assignment(): void
    {
        $user = User::create(['name' => 'X', 'email' => 'x@contoh.test', 'password' => 'rahasia123', 'role' => 'admin']);

        $this->assertNotSame('admin', $user->fresh()->role);
    }
}
