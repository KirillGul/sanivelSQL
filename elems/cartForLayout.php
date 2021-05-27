<?php
$arrCity=array(1=>'Абакан','Альметьевск','Ангарск','Армавир','Архангельск','Астрахань','Балаково','Балашиха','Барнаул','Белгород','Березники','Бийск','Братск','Брянск','Великий Новгород','Владивосток','Владикавказ','Владимир','Волгоград','Волгодонск','Волжский','Вологда','Воронеж','Грозный','Дзержинск','Екатеринбург','Зеленоград','Златоуст','Иваново','Ижевск','Йошкар-Ола','Иркутск','Казань','Калининград','Калуга','Каменск-Уральский','Кемерово','Керчь','Киров','Ковров','Коломна','Колпино','Комсомольск-на-Амуре','Копейск','Королёв','Кострома','Краснодар','Красноярск','Курган','Курск','Липецк','Люберцы','Магнитогорск','Майкоп','Махачкала','Миасс','Москва','Мурманск','Мытищи','Набережные Челны','Нальчик','Находка','Нефтеюганск','Нижневартовск','Нижнекамск','Нижний Новгород','Нижний Тагил','Новокузнецк','Новороссийск','Новосибирск','Новочеркасск','Норильск','Одинцово','Омск','Орел','Оренбург','Орск','Пенза','Пермь','Петрозаводск','Петропавловск-Камчатский','Подольск','Прокопьевск','Псков','Пятигорск','Ростов-на-Дону','Рубцовск','Рыбинск','Рязань','Салават','Самара','Санкт-Петербург','Саранск','Саратов','Севастополь','Северодвинск','Симферополь','Смоленск','Сочи','Ставрополь','Старый Оскол','Стерлитамак','Сургут','Сызрань','Сыктывкар','Таганрог','Тамбов','Тверь','Тольятти','Томск','Тула','Тюмень','Улан-Удэ','Ульяновск','Уссурийск','Уфа','Хабаровск','Химки','Чебоксары','Челябинск','Череповец','Чита','Шахты','Электросталь','Энгельс','Южно-Сахалинск','Якутск','Ярославль');
if (empty($_COOKIE["city"])) {
    $city = 'РОССИЯ';
} else {
    $city = $arrCity[$_COOKIE["city"]];
}

$metaCartRefrash = '<meta name="robots" content="noindex, nofollow">';

/////////////////////////////////////////////////////////////////////////////////////////////////////

$uriRequest = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //ссылка по которой перешёл
$segmentsRequ = explode('/', trim($uriRequest, '/')); //массив из частей ссыылки по которой перешёл

$uriNoHttp = explode($prefhostHTTP, $_SERVER['HTTP_REFERER']); //откуда перешёл без HTTP(S)

$uriArrProdCPA = explode('?', $_COOKIE["link"]); //массив из CPA ссылки товара в базе

//обработка 1 части CPA ссылки
$uriCPA = $uriArrProdCPA[0].'';
$uriCPA = explode('/', $uriCPA);

$HTTP_USER_AGENT = urlencode($_SERVER['HTTP_USER_AGENT']); //нужно для Teleport API
$HTTP_REFERER = urlencode($_SERVER['HTTP_REFERER']); //нужно для Teleport API
$ip_addr = $_SERVER['REMOTE_ADDR']; //нужно для Teleport API

//если можно узнать IP то Teleport иначе по старинке
if (!empty($ip_addr) AND $ip_addr != '0.0.0.0'  AND $ip_addr != '127.0.0.1') {
    $flagIP = 1;
    $ip_addr = 'ip_addr='.$ip_addr;
    //$k = "http://ip-api.com/php/188.191.25.3";
    //$ip_addr = file_get_contents($k);
    //$ip_addr = json_decode($infoMeta, true);
    //или
    //$ip_addr = 'country_code=RU';
    $uriCPA0123tpt = "{$uriCPA[0]}//{$uriCPA[2]}/tpt/"; //кусок ссылки для Teleport API
    $uriCPA0123g = "{$uriCPA[0]}//{$uriCPA[2]}/g/"; //обычный кусок ссылки без Teleport API
} else {
    $flagIP = 0;
    $uriCPA0123g = "{$uriCPA[0]}//{$uriCPA[2]}/g/"; //обычный кусок ссылки без Teleport API
}

//если один сайт (обыно, надёжно)
    //$k1 = "{$uriArrProdCPA[0]}?subid={$uriNoHttp[1]}&subid1={$segmentsRequ[3]}&{$uriArrProdCPA[1]}";
    //$metaCartRefrash .= "<META HTTP-EQUIV=REFRESH CONTENT=\"0; URL=$k1\">";
//если один сайт (Teleport API)

//если несколько сайтов (Teleport API и обычный)
if ($flagIP == 0) { //если не определился IP (обыно, надёжно)
    //если несколько сайтов
    $k1 = "$uriCPA0123g{$_COOKIE['catCPAID']}/?subid={$uriNoHttp[1]}&subid1={$segmentsRequ[3]}&{$uriArrProdCPA[1]}";
    $metaCartRefrash .= "<META HTTP-EQUIV=REFRESH CONTENT=\"0; URL=$k1\">";
} else {
    //если несколько сайтов новая метода
    $k1 = "$uriCPA0123g{$_COOKIE['catCPAID']}/?subid={$uriNoHttp[1]}&subid1={$segmentsRequ[3]}&{$uriArrProdCPA[1]}";
    $k = "$uriCPA0123tpt{$_COOKIE['catCPAID']}/?$ip_addr&user_agent=$HTTP_USER_AGENT&referer=$HTTP_REFERER&subid={$uriNoHttp[1]}&subid1={$segmentsRequ[3]}&{$uriArrProdCPA[1]}";
    $infoMeta = file_get_contents($k);
    $infoMeta = json_decode($infoMeta, true);
    if (isset($infoMeta['error'])) {
        $metaCartRefrash .= "<META HTTP-EQUIV=REFRESH CONTENT=\"0; URL=$k1\">";
    } else {
        print_r($infoMeta);
        $metaCartRefrash .= "<META HTTP-EQUIV=REFRESH CONTENT=\"0; URL={$infoMeta[0]}\">";
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////

$title = '<title>Корзина заказов</title>';
$h1 = "<h1>Корзина заказов</h1>";

$content = '';

$content .= "<a href=\"$k1\">";
    $content .= "<img src=\"".$_COOKIE["productImage"]."\" class=\"redirimage\">";
$content .= "</a>";

$content .= '<div class="redirdiv">';
    $content .= "<p>Сейчас происходит переход на сайт интернет-магазина '".$_COOKIE["cat"]."', где Вы сможете более подробнее ознакомиться с '".$_COOKIE["productName"]."'.</p>";
    $content .= '<p>Если вы не хотите ждать, то ';
        $content .= "<b><a href=\"$k1\">скорее жмите сюда</a></b>.";
    $content .= '</p>';
    $content .= '<p>';
        $content .= '<img src="/assets/reding2.gif">';
    $content .= '</p>';
$content .= '</div>';
$content .= '<div style="widht:100%;height:300px;"></div>';

/*echo "<pre>";
print_r($k1);
echo "</pre>";*/