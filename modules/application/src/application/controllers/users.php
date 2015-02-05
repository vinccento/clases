<?phP
namespace application\controllers;

use core\models\FrontController;

class Users
{
    
    public $layout = 'dashboard';
    public $config;
    public $request;
    
    
    public function __construct()
    {
        $applicationConfig = '';
        $this->config = FrontController::getInstance($applicationConfig)->returnConfig();
        $this->request = FrontController::getInstance($applicationConfig)->request;
        
    }
    
    
    
    public function index()
    {
       header('Location: /users/select'); 
    }
    
    public function select()
    {
        
        echo "select()"."<br>";
        require_once ('../modules/application/src/application/models/getUsersDB.php');
        require_once ('../modules/core/src/core/models/renderView.php');
        // $usuarios = getUsers($filename);
        $usuarios=getUsersDB('users', $this->config);
        $content = renderView($this->request, $this->config,
                                array('usuarios'=>$usuarios));
        
        return $content;
    }
    
    public function insert()
    {
        require_once ('../modules/core/src/core/forms/filterForm.php');
        require_once ('../modules/core/src/core/forms/validationForm.php');
        require_once ('../modules/application/src/application/models/insertUserDB.php');
        require_once ('../modules/core/src/core/models/renderView.php');
               
        if($_POST)
        {
            $filterdata = filterForm($userForm, $_POST);
            $validationdata = validationForm($userForm, $filterdata);
            if($validationdata===TRUE)
            {
                //insertUser($filterdata, $filename);
                insertUserDB($filterdata, 'users', $this->config);
            }
            header('Location: /users');
        }
        else
        {
            $content = renderView($this->request, $this->config);
        }
        
        return $content;
    }
    
    public function update()
    {
        require_once ('../modules/core/src/core/forms/filterForm.php');
        require_once ('../modules/application/src/application/models/updateUserDB.php');
        require_once ('../modules/application/src/application/models/getUserDB.php');
        require_once ('../modules/core/src/core/models/renderView.php');
        
        if($_POST)
        {
            $filterdata = filterForm($userForm, $_POST);
            // Validar el formulario
            //updateUser($filterdata, $filterdata['id'], $filename);
            updateUserDB($filterdata, 'users', $this->config, $filterdata['iduser']);
            header('Location: /users');
        }
        else
        {
            // $usuario = getUser($request['params']['id'], $filename);
            $usuario = getUserDB('users', $this->request['params']['id'], $this->config);
            $content = renderView($this->request, $this->config, array('usuario'=>$usuario[0]));
        }
        
        return $content;
    }
    
    public function delete()
    {
        require_once ('../modules/application/src/application/models/deleteUserDB.php');
        require_once ('../modules/core/src/core/models/renderView.php');
        
        if($_POST)
        {
            if($_POST['submit']=='si')
            {
                //deleteUser($filename,$_POST['id']);
                deleteUserDB('users', $_POST['iduser'], $this->config);
            }
            // Saltar a select
            header('Location: /users');
        }
        else
        {
            $content = renderView($this->request, $this->config);
        }
        
        return $content;
    }
}

