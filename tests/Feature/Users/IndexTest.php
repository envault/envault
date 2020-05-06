<?php

namespace Tests\Feature\Users;

use App\User;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_view_users()
    {
        Livewire::test('users.index')
            ->assertSee($this->authenticatedUser->full_name);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticatedUser = factory(User::class)->create([
            'role' => 'owner',
        ]);

        Livewire::actingAs($this->authenticatedUser);
    }
}
