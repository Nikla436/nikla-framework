<?php

namespace nikla\components;


/**
 * Class NiklaSQL
 * @package nikla\components
 */
class NiklaSQL
{
    private $serverName;
    private $userName;
    private $password;
    private $database;

    private $conn;

    public function __construct()
    {
        //
    }

    public function setServerName($name)
    {
        $this->serverName = trim($name);
        return $this;
    }

    public function setUserName($user)
    {
        $this->userName = trim($user);
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setDatabase($database)
    {
        $this->database = trim($database);
        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function getInstance()
    {
        $this->conn = new \mysqli(
            $this->serverName,
            $this->userName,
            $this->password,
            $this->database
        );

        if ($this->conn->connect_error) {
            throw new \Exception('Error Connecting to Database');
        }

        return $this;
    }

    public function killConnection()
    {
        $this->conn->close();
    }

    public function query($query)
    {
        return $this->conn->query($query);
    }
}