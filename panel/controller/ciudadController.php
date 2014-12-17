<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/ciudad.php';
require_once '../model/empresa.php';

class ciudadController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'s.idciudad','align'=>'center','width'=>'20'),
                        2 => array('Name'=>'Descripcion','NameDB'=>'u.descripcion','search'=>true),
                        3 => array('Name'=>'Estado','NameDB'=>'s.estado','width'=>'30','align'=>'center','color'=>'#FFFFFF')
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

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new ciudad();        
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
        $d = $this->departamentos();
        $data['departamento'] = $this->Select(array('name'=>'departamento','id'=>'departamento','table'=>$d));                       
        
        $view->setData($data);
        $view->setTemplate( '../view/ciudad/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new ciudad();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;    
        $d = $this->departamentos();
        $data['departamento'] = $this->Select(array('name'=>'departamento','id'=>'departamento','table'=>$d,'code'=>  substr($obj->idciudad, 0,2)."0000"));
        $p = $this->provincia($obj->idciudad);
        $data['provincia'] = $this->Select(array('name'=>'provincia','id'=>'provincia','table'=>$d,'code'=>  substr($obj->idciudad, 0,2)."0000"));
        $dd = $this->distrito($obj->idciudad);
        $data['distrito'] = $this->Select(array('name'=>'distrito','id'=>'distrito','table'=>$dd,'code'=> $obj->idciudad));    
        $data['more_options'] = $this->more_options('ciudad');
        $view->setData($data);
        $view->setTemplate( '../view/ciudad/_form.php' );
        echo $view->renderPartial();
        
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
        $obj = new ciudad();
        $result = array();        
        if ($_POST['idciudad']=='') 
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
        $obj = new ciudad();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
  
    public function arrayCiudad()
    {
        $obj = new ciudad();
        $data = array();        
        $data = $obj->arrayCiudad();
        print_r(json_encode($data));
    } 
   
}

?>