<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';

class notifyController extends Controller
{
    public function index() 
    {
        $data = array();        
        //(nuevo,editar,eliminar,ver)
        $data['actions'] = array(false,false,false,false);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/notify/_index.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }
}
?>