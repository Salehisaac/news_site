<?php

//session start
session_start();

//config
define('BASE_PATH', __DIR__);
define('CURRENT_DOMAIN', currentDomain() . '/project/');
define('DISPLAY_ERROR', true);
define('DB_HOST', 'localhost');
define('DB_NAME', 'project');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');


require_once 'database/DataBase.php';
require_once 'database/CreateDB.php';
require_once 'activities/Admin/Admin.php';
require_once 'activities/Admin/Category.php';
require_once 'activities/Admin/Post.php';


/*$db1 = new database\Database();*/
/*$db = new database\CreateDB();*/
/*exit();*/


//helpers

function uri($resevedUrl, $class, $method, $requestMethod = 'GET')
{
//current url array
    $currentUrl = explode('?', currentUrl()) [0];
    $currentUrl = str_replace(CURRENT_DOMAIN, '', $currentUrl);
    $currentUrl = trim($currentUrl, '/');
    $currentUrlArray = explode('/', $currentUrl);
    $currentUrlArray = array_filter($currentUrlArray);

//reseved url array
    $resevedUrl = trim($resevedUrl, '/');
    $resevedUrlArray = explode('/', $resevedUrl);
    $resevedUrlArray = array_filter($resevedUrlArray);

    if (sizeof($currentUrlArray) != sizeof($resevedUrlArray) || methodField() != $requestMethod) {
        return false;
    }

    $parameters = [];
    for ($key = 0; $key < sizeof($resevedUrlArray); $key++) {
        if ($resevedUrlArray[$key][0] == '{' && $resevedUrlArray[$key][strlen($resevedUrlArray[$key]) - 1] == '}') {
            array_push($parameters, $currentUrlArray[$key]);
        } else if ($resevedUrlArray[$key] !== $currentUrlArray[$key]) {
            return false;
        }
    }

    if (methodField() == 'POST') {
        $request = isset($_FILES) ? array_merge($_POST, $_FILES) : $_POST;
        $parameters = array_merge([$request], $parameters);
    }

    $object = new $class;
    call_user_func_array([$object, $method], $parameters);
    exit();


}

/*uri('home','HomeController','index');*/

function protocol()
{
    return stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
}

function currentDomain()
{

    $domain = $_SERVER['HTTP_HOST'];
    return protocol() . $domain;
}


function asset($path)
{
    $domain = trim(CURRENT_DOMAIN, '/');
    $path = $domain . '/' . trim($path, '/');
    return $path;

}

function url($path)
{
    $domain = trim(CURRENT_DOMAIN, '/');
    $path = $domain . '/' . trim($path, '/');
    return $path;
}

function currentUrl()
{
    return currentDomain() . $_SERVER['REQUEST_URI'];
}

function redirect($path)
{
    header('Location: ' . url($path));
    exit;
}

function methodField()
{
    return $_SERVER['REQUEST_METHOD'];
}

function displayError($displayError)
{
    if ($displayError) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
}

displayError(DISPLAY_ERROR);

global $flashMessage;
if (isset($_SESSION['flashMessage'])) {
    $flashMessage = $_SESSION['flashMessage'];
    unset($_SESSION['flashMessage']);
}

function flash($key, $value = null)
{
    if ($value === null) {
        global $flashMessage;
        $message = isset($flashMessage[$key]) ? $flashMessage[$key] : null;
        return $message;
    } else {
        $_SESSION['flashMessage'][$key] = $value;
    }
}

function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die;
}
//category
uri('admin/category', 'Admin\Category', 'index');
uri('admin/category/create', 'Admin\Category', 'create');
uri('admin/category/store', 'Admin\Category', 'store', 'POST');
uri('admin/category/edit/{id}', 'Admin\Category', 'edit');
uri('admin/category/update/{id}', 'Admin\Category', 'update', 'POST');
uri('admin/category/delete/{id}', 'Admin\Category', 'delete');
//posts
uri('admin/post', 'Admin\Post', 'index');
uri('admin/post/create', 'Admin\Post', 'create');
uri('admin/post/store', 'Admin\Post', 'store', 'POST');
uri('admin/post/edit/{id}', 'Admin\Post', 'edit');
uri('admin/post/update/{id}', 'Admin\Post', 'update', 'POST');
uri('admin/post/delete/{id}', 'Admin\Post', 'delete');

echo '404 not found';
