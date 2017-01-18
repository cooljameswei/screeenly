<?php

use Screeenly\Models\User;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GithubOAuthLoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Mock the Socialite Factory, so we can hijack the Github Request.
     * @param  string  $email
     * @param  string  $token
     * @param  int $id
     * @return void
     */
    public function mockSocialiteFacade($email = 'foo@bar.com', $token = 'foo', $id = 1)
    {
        $socialiteUser = $this->createMock(Laravel\Socialite\Two\User::class);
        $socialiteUser->token = $token;
        $socialiteUser->id = $id;
        $socialiteUser->email = $email;

        $provider = $this->createMock(Laravel\Socialite\Two\GithubProvider::class);
        $provider->expects($this->any())
            ->method('user')
            ->willReturn($socialiteUser);

        $stub = $this->createMock(Socialite::class);
        $stub->expects($this->any())
            ->method('driver')
            ->willReturn($provider);

        // Replace Socialite Instance with our mock
        $this->app->instance(Socialite::class, $stub);
    }

    /** @test */
    public function it_redirects_to_github()
    {
        // See: http://stackoverflow.com/a/36799824
    }

    /** @test */
    public function it_retrieves_github_request_and_creates_a_new_user()
    {
        $this->mockSocialiteFacade();

        $this->visit('/oauth/github/handle')
            ->seePageIs('/dashboard')
            ->see('Dashboard');

        $this->seeInDatabase('users', [
            'email' => 'foo@bar.com',
        ]);
    }

    /** @test */
    public function it_retrieves_github_request_and_login_existing_user()
    {
        $user = factory(User::class)->create();

        $this->mockSocialiteFacade($user->email, $user->token, $user->provider_id);

        $this->visit('/oauth/github/handle')
            ->seePageIs('/dashboard')
            ->see('Dashboard');
    }

    /** @test */
    public function it_redirects_user_with_out_email_address_to_setup_page()
    {
        $this->mockSocialiteFacade(null, 'secret_token', '12345');

        $this->visit('/oauth/github/handle')
            ->seePageIs('/setup/email?provider_id=12345');
    }
}
