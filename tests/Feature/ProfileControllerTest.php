<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 18.6.2019 г.
 * Time: 20:25
 */

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase {

	use RefreshDatabase;

    public function test_user_not_logged_in_has_no_access()
    {
        $this->get('/questions/1/edit')->assertRedirect('/login');
        $this->put('/questions/1')->assertRedirect('/login');
    }


    /** @test */
	public function user_can_change_his_data()
	{
	    $user = $this->loginWithFakeUser(['name' => 'Fake name', 'email' => 'fake@email.com', 'password' => '123456']);

	    $newUserData = [
	        'name' => 'New name',
            'email' => 'new@email.com',
        ];

	    $response = $this->put('profile/'. $user->id, $newUserData);

	    //Expects redirection
	    $response->assertRedirect('profile/'. $user->id .'/edit');

	    $this->assertDatabaseHas('users', ['name' => 'New name', 'email' => 'new@email.com']);
	    $this->assertDatabaseMissing('users', ['name' => 'Fake name', 'email' => 'fake@email.com']);
    }

    /** @test */
    public function user_can_not_change_others_users_data()
    {
        $this->loginWithFakeUser(['name' => 'Fake name', 'email' => 'fake@email.com', 'password' => '123456']);
        $other = factory(User::class)->create(['name' => 'Other user', 'email' => 'other@email.com']);

        $newUserData = [
            'name' => 'New name',
            'email' => 'new@email.com',
        ];

        //Sending request to other user profile
        $response = $this->put('profile/'. $other->id, $newUserData);

        //Expects forbidden
        $response->assertStatus(403);

        //Expect data is not touched
        $this->assertDatabaseHas('users', ['name' => 'Other user', 'email' => 'other@email.com']);
        $this->assertDatabaseMissing('users', ['name' => 'New name', 'email' => 'new@email.com']);
    }

    /** @test */
    public function email_should_be_unique()
    {
        $user = $this->loginWithFakeUser(['name' => 'Fake name', 'email' => 'fake@email.com', 'password' => '123456']);
        factory(User::class)->create(['name' => 'Other user', 'email' => 'other@email.com']);

        $newUserData = [
            'name' => 'New name',
            'email' => 'other@email.com',
        ];

        $response = $this->put('profile/'. $user->id, $newUserData);

        //Expects forbidden
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');

        $this->assertDatabaseHas('users', ['name' => 'Other user', 'email' => 'other@email.com']);
        $this->assertDatabaseHas('users', ['name' => 'Fake name', 'email' => 'fake@email.com']);
        $this->assertDatabaseMissing('users', ['name' => 'New name', 'email' => 'other@email.com']);
    }

}
