<?php

class Controller
{
    /**
     * @var null Database Connection
     */
    public $db = null;

    public $model_name = null;

    //登录的用户id
    public $login_user_id = NULL;
    /**
     * Whenever controller is created, open a database connection too and load "the model".
     */
    function __construct($params)
    {
        $this->model_name = $params['model_name'];
        $this->login_user_id = $params['user_id'];
        $this->openDatabaseConnection();
        date_default_timezone_set('PRC');
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        //$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        //$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
        $this->db = & DB('', TRUE);
    }
}
