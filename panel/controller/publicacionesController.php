<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/publicaciones.php';
require_once '../model/subcategoria.php';

class publicacionesController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'p.idpublicaciones','align'=>'center','width'=>'30'),
                        2 => array('Name'=>'Titulo','NameDB'=>'p.titulo1','search'=>true),
                        3 => array('Name'=>'Tipo','NameDB'=>'sc.descripcion','search'=>true,'align'=>'center','width'=>'70'),
                        4 => array('Name'=>'Fecha Incio.','NameDB'=>'p.fecha_inicio','search'=>true,'align'=>'center','width'=>'50'),
                        5 => array('Name'=>'Fecha Fin.','NameDB'=>'p.fecha_fin','search'=>true,'align'=>'center','width'=>'50'),
                        6 => array('Name'=>'Estado','NameDB'=>'p.estado','width'=>'30','align'=>'center','color'=>'#FFFFFF')
                     );

    public function index() 
    {
        $data = array();
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        //......................(nuev,edit,elim,vermp)
        $data['actions'] = array(true,true,true,false);
        $data['titulo'] = "Publicaciones de Descuentos";

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new publicaciones();
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
        
        $data['categoria'] = $this->Select(array('name'=>'idcategoria','id'=>'idcategoria','table'=>'categoria'));
        $data['tipo_descuento'] = $this->Select(array('name'=>'idtipo_descuento','id'=>'idtipo_descuento','table'=>'tipo_descuento'));
        
        $view->setData($data);
        $view->setTemplate( '../view/publicaciones/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new publicaciones();
        $obj_l = new subcategoria();
        $data = array();
        $view = new View();

        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;

        $data['categoria'] = $this->Select(array('name'=>'idcategoria','id'=>'idcategoria','table'=>'categoria','code'=>$obj->idcategoria));
        $sc = $obj_l->arraysc($obj->idcategoria);
        $data['subcategoria'] = $this->Select(array('name'=>'idsubcategoria','id'=>'idsubcategoria','table'=>$sc,'code'=>$obj->idsubcategoria));
        $data['tipo_descuento'] = $this->Select(array('name'=>'idtipo_descuento','id'=>'idtipo_descuento','table'=>'tipo_descuento','code'=>$obj->idtipo_descuento));

        
        $view->setData($data);
        $view->setTemplate( '../view/publicaciones/_form.php' );
        echo $view->renderPartial();        
    }

    public function save()
    {
        $obj = new publicaciones();
        $result = array();
        if ($_POST['idpublicaciones']=='')
            {$p = $obj->insert($_POST);}
        else
            {$p = $obj->update($_POST);}

        print_r(json_encode($p));
    }
    public function delete()
    {
        $obj = new publicaciones();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
   
    public function imagen()
    {
        echo "Oda";
    }
   
}

?>