<?php
include 'elems/init.php'; //Устанавливаем доступы к базе данных и др. настройки

function queryPageOnURI ($link, $where, $table='category', $param = '*', $all=false, $colName='uri') { //запрос всех данных страницы из таблицы
    $query = "SELECT $param FROM $table WHERE $colName='$where'";
    $result = mysqli_query($link, $query) or die( mysqli_error($link) );
    if ($all === true) {
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        return $data;
    } else {
        return mysqli_fetch_assoc($result); 
    }
}

function checkURI ($link, $uri, $table='category', $param='uri') { //запрос существования страницы в таблице
    $query = "SELECT COUNT(*) as count FROM $table WHERE $param='$uri'";
    $result = mysqli_query($link, $query) or die( mysqli_error($link) );
    return mysqli_fetch_assoc($result)['count']; //Преобразуем то, что отдала нам база из объекта в нормальный массив с одним значением и значение count
}

function uriLocation ($REQUEST_URI, $HTTP_HOST) {
    $arr = [];
    $arr['uriFULL'] = $REQUEST_URI; //URI: - atlas-for-man?page=11
    $arr['uriMini'] = preg_replace('#(\?.*)?#', '', $REQUEST_URI); //отрезаем в URI: всё что после (?) - atlas-for-man
    $arr['uriQuery'] = strstr($REQUEST_URI, '?'); //отрезаем URI: всё что после (?) - ?page=11
    if (strstr($HTTP_HOST, 'www.')) {
        $arr['uriWWW'] = explode ('.', $HTTP_HOST)[0]; //копируем www - www
        $arr['uriHOST'] = explode ('.', $HTTP_HOST)[1]; //копируем host без WWW - sanivelsql
    } else {
        $arr['uriHOST'] = $HTTP_HOST; //копируем host без WWW - sanivelsql
    }

    return $arr;
}

///////////////////////////////////////////////////////////////////////////////////
$uriLocation = '';

$arr = uriLocation ($_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST']);

//убираем www
if (isset($arr['uriWWW']) AND $arr['uriWWW'] === 'www') {
    $uriLocation = $prefhostHTTP.$arr['uriHOST'].$arr['uriFULL'];
    //$uriLocation = trim($uriLocation, '/');
    //header("Location: $uriLocation", true, 301);
}

//убираем слеш если есть
if (!empty($uriLocation)) {
    $arr = uriLocation ($arr['uriFULL'], $arr['uriHOST']);
    //убираем слеш
    if (empty($arr['uriMini'])) //если после отразания ни чего нет, то главная
        $uri = '/';
    elseif (substr($arr['uriFULL'], -1) === '/') {
        $arr['uriFULL'] = rtrim($arr['uriFULL'], '/');
        $uriLocation = $prefhostHTTP.$arr['uriHOST'].$arr['uriFULL'];
        //header("Location: $uriLocation", true, 301);
    }
} else {    
    if (empty($arr['uriMini'])) //если после отразания ни чего нет, то главная
        $uri = '/';
    elseif (substr($arr['uriFULL'], -1) === '/') {
        $arr['uriFULL'] = rtrim($arr['uriFULL'], '/');
        $uriLocation = $prefhostHTTP.$arr['uriHOST'].$arr['uriFULL'];
        //header("Location: $uriLocation", true, 301);
    }
}

echo "<pre>";
print_r($uriLocation);
echo "</pre>";

//убираем слеш
/*if (empty($uri)) //если после отразания ни чего нет, то главная
    $uri = '/';
elseif (substr($_SERVER['REQUEST_URI'], -1) === '/') {
//elseif (substr($_SERVER['REQUEST_URI'], -1) === '/' AND strstr($_SERVER['REQUEST_URI'], '?') == '') {
    //$uriLocation = $prefhostHTTP.$hostHTTP.$_SERVER['REQUEST_URI'];
    $uriLocation = $prefhostHTTP.$hostHTTP.'/'.$uri.$uriQuery;
    $uriLocation = rtrim($uriLocation, '/');
    header("Location: $uriLocation", true, 301);
}*/

/*if ($uri == '/') { //если главная
    $flag = 'main';
} else { //если не главная
    $uriArr = explode ("/", $uri);
    if (count($uriArr) == 1 AND $uriArr[0] === 'search') { //если первый уровень
        $flag = 'search';
    } elseif (count($uriArr) == 1 AND checkURI($link, $uriArr[0])) { //если первый уровень
        $flag = 'category';
    } elseif (count($uriArr) == 2) { //если второй уровень
        if (checkURI($link, $uriArr[0]) AND checkURI($link, "{$uriArr[0]}/{$uriArr[1]}", 'product')) {
            $flag = 'product';
        } else {
            $flag = '404';
        }
    } elseif (count($uriArr) == 4 AND $uriArr[0] === 'cart' AND 
                ($uriArr[3] === 'photoinproduct' || $uriArr[3] === 'morephoto' || 
                $uriArr[3] === 'buybutton' || $uriArr[3] === 'readmore' || $uriArr[3] === 'othercolors' || $uriArr[3] === 'othersizes')) {
            if (checkURI($link, $uriArr[1], 'category', 'uri') AND checkURI($link, "{$uriArr[1]}/{$uriArr[2]}", 'product')) {
                $flag = 'cpa';
            } else {
                $flag = '404';
            }
    } else { //если больше второго уровня
        $flag = '404';
    }
}

switch ($flag) {
    case 'main':
        //$start = microtime(true); //начало времени выполнения скрипта
        $page = queryPageOnURI($link, $uri, 'page');
        include 'elems/mainForLayout.php';
        include 'elems/layout.php';
        //echo '<p>Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.</p>'; //конец времени выполнения скрипта
        break;
    case 'category':
        //$start = microtime(true); //начало времени выполнения скрипта
        $page = queryPageOnURI($link, $uriArr[0]);
        include 'elems/categoryForLayout.php';
        include 'elems/layout.php';
        //echo '<p>Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.</p>'; //конец времени выполнения скрипта
        break;
    case 'product':
        //$start = microtime(true); //начало времени выполнения скрипта
        $page = queryPageOnURI($link, "{$uriArr[0]}/{$uriArr[1]}", 'product');
        $other_online_stores = queryPageOnURI($link, $page['id'], 'other_online_stores', 'other_online_stores', false, 'product_id');
        $similar_products = queryPageOnURI($link, $page['id'], 'similar_products', 'similar_products', false, 'product_id');
        $cat = queryPageOnURI($link, $uriArr[0], 'category');
        include 'elems/productForLayout.php';
        include 'elems/layout.php';
        //echo '<p>Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.</p>'; //конец времени выполнения скрипта
        break;
    case 'cpa':
        include 'elems/cartForLayout.php';
        include 'elems/layout.php';
        break;
    case 'search':
        include 'elems/searchForLayout.php';
        include 'elems/layout.php';
        break;
    default:
        $page = queryPageOnURI($link, '404', 'page');
        header("HTTP/1.0 404 Not Found");
        include 'elems/layout_404.php';
        break;
}*/