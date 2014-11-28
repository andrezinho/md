<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/suscripcion.php';
require_once '../model/local.php';

class suscripcionController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'idsuscripcion','align'=>'center','width'=>'40'),
                        2 => array('Name'=>'Empresa - Local','NameDB'=>"concat(e.razon_social,' - ',l.descripcion)",'search'=>true),
                        3 => array('Name'=>'Fecha Inicio','NameDB'=>'s.fecha_inicio','search'=>true,'width'=>'50','align'=>'center'),
                        4 => array('Name'=>'Fecha Fin','NameDB'=>'s.fecha_fin','search'=>true,'align'=>'center','width'=>'50'),                        
                        5 => array('Name'=>'Max P.','NameDB'=>'','search'=>false,'align'=>'center','width'=>'40'),
                        6 => array('Name'=>'Num P.','NameDB'=>'','search'=>false,'align'=>'center','width'=>'40'),
                        7 => array('Name'=>'Estado','NameDB'=>'estado','width'=>'50','align'=>'center','color'=>'#FFFFFF')
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
        $data['titulo'] = "Gestion de suscripciones";

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new suscripcion();        
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
        //$data['more_options'] = $this->more_options('suscripcion');        
        $data['empresa'] = $this->Select(array('name'=>'idempresa','id'=>'idempresa','table'=>'vempresa'));
        $data['tipo_documento'] = $this->Select(array('name'=>'idtipo_documento','id'=>'idtipo_documento','table'=>'tipo_documento'));
        $view->setData($data);
        $view->setTemplate( '../view/suscripcion/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new suscripcion();
        $obj_l = new local();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;        
        //$data['more_options'] = $this->more_options('suscripcion');
        $data['empresa'] = $this->Select(array('name'=>'idempresa','id'=>'idempresa','table'=>'vempresa','code'=>$obj->idempresa));
        $locales = $obj_l->arrayLocal($obj->idempresa);
        $data['local'] = $this->Select(array('name'=>'idlocal','id'=>'idlocal','table'=>'vlocal','code'=>$obj->idlocal));
        $data['tipo_documento'] = $this->Select(array('name'=>'idtipo_documento','id'=>'idtipo_documento','table'=>'tipo_documento','code'=>$obj->idtipo_documento));
        $view->setData($data);
        $view->setTemplate( '../view/suscripcion/_form.php' );
        echo $view->renderPartial();
        
    }

    public function save()
    {
        $obj = new suscripcion();
        $result = array();        
        if ($_POST['idsuscripcion']=='') 
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
        $obj = new suscripcion();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
   
   
}

?>