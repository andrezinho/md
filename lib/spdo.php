<?php
class Spdo extends PDO 
{
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


class Buscador extends Spdo
{ 
    protected $db;
    private $busqueda=array();
    
    public function __construct()
    {
        $this->db = Spdo::singleton();
        $this->db->query('SET NAMES UTF8');
    }
    
    public function buscar()
    {
        
        $stmt = $this->db->prepare("SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion,
                             c.descripcion as categoria,p.precio,p.precio_regular,p.descuento,
                             p.imagen,p.idtipo_descuento
                      FROM publicaciones as p
                      INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                      INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                      INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion 
                      INNER JOIN local as l on l.idlocal=su.idlocal
                      WHERE lower(p.titulo1) like '%".strtolower($_GET['search'])."%' OR lower(p.titulo2) like '%".strtolower($_GET['search'])."%' and l.idubigeo='".$_SESSION['idciudad']."' order by p.idpublicaciones desc");
        
        $stmt->execute();
        return $stmt->fetchAll();
        
        
    }
}

$db=Spdo::singleton();
$host="http://".$_SERVER['SERVER_NAME']."/md";

?>