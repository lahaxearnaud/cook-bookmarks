<?php

/**
 * Interface of the token Manager
 *
 * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
 */
interface TokenManagerInterface
{

    /**
     * Get the token instance by the token value and the user instance
     *
     * @param User   $user
     * @param string $token
     *
     * @return Token|null
     */
    public function get(User $user, $token);

    /**
     * Check if the token is still valid
     *
     * @param Token $token
     *
     * @return boolean
     */
    public function isValid(Token $token);

    /**
     * Mark the token as used
     *
     * @param Token $token
     *
     * @return boolean true if succeed
     */
    public function burn(Token $token);


    /**
     * Create a token and return it
     *
     * @param User    $user
     * @param integer $lifetime
     *
     * @return Token
     */
    public function generate(User $user, $lifetime = 3600);


    /**
     * Get the crypt value of the token
     *
     * @param Token $token [description]
     *
     * @return [type] [description]
     */
    public function getCryptTokenValue(Token $token);

    /**
     * Get the decrypt value of the token
     *
     * @param [type] $token [description]
     *
     * @return [type] [description]
     */
    public function decryptTokenValue($token);
}
