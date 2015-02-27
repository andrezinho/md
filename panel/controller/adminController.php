<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/admin.php';

class adminController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'idusuario','align'=>'center','width'=>'30'),
                        2 => array('Name'=>'Nombres y Apellidos','NameDB'=>'nombres','search'=>true),
                        3 => array('Name'=>'DNI','NameDB'=>'nrodocumento','search'=>true,'width'=>'50','align'=>'center'),
                        4 => array('Name'=>'Telefono','NameDB'=>'telefono','search'=>true,'width'=>'50','align'=>'center'),
                        5 => array('Name'=>'email','NameDB'=>'email','search'=>true,'width'=>'80','align'=>'center'),                        
                        6 => array('Name'=>'Estado','NameDB'=>'estado','width'=>'40','align'=>'center','color'=>'#FFFFFF')
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
        $data['titulo'] = "Gestion de Administradores";

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new admin();        
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
        $data['tipo_documento'] = $this->Select(array('name'=>'idtipo_documento','id'=>'idtipo_documento','table'=>'tipo_documento'));
        $view->setData($data);
        $view->setTemplate( '../view/admin/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() {
        $obj = new admin();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['tipo_documento'] = $this->Select(array('name'=>'idtipo_documento','id'=>'idtipo_documento','table'=>'tipo_documento','code'=>$obj->idtipo_documento));
        $view->setData($data);
        $view->setTemplate( '../view/admin/_form.php' );
        echo $view->renderPartial();
    }

    public function save()
    {
        $obj = new admin();
        $result = array();        
        if ($_POST['idusuario']=='') 
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
        $obj = new admin();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }

    public function vemail()
    {
        $obj = new admin();
        $result = array();
        $v = $obj->vemail($_GET['e']);
        print_r(json_encode($v));
    }
}
?>