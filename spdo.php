<?php
class Spdo extends PDO 
{
    private static $instance = null;
    protected  $host = '50.62.209.107';
    protected $port = '3306';
    protected $dbname='MuchosDescuentosBD';
    protected $user='mdUser';
    protected $password='0014033';

    public function __construct()
    {            
        $dns='mysql:dbname='.$this->dbname.';host='.$this->host.';port='.$this->port;
        $user = $this->user;
        $pass = $this->password;
        parent::__construct($dns,$user,$pass);
    }

    public static function singleton()
    {
        if( self::$instance == null )
            {
                self::$instance = new self();
            }
         return self::$instance;
    }
}
?>