<?php
class Spdo extends PDO {
    private static $instance = null;
    protected  $host = 'localhost';
    protected $port = '3306';
    protected $dbname='muchos_descuentos';
    protected $user='root';
    protected $password='123456';

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