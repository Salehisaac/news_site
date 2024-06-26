<?php

//session start
session_start();

use Auth\Auth;

//config
define('BASE_PATH', __DIR__);
define('CURRENT_DOMAIN', currentDomain() . '/project/');
define('DISPLAY_ERROR', true);
define('DB_HOST', 'localhost');
define('DB_NAME', 'project');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

//mail
define('MAIL_HOST', 'smtp-mail.outlook.com');
define('SMTP_AUTH', true);
define('MAIL_USERNAME', 'shampooo12345678910@outlook.com');
define('MAIL_PASSWORD', '@Yakuza1234567');
define('MAIL_PORT', 587);
define('SENDER_MAIL', 'shampooo12345678910@outlook.com');
define('SENDER_NAME', 'سایت خبری معماری کامپیوتر');




//admin
require_once 'database/DataBase.php';
require_once 'database/CreateDB.php';
require_once 'activities/Admin/Admin.php';
require_once 'activities/Admin/Category.php';
require_once 'activities/Admin/Post.php';
require_once 'activities/Admin/Banner.php';
require_once 'activities/Admin/User.php';
require_once 'activities/Admin/Comment.php';
require_once 'activities/Admin/Menu.php';
require_once 'activities/Admin/Websetting.php';
require_once 'activities/Admin/Dashboard.php';

//auth
require_once 'activities/Auth/Auth.php';


//app
require_once 'activities/App/Home.php';




/*$db1 = new database\Database();*/
/*$db = new database\CreateDB();*/
/*exit();*/


//helpers


spl_autoload_register(function ($className){
    $path = BASE_PATH . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
    include $path . $className . '.php' ;
});


/*$auth = new Auth();
$auth->sendMail('shampooo12345678910@outlook.com','test','<p>test</p>' );
exit();*/

function jalaliDate($date){
    return Parsidev\Jalali\Jdate::forge($date)->format('%A, %d %B %y');
}



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




//dashboard
uri('admin', 'Admin\Dashboard', 'index');

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
uri('admin/post/selected/{id}', 'Admin\Post', 'selected');
uri('admin/post/breakingNews/{id}', 'Admin\Post', 'breakingNews');
//banners
uri('admin/banner', 'Admin\banner', 'index');
uri('admin/banner/create', 'Admin\banner', 'create');
uri('admin/banner/store', 'Admin\banner', 'store', 'POST');
uri('admin/banner/edit/{id}', 'Admin\banner', 'edit');
uri('admin/banner/update/{id}', 'Admin\banner', 'update', 'POST');
uri('admin/banner/delete/{id}', 'Admin\banner', 'delete');
uri('admin/banner/selected/{id}', 'Admin\banner', 'selected');
uri('admin/banner/breakingNews/{id}', 'Admin\banner', 'breakingNews');

//useres
uri('admin/user', 'Admin\User', 'index');
uri('admin/user/edit/{id}', 'Admin\User', 'edit');
uri('admin/user/delete/{id}', 'Admin\User', 'delete');
uri('admin/user/update/{id}', 'Admin\User', 'update', 'POST');
uri('admin/user/permission/{id}', 'Admin\User', 'permission');

//comments
uri('admin/comment', 'Admin\Comment', 'index');
uri('admin/comment/change/{id}', 'Admin\Comment', 'change');

//menu
uri('admin/menu', 'Admin\Menu', 'index');
uri('admin/menu/create', 'Admin\Menu', 'create');
uri('admin/menu/store', 'Admin\Menu', 'store', 'POST');
uri('admin/menu/edit/{id}', 'Admin\Menu', 'edit');
uri('admin/menu/update/{id}', 'Admin\Menu', 'update', 'POST');
uri('admin/menu/delete/{id}', 'Admin\Menu', 'delete');

//websetting
uri('admin/websetting', 'Admin\Websetting', 'index');
uri('admin/websetting/edit', 'Admin\Websetting', 'edit');
uri('admin/websetting/update', 'Admin\Websetting', 'update', 'POST');

//auth
uri('register', 'Auth\Auth', 'register');
uri('register/store', 'Auth\Auth', 'registerStore' , 'POST');

uri('login', 'Auth\Auth', 'login');
uri('check-login', 'Auth\Auth', 'checkLogin' , 'POST');
uri('logout', 'Auth\Auth', 'logout'  );
uri('forgot', 'Auth\Auth', 'forgot'  );
uri('forgot/request', 'Auth\Auth', 'forgotRequest', 'POST'  );
uri('reset-password-form/{forgot_token}', 'Auth\Auth', 'resetPasswordView');
uri('reset-password/{forgot_token}', 'Auth\Auth', 'resetPassword', 'POST');


//app

uri('/', 'App\Home', 'index'  );
uri('/home', 'App\Home', 'index'  );
uri('/show-post/{id}', 'App\Home', 'show'  );
uri('/show-category/{id}', 'App\Home', 'category'  );
uri('/comment-store/{post_id}', 'App\Home', 'commentStore', 'POST'  );

echo '404 not found';
