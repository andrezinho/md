<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/local.php';
require_once '../model/empresa.php';
require_once '../model/ciudad.php';

class localController extends Controller
{
    var $idempresa;
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'l.idlocal','align'=>'center','width'=>'35'),
                        2 => array('Name'=>'Descripcion','NameDB'=>'l.descripcion','search'=>true),
                        3 => array('Name'=>'Direccion','NameDB'=>'l.direccion','search'=>true,'align'=>'center'),
                        4 => array('Name'=>'Ciudad','NameDB'=>'u.descripcion','width'=>'90','align'=>'center','color'=>'#FFFFFF'),
                        5 => array('Name'=>'Telefono','NameDB'=>'l.telefono','width'=>'90','align'=>'center','color'=>'#FFFFFF')
                     );

    public function index()
    {
        $obje = new empresa();
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['idempresa'] = (int)$_GET['ide'];        
        //(nuevo,editar,eliminar,ver)
        $data['actions'] = array(true,true,true,false);        
        $empresa = $obje->edit($_GET['ide']);        
        $data['titulo'] = "Locales de ".$empresa->razon_social;        
        $data['enlace'] = "<a href='index.php?controller=empresa' style='color:red;font-weight:bold'>Regresar a Empresas </a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Locales de <b>".$empresa->razon_social."</b>";
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/local/_index.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new local();        
        $page = (int)$_GET['page'];
        $limit = (int)$_GET['rows']; 
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];                
        $emp = $_GET['emp'];
        $filtro = $this->getColNameDB($this->cols,(int)$_GET['f']);        
        $query = $_GET['q'];        
        if(!$sidx) $sidx = 1;
        if(!$limit) $limit = 10;
        if(!$page) $page = 1;        
        echo json_encode($obj->indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$this->getColsVal($this->cols),$emp));
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
        $view->setTemplate( '../view/local/_form.php' );
        echo $view->renderPartial();
    }

    public function edit()
    {
        $objc = new ciudad();
        $obj = new local();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;        
        
        $c = $objc->arrayCiudad();        
        $data['ciudad'] = $this->Select(array('name'=>'distrito','id'=>'distrito','table'=>$c,'code'=>$obj->idubigeo));
        
        $data['more_options'] = $this->more_options('local');
        $view->setData($data);
        $view->setTemplate( '../view/local/_form.php' );
        echo $view->renderPartial();        
    }

    public function loadLocal()
    {
        $obj = new local();
        $data = array();
    }

    public function loadProvincia()
    {
        $p = $this->provincia($_GET['idd']);
        print_r(json_encode($p));
    }
    public function loadDistrito()
    {
        $p = $this->distrito($_GET['idp']);
        print_r(json_encode($p));
    }
    public function save()
    {
        $obj = new local();
        $result = array();        
        if ($_POST['idlocal']=='') 
            $p = $obj->insert($_POST);                        
        else         
            $p = $obj->update($_POST);                                
        if ($p[0])                
            $result = array(1,'');                
        else                 
            $result = array(2,$p[1]);
        print_r(json_encode($result));

    }
    public function delete()
    {
        $obj = new local();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
   
    public function arrayLocal()
    {
        $obj = new local();
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