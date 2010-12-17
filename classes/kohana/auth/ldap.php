<?php defined('SYSPATH') or die('No direct access allowed.');

class Kohana_Auth_LDAP extends Auth
{
    // Zend_LDAP instance
    protected $ldap;

    public function __construct($config = array())
    {
        $options = Kohana::config('ldap');

        $this->ldap = new Zend_Ldap($options);

        parent::__construct($config);
    }

    /**
     * Override Auth login so that the password is not hashed.
     *
     * @param   string   username to log in
     * @param   string   password to check against
     * @param   boolean  enable autologin
     * @return  boolean
     */
    public function login($username, $password, $remember = FALSE)
    {
        if (empty($password))
            return FALSE;

        return $this->_login($username, $password, $remember);
    }
    
    /**
     * Logs a user in.
     *
     * @param   string   username
     * @param   string   password
     * @param   boolean  enable autologin
     * @return  boolean
     */
    protected function _login($username, $password, $remember)
    {
        try
        {
            if ($this->ldap->bind($username, $password))
            {
                return $this->complete_login($username);
            }
        }
        catch (Zend_Ldap_Exception $e)
        {
            switch ($e->getCode()) {
                // If the password is incorrect
                case Zend_Ldap_Exception::LDAP_INVALID_CREDENTIALS:
                // If the username is not found
                case Zend_Ldap_Exception::LDAP_NO_SUCH_OBJECT:
                    return FALSE;
                default:
                    throw new Kohana_Exception($e->getMessage());
            }
        }

        return FALSE;
    }

    /**
     * Get the stored password for a username.
     *
     * @param   mixed   username string, or user ORM object
     * @return  string
     */
    public function password($username)
    {
        throw new Kohana_Exception('Attempt to call password method');
    }

    /**
     * Compare password with original (hashed). Works for current (logged in) user
     *
     * @param   string   $password
     * @return  boolean
     */
    public function check_password($password)
    {
        throw new Kohana_Exception('Attempt to call check_password method');
    }
} // End Kohana_Auth_LDAP
