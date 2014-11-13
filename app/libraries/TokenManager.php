<?php
use \User as User;
use \Token as Token;
use \Carbon\Carbon;
use \Repositories\TokensRepository;
use \Crypt as Crypt;

class TokenManager implements TokenManagerInterface {

	/**
	 * @var TokensRepository
	 */
	protected $repository;

    function __construct (TokensRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
	 * Get the token instance by the token value and the user instance
	 * @param  User   $user
	 * @param  string $token
	 * @return Token
	 */
	public function get(User $user, $token)
	{
		return $this->repository->getByToken($token, $user);
	}

	/**
	 * Check if the token is still valid
	 * @param  Token   $token
	 * @return boolean
	 */
	public function isValid(Token $token)
	{
		return $token->expire_at->diffInMinutes(Carbon::now()) > 0;
	}

	/**
	 * Mark the token as used
	 * @param  Token  $token
	 * @return boolean       true if succeed
	 */
	public function burn(Token $token)
	{
		return $this->repository->delete($token->id);
	}


	/**
	 * Create a token and return it
	 * @return Token
	 */
	public function generate(User $user, $lifetime = 3600)
	{
		$tokenValue = sha1(str_random(30) . time() . $user->id);
		return $this->repository->create([
			'token' => $tokenValue,
			'user_id' => $user->id,
			'expire_at' => Carbon::now()->addSeconds($lifetime)
		]);
	}

	public function getCryptTokenValue(Token $token)
	{
		return Crypt::encrypt($token->token);
	}

	public function decryptTokenValue($token)
	{
		return Crypt::decrypt($token);
	}
}