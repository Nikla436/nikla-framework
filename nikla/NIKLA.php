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

    private $config_sql_password = null;
    private $config_sql_username = null;
    private $config_sql_database = null;
    private $config_sql_server = null;

    public function __construct()
    {
        //
    }

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
}