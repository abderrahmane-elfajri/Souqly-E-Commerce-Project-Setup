<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Connexion');
    }

    public function test_register_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Inscription');
        $response->assertSee('Casablanca');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::create([
            'name' => 'Yassine Test',
            'email' => 'yassine.test@souqly.ma',
            'phone' => '0661234567',
            'password' => Hash::make('password123'),
            'role' => UserRole::CUSTOMER,
            'status' => 'active',
        ]);

        $response = $this->post('/login', [
            'email' => 'yassine.test@souqly.ma',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('account.dashboard'));
    }

    public function test_admin_redirects_to_admin_dashboard_on_login(): void
    {
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin.test@souqly.ma',
            'phone' => '+212661000001',
            'password' => Hash::make('password123'),
            'role' => UserRole::SUPER_ADMIN,
            'status' => 'active',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin.test@souqly.ma',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::create([
            'name' => 'Yassine Test',
            'email' => 'yassine.test2@souqly.ma',
            'phone' => '0661234567',
            'password' => Hash::make('password123'),
            'role' => UserRole::CUSTOMER,
            'status' => 'active',
        ]);

        $this->post('/login', [
            'email' => 'yassine.test2@souqly.ma',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_new_customers_can_register_with_moroccan_phone_and_city(): void
    {
        $response = $this->post('/register', [
            'name' => 'Sara Bennani',
            'email' => 'sara@example.com',
            'phone' => '0661998877',
            'city' => 'Rabat',
            'address' => 'Avenue Mohammed V, Appt 5',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('account.dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'sara@example.com',
            'role' => 'customer',
        ]);

        $this->assertDatabaseHas('addresses', [
            'city' => 'Rabat',
            'phone' => '0661998877',
            'is_default' => 1,
        ]);
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $customer = User::create([
            'name' => 'Customer Test',
            'email' => 'regular@souqly.ma',
            'phone' => '0661000000',
            'password' => Hash::make('password123'),
            'role' => UserRole::CUSTOMER,
            'status' => 'active',
        ]);

        $response = $this->actingAs($customer)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Manager Test',
            'email' => 'manager@souqly.ma',
            'phone' => '0661000001',
            'password' => Hash::make('password123'),
            'role' => UserRole::ADMIN,
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Tableau de Bord Administratif');
    }

    public function test_user_can_logout(): void
    {
        $user = User::create([
            'name' => 'Logout Test',
            'email' => 'logout@souqly.ma',
            'phone' => '0661000002',
            'password' => Hash::make('password123'),
            'role' => UserRole::CUSTOMER,
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->post('/logout');
        $this->assertGuest();
        $response->assertRedirect(route('home'));
    }
}
