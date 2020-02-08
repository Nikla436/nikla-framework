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

    /** @var \mysqli */
    private $conn;

    public function __construct()
    {
        //
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setServerName($name)
    {
        $this->serverName = trim($name);
        return $this;
    }

    /**
     * @param string $user
     * @return $this
     */
    public function setUserName($user)
    {
        $this->userName = trim($user);
        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $database
     * @return $this
     */
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

    public function getLastID()
    {
        return $this->conn->insert_id;
    }

    /**
     * @param $query
     * @return bool|\mysqli_result
     */
    public function query($query)
    {
        return $this->conn->query($query);
    }

    /**
     * @param string $query
     * @return string
     */
    public function getValue($query)
    {
        /** @var \mysqli_result $result */
        if ($result = $this->query($query)) {
            if ($row = $result->fetch_row()) {
                return $row[0];
            }
        }
        return '';
    }

    /**
     * @param string $query
     * @return array
     */
    public function getRow($query)
    {
        /** @var \mysqli_result $result */
        if ($result = $this->query($query)) {
            if ($row = $result->fetch_assoc()) {
                if (!is_null($row)) {
                    return $row;
                }
            }
        }
        return [];
    }

    /**
     * @param string $query
     * @return array
     */
    public function getRows($query)
    {
        $response = [];
        /** @var \mysqli_result $result */
        if ($result = $this->query($query)) {
            while ($row = $result->fetch_assoc()) {
                if (!is_null($row)) {
                    $response[] = $row;
                }
            }
        }
        return $response;
    }

}
