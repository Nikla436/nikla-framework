<?php

namespace nikla;

use nikla\components\NiklaSQL;

/**
 * Class NIKLA
 * @package nikla
 */
class NIKLA
{
    /** @var NiklaSQL */
    private $oSQL = null;

    private $config_email_from   = null;
    private $config_sql_password = null;
    private $config_sql_username = null;
    private $config_sql_database = null;
    private $config_sql_server   = null;

    public function __construct()
    {
        //
    }

    /**
     * Available config settings
     * ------------------------------------------------------------------
     * sql_password | Password used with MySQL connection
     * sql_username | Username used with MySQL connection
     * sql_database | MySQL database name to connect to
     * sql_server   | MySQL server name to connect to
     * email_from   | From email address to use when sending emails
     * ------------------------------------------------------------------
     *
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        if (isset($config['sql_password']))
            $this->config_sql_password = $config['sql_password'];
        if (isset($config['sql_username']))
            $this->config_sql_username = $config['sql_username'];
        if (isset($config['sql_database']))
            $this->config_sql_database = $config['sql_database'];
        if (isset($config['sql_server']))
            $this->config_sql_server = $config['sql_server'];
        if (isset($config['email_from']))
            $this->config_email_from = $config['email_from'];
        return $this;
    }

    /**
     * @return NiklaSQL
     * @throws \Exception
     */
    public function SQL()
    {
        // Return the existing object if its already been created.
        if (!is_null($this->oSQL)) {
            return $this->oSQL;
        }

        $oSQL = new NiklaSQL();
        if (!is_null($this->config_sql_password)) {
            $oSQL->setPassword($this->config_sql_password);
        } else {
            throw new \Exception('No SQL password set');
        }
        if (!is_null($this->config_sql_database)) {
            $oSQL->setDatabase($this->config_sql_database);
        } else {
            throw new \Exception('No SQL database set');
        }
        if (!is_null($this->config_sql_username)) {
            $oSQL->setUserName($this->config_sql_username);
        } else {
            throw new \Exception('No SQL username set');
        }
        if (!is_null($this->config_sql_server)) {
            $oSQL->setServerName($this->config_sql_server);
        } else {
            throw new \Exception('No SQL server set');
        }

        $this->oSQL = $oSQL->getInstance(); // Set the SQL object
        return $this->oSQL;
    }

    /**
     * @param string $content - HTML
     * @param string $subject
     * @param string $address - To Email
     * @throws \Exception
     * @return bool
     */
    public function sendEmail($content, $subject, $address)
    {
        static $validEmailExp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if (is_null($this->config_email_from)) {
            throw new \Exception('From email not setup');
        }

        if (!preg_match($validEmailExp, $this->config_email_from)) {
            throw new \Exception('From address is not a valid email');
        }

        if (!preg_match($validEmailExp, $address)) {
            throw new \Exception('To address is not a valid email');
        }

        $headers = 'From: ' . $this->config_email_from . "\r\n" . 'Reply-To: '.$this->config_email_from . "\r\n" . 'X-Mailer: PHP/' . phpversion();

        try {
            @mail($address, $subject, $content, $headers);
        } catch (\Exception $e) {
            throw new \Exception("Error sending email");
        }

        return true;
    }
}