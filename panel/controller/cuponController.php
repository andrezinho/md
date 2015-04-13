<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/cupon.php';

class cuponController extends Controller
{
    var $idempresa;
    var $cols = array(
                        1 => array('Name'=>'Num','NameDB'=>'c.idcupon','align'=>'center','width'=>'40'),
                        2 => array('Name'=>'Codigo','NameDB'=>'c.numero','search'=>true,'align'=>'center','width'=>'50'),
                        3 => array('Name'=>'Fecha C.','NameDB'=>'c.fecha','search'=>true,'align'=>'center','width'=>'50'),
                        4 => array('Name'=>'Hora','NameDB'=>'c.hora','width'=>'30','align'=>'center'),
                        5 => array('Name'=>'Precio','NameDB'=>'c.costo_descuento','width'=>'40','align'=>'center'),
                        6 => array('Name'=>'Nro Doc.','NameDB'=>'u.nrodocumento','width'=>'40','align'=>'center','search'=>true),
                        7 => array('Name'=>'Cliente','NameDB'=>'cliente','width'=>'80','align'=>'left','search'=>true),
                        8 => array('Name'=>'Producto/Servicio','NameDB'=>'titulo1','width'=>'90','align'=>'left','search'=>true),
                        9 => array('Name'=>'Imp.','NameDB'=>'','width'=>'20','align'=>'center'),
                        10 => array('Name'=>'Estado','NameBD'=>'c.estado','align'=>'center', 'width'=>'40')
                     );
    
    public function index()
    {
        $data = array();
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        //(nuevo,editar,eliminar,ver)
        $data['actions'] = array(false,false,false,true,false);
        $data['titulo'] = "Cupones Generados";
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new cupon();        
        $page = (int)$_GET['page'];
        $limit = (int)$_GET['rows']; 
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];                        
        $filtro = $this->getColNameDB($this->cols,(int)$_GET['f']);        
        $query = $_GET['q'];        
        if(!$sidx) $sidx = 1;
        if(!$limit) $limit = 10;
        if(!$page) $page = 1;        
        echo json_encode($obj->indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$this->getColsVal($this->cols)));
    }

    public function create()
    {
        $objc = new ciudad();
        $data = array();
        $view = new View();                
        $d = $this->departamentos();
        
        $c = $objc->arrayCiudad();        
        $data['ciudad'] = $this->Select(array('name'=>'distrito','id'=>'distrito','table'=>$c));
        $data['idempresa'] = $_GET['emp'];
        $view->setData($data);
        $view->setTemplate( '../view/cupon/_form.php' );
        echo $view->renderPartial();
    }

    public function view()
    {        
        $obj = new cupon();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;                
        $view->setData($data);
        $view->setTemplate( '../view/cupon/_form.php' );
        echo $view->renderPartial();        
    }

    
    public function save()
    {
        $obj = new cupon();
        $result = array();        
        $p = $obj->update($_POST);                                

        if ($p[0])                
            $result = array(1,'');                
        else                 
            $result = array(2,$p[1]);
        
        print_r(json_encode($result));

    }
    public function delete()
    {
        $obj = new cupon();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
   
    public function arrayLocal()
    {
        $obj = new cupon();
        $data = array();
        if(!isset($_GET['ide']))
        {
            $_GET['ide']=0;
        }
        $data = $obj->arrayLocal($_GET['ide']);
        print_r(json_encode($data));
    }
}
?>