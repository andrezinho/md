<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/empresa.php';

class empresaController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'e.idempresa','align'=>'center','width'=>50),
                        2 => array('Name'=>'Nombre / Razon Social','NameDB'=>'e.razon_social','width'=>250,'search'=>true),
                        3 => array('Name'=>'RUC','NameDB'=>'e.ruc','search'=>true,'width'=>100,'align'=>'center'),
                        4 => array('Name'=>'Nombre de Contacto','NameDB'=>'e.nombre_contacto'),
                        5 => array('Name'=>'Telefonos','NameDB'=>'e.telefonos','align'=>'center','search'=>true),                        
                        6 => array('Name'=>'Estado','NameDB'=>'m.estado','align'=>'center','width'=>70),
                        7 => array('Name'=>'Locales','NameDB'=>'','align'=>'center','width'=>70)
                     );
    
    public function index() 
    {
        $data = array();
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];

        //(nuevo,editar,eliminar,ver)
        $data['actions'] = array(true,true,true,false);
        
        $data['titulo'] = "Gestion de Empresas";
        //$data['opciones'] = 

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }
    public function indexGrid() 
    {
        $obj = new empresa();  
              
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
        $data = array();
        $view = new View();
        $data['bancos'] = $this->Select(array('id'=>'idbancos','name'=>'idbancos','table'=>'bancos'));
        $view->setData($data);
        $view->setTemplate( '../view/empresa/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj_ = new empresa();
        $data = array();
        $view = new View();
        $obj = $obj_->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['bancos'] = $this->Select(array('id'=>'idbancos','name'=>'idbancos','table'=>'bancos'));
        $data['empresasPadres'] = $this->Select(array('id'=>'idpadre','name'=>'idpadre','table'=>'vista_empresa','code'=>$obj->idpadre));
        $data['cuentas'] = $obj_->getCuentas($_GET['id']);
        $view->setData($data);
        $view->setTemplate( '../view/empresa/_form.php' );
        echo $view->renderPartial();
    }

    public function view() 
    {
        $obj = new empresa();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['bancos'] = $this->Select(array('id'=>'idbancos','name'=>'idbancos','table'=>'bancos'));
        $data['empresasPadres'] = $this->Select(array('id'=>'idpadre','name'=>'idpadre','table'=>'vista_empresa','code'=>$obj->idpadre));
        $view->setData($data);
        $view->setTemplate( '../view/empresa/_form.php' );
        echo $view->renderPartial();
    }
    public function save()
    {        
        $obj = new empresa();
        $result = array();        
        if ($_POST['idempresa']=='') 
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
        $obj = new empresa();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
    }
 

?>