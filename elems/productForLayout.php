<?php
//в массиве $page уже есть все значения товара найденные по uri
$available = $page['available'];
$prodName = $page['name'];
$prodURI = $page['uri'];
$vendorCode = $page['vendorcode'];
$vendor = $page['vendor'];
$price = $page['price'];
$oldprice = $page['oldprice'];
if (isset($oldprice) AND $oldprice == TRUE) $oldpriceSuf = 'со скидкой';
else $oldpriceSuf = '';
$picture = $page['picture'];
$dateProd = date('Y-m-d', $page['modified_time']);
//$groupid = $page['groupid'];
$param = $page['param'];
$descriptionProduct = $page['description'];
if (isset($similar_products) AND $similar_products == TRUE) $similar_products = $similar_products['similar_products'].'';
else $similar_products = '';
if (isset($other_online_stores) AND $other_online_stores == TRUE) $other_online_stores = $other_online_stores['other_online_stores'].'';
else $other_online_stores = '';
$pID = $page['id'];

$catID = $cat['id'];
$catName = ltrim($cat['name']);
$catURI = $cat['uri'];
$catCPAID = $cat[$hostHTTP];

$request_uri = $_SERVER['REQUEST_URI'];

$ReadMoreJS = '<script src="/assets/readmore.js" async="async"></script>';

//$title = "<title>$prodName $vendorCode, цена $price р., фото и отзывы</title>";
$title = "<title>ᐉ Купить【$prodName $vendorCode по цене от $price РУБ】со скидкой по самой низкой цене | &#9989; Сравнение цен и акции</title>";

//<meta name=\"description\" content=\"$prodName $vendorCode $oldpriceSuf за $price р. в интернет-магазине $catName. Купите недорого с доставкой. Смотрите фото, описание и характеристики.\">
$description = "
    <meta name=\"description\" content=\"&#11088;&#11088;&#11088;&#11088;&#11088; Скидки до 70% каждый день! В интернет магазине $catName - 100% Гарантия качества! Быстрый и безопасный онлайн шоппинг с $hostHTTP. Выбыраейте $prodName $vendorCode $oldpriceSuf за $price руб. - фото, описание и характеристики\">
    <link rel='canonical' href='$prefhostHTTP$hostHTTP$request_uri'>

	<meta property=\"og:title\" content=\"ᐉ Купить【$prodName $vendorCode по цене от $price РУБ】со скидкой по самой низкой цене | &#9989; Сравнение цен и акции\">
    <meta property=\"og:type\" content=\"product\">
    <meta property=\"og:site_name\" content=\"$hostHTTP\">
	<meta property=\"og:description\" content=\"\">
	<meta property=\"og:image\" content=\"$picture\">
    <meta property=\"og:image:type\" content=\"image/jpeg\">
	<meta property=\"og:url\" content=\"$prefhostHTTP$hostHTTP$request_uri\">
";

$itemscope = "
    <span itemscope itemtype=\"http://schema.org/Product\">
        <meta itemprop=\"name\" content=\"$prodName $vendorCode\">
        <meta itemprop=\"description\" content=\"&#11088;&#11088;&#11088;&#11088;&#11088; Скидки до 70% каждый день! В интернет магазине $catName - 100% Гарантия качества! Быстрый и безопасный онлайн шоппинг с $hostHTTP. Выбыраейте $prodName $vendorCode $oldpriceSuf за $price руб. - фото, описание и характеристики\">
        <meta itemprop=\"image\" content=\"$picture\">
        <meta itemprop=\"brand\" content=\"$vendor\">
        <meta itemprop=\"sku\" content=\"$vendorCode\">
        <meta itemprop=\"productID\" content=\"sku:$vendorCode\">
        <span itemprop=\"offers\" itemscope itemtype=\"http://schema.org/Offer\">
            <link itemprop=\"availability\" href=\"http://schema.org/InStock\">
            <meta itemprop=\"price\" content=\"$price\">
            <meta itemprop=\"priceCurrency\" content=\"RUB\">
            <meta itemprop=\"priceValidUntil\" content=\"$dateProd\">
        </span>
    </span>
";

$logo = "<a href=\"/$catURI/\"><img src=\"/images/logo/$catURI.jpg\" alt=\"$catName\"></a>";

$arrCity=array(1=>'Абакан','Альметьевск','Ангарск','Армавир','Архангельск','Астрахань','Балаково','Балашиха','Барнаул','Белгород','Березники','Бийск','Братск','Брянск','Великий Новгород','Владивосток','Владикавказ','Владимир','Волгоград','Волгодонск','Волжский','Вологда','Воронеж','Грозный','Дзержинск','Екатеринбург','Зеленоград','Златоуст','Иваново','Ижевск','Йошкар-Ола','Иркутск','Казань','Калининград','Калуга','Каменск-Уральский','Кемерово','Керчь','Киров','Ковров','Коломна','Колпино','Комсомольск-на-Амуре','Копейск','Королёв','Кострома','Краснодар','Красноярск','Курган','Курск','Липецк','Люберцы','Магнитогорск','Майкоп','Махачкала','Миасс','Москва','Мурманск','Мытищи','Набережные Челны','Нальчик','Находка','Нефтеюганск','Нижневартовск','Нижнекамск','Нижний Новгород','Нижний Тагил','Новокузнецк','Новороссийск','Новосибирск','Новочеркасск','Норильск','Одинцово','Омск','Орел','Оренбург','Орск','Пенза','Пермь','Петрозаводск','Петропавловск-Камчатский','Подольск','Прокопьевск','Псков','Пятигорск','Ростов-на-Дону','Рубцовск','Рыбинск','Рязань','Салават','Самара','Санкт-Петербург','Саранск','Саратов','Севастополь','Северодвинск','Симферополь','Смоленск','Сочи','Ставрополь','Старый Оскол','Стерлитамак','Сургут','Сызрань','Сыктывкар','Таганрог','Тамбов','Тверь','Тольятти','Томск','Тула','Тюмень','Улан-Удэ','Ульяновск','Уссурийск','Уфа','Хабаровск','Химки','Чебоксары','Челябинск','Череповец','Чита','Шахты','Электросталь','Энгельс','Южно-Сахалинск','Якутск','Ярославль');
if (empty($_COOKIE["city"])) {
    $city = 'РОССИЯ';
} else {
    $city = $arrCity[$_COOKIE["city"]];
}

$h1 = "<h1>$prodName $vendorCode</h1>";

$content = '';

$content .= '<div class="product">';
if (isset($oldprice) AND $oldprice == TRUE) {
    $content .= '<div class="discount2">-';
    $content .= round((100*($oldprice - $price))/$oldprice, 0);
    $content .= '%</div>';
}

    $content .= '<div class="bigimg camera">';
        $content .= "<a href=\"#\" rel=\"nofollow\" onclick=\"window.open('/cart/$prodURI/photoinproduct', '_blank'); return false\" data-href='/cart/$prodURI/photoinproduct' class=\"pointer outli\">";
            $content .= "<img src=\"$picture\" alt=\"Картинка - $prodName $vendorCode\" onload=\"goodLoadImg(this);\" onerror=\"errLoadImg(this);\">";
        $content .= '</a>';
        $content .= '<p class="readmore">';
            $content .= "<a href=\"#\" rel=\"nofollow\" onclick=\"window.open('/cart/$prodURI/morephoto', '_blank'); return false\" data-href='/cart/$prodURI/morephoto' class=\"pointer outli\">";
                $content .= '<span>ВСЕ ФОТО</span>';
            $content .= '</a>';
        $content .= '</p>';
    $content .= '</div>';
    $content .= '<div class="notes">';
        $content .= '<div class="oldprice">';
            if (isset($oldprice) AND $oldprice == TRUE) {
                $content .= "<span class=\"old\">$oldprice р.</span>";
                $raznica = $price - $oldprice;
                $content .= "<span class=\"disc\">СКИДКА: $raznica р.</span>";
            }
        $content .= '</div>';
        $content .= '<div class="price">';
            $content .= number_format($price, 0, "", " ");
            $content .= ' р.';
        $content .= '</div>';
        $content .= '<div class="buybutton">';
            $content .= "<a href=\"#\" rel=\"nofollow\" onclick=\"window.open('/cart/$prodURI/buybutton', '_blank'); return false\" data-href='</cart/$prodURI/buybutton' class=\"pointer outli\">";
                $content .= '<span >КУПИТЬ</span>';
            $content .= '</a>';
        $content .= '</div>';
        if (isset($vendor) AND $vendor == TRUE) {
            $content .= "<p class=\"details\">Производитель: $vendor</p>";
        }
        if (isset($vendorCode) AND $vendorCode == TRUE) { 
            $content .= "<p class=\"details\">Арт.: $vendorCode</p>";
        }
        $content .= '<ul class="adv">';
            if (isset($available) AND $available == 'true') {
                $content .= '<li class="active">В НАЛИЧИИ</li>';
                $content .= '<li class="active">В ТОРГОВОМ ЗАЛЕ</li>';
            } else {
                $content .= '<li class="active">НЕТ В НАЛИЧИИ</li>';
            }
            $content .= '<li class="active">ДОСТАВКА</li>';
            $content .= '<li class="active">САМОВЫВОЗ</li>';
            $content .= '<li class="active">ГАРАНТИЯ ПРОИЗВОДИТЕЛЯ</li>';
        $content .= '</ul>';
/*if ('[KEYPART-25]' != FALSE) { 
    $content .= "<p class="bonus">[KEYPART-25]</p>";
}
if ('[KEYPART-26]' != FALSE) { 
    $content .= "<p class="bonus">[KEYPART-26]</p>";
}*/
        if (isset($groupid) AND $groupid == TRUE) {
            $content .= "<p>PID: $groupid</p>";
        }
        $content .= '<p class="readmore">';
            $content .= "<a href=\"#\" rel=\"nofollow\" onclick=\"window.open('/cart/$prodURI/readmore', '_blank'); return false\" data-href='/cart/$prodURI/readmore' class=\"pointer outli\">";
                $content .= '<span>ПОДРОБНЕЕ</span>';
            $content .= '</a>';
        $content .= '</p>';
        //$content .= '<script src="http://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>';
        $content .= '<script src="https://yastatic.net/share2/share.js"></script>';        
        $content .= '<div class="ya-share2" data-services="collections,vkontakte,facebook,odnoklassniki,moimir,twitter,viber,whatsapp,telegram" data-counter=""></div>';
    $content .= '</div>';
    $content .= '<div class="clrb"></div>';
    $content .= '<a id="others"></a>';
    $content .= '<div class="description">';
    
    if ($param == TRUE) {
        $content .= '<h2>Характеристики</h2>';
        $parameters = explode('&-&-&', trim($param, '&-&-&'));
        $count_parameters = count($parameters);
        if ($count_parameters <= 1) list($table1) = array_chunk($parameters, ceil($count_parameters/2));
        else list($table1, $table2) = array_chunk($parameters, ceil($count_parameters/2));

        if (isset($table1) AND count($table1) > 0) {
        $content .= '<table class="params params2">';
            
            foreach ($table1 as $value) {
                $arr = explode (":", $value);
                $content .= '<tr>';
                $content .= "<td>{$arr[0]}</td>";
                $content .= '<td>';
                    $content .= $arr[1];
                    if ($arr[0] == 'Цвет') { 
                        $content .= '<span class="othprms">';
                            $content .= "<a href=\"#\" rel=\"nofollow\" onclick=\"window.open('/cart/$prodURI/othercolors', '_blank'); return false\" data-href='/cart/$prodURI/othercolors' class=\"pointer outli\">+все цвета</a>";
                        $content .= '</span>';
                    }
                    if ($arr[0] == 'Размер') { 
                        $content .= '<span class="othprms">';
                            $content .= "<a href=\"#\" rel=\"nofollow\" onclick=\"window.open('/cart/$prodURI/othercolors', '_blank'); return false\" data-href='/cart/$prodURI/othercolors' class=\"pointer outli\">+все размеры</a>";
                        $content .= '</span>';
                    }
                $content .= '</td>';
            }
            $content .= '</tr></table>';
        }
        
        
        if (isset($table2) AND count($table2) > 0) {
            $content .= '<table class="params params2">';

            foreach ($table2 as $value) {
                $arr1 = explode (":", $value);
                $content .= '<tr>';
                    $content .= "<td>{$arr1[0]}</td>";
                    $content .= '<td>';
                        $content .= $arr1[1];
                        if ($arr1[0] == 'Цвет') {
                            $content .= '<span class="othprms">';
                                $content .= "<a href=\"#\" rel=\"nofollow\" onclick=\"window.open('/cart/$prodURI/othercolors', '_blank'); return false\" data-href='/cart/$prodURI/othercolors' class=\"pointer outli\">+все цвета</a>";
                            $content .= '</span>';
                        }
                        if ($arr1[0] == 'Размер') {
                            $content .= '<span class="othprms">';
                                $content .= "<a href=\"#\" rel=\"nofollow\" onclick=\"window.open('/cart/$prodURI/othercolors', '_blank'); return false\" data-href='/cart/$prodURI/othercolors' class=\"pointer outli\">+все размеры</a>";
                            $content .= '</span>';
                        }
                    $content .= '</td>';
            }
            $content .= '</tr></table>';
        }            
        $content .= '<div class="clrb"></div>';
    }
    $content .= '<h2>Описание</h2>';
    if ($descriptionProduct != FALSE) {
        $content .= "<p>$descriptionProduct</p>";
    }
    $content .= "<p>В интернет-магазине \"$catName\" вы можете купить $prodName $vendorCode недорого";
    if (isset($oldprice) AND $oldprice == TRUE) {
        $content .= "со скидкой $raznica р. ";
    }
    $content .= "по цене $price р. Также ознакомьтесь с другими предложениям бренда $vendor.</p>";

    if (!empty($similar_products) AND $similar_products != '') {
        $similar_products = explode(';', rtrim($similar_products, ';'));
        $content .= '<h3>Похожие товары</h3>';
    
        //var_dump($similar_products);
    
        foreach ($similar_products as $idPartProduct) {
            $query = "SELECT uri, name, price, oldprice, picture FROM product WHERE id='$idPartProduct'";
            $result = mysqli_query($link, $query) or die( mysqli_error($link) );
            $pagePartProduct = mysqli_fetch_assoc($result);
    
            $pagePartProductURI = $pagePartProduct['uri'];
            $pagePartProductName = $pagePartProduct['name'];
            $pagePartProductPrice = $pagePartProduct['price'];
            $pagePartProductOldprice = $pagePartProduct['oldprice'];
            $pagePartProductPicture = $pagePartProduct['picture'];
    
            $content .= '<div class="tovar smtovar mtop10">';
                if (isset($pagePartProductOldprice) AND $pagePartProductOldprice == TRUE) {
                    $content .= '<div class="discount">';
                }
                if (isset($pagePartProductOldprice) AND $pagePartProductOldprice == TRUE) {
                    $content .= '-';
                    $content .= round((100*($pagePartProductOldprice -$pagePartProductPrice))/$pagePartProductOldprice, 0); 
                    $content .= '%</div>';
                }
                $content .= '<div class="image camera">';
                    $content .= "<a href=\"/$pagePartProductURI\">";
                        $Part10temp = explode('&-&-&', $pagePartProductPicture);
                        $pagePartProductPicture = $Part10temp[0];
                        $content .= "<img src=\"$pagePartProductPicture\" alt=\"Картинка - $pagePartProductName\" onload=\"goodLoadImg(this);\" onerror=\"errLoadImg(this);\">";
                    $content .= '</a>';
                $content .= '</div>';
                $content .= '<div class="name">';
                    $content .= "<a href=\"/$pagePartProductURI\">$pagePartProductName</a>";
                $content .= '</div>';
                $content .= '<div>';
                    $content .= '<span class="price">';
                        $content .= number_format($pagePartProductPrice, 0, "", " ");
                    $content .= ' р.</span>';
                    if (isset($pagePartProductOldprice) AND $pagePartProductOldprice == TRUE) {
                        $content .= "<span class=\"oldprice\">$pagePartProductOldprice р.</span>";
                    }
                $content .= '</div>';
            $content .= '</div>';
        }
    
        $content .= '<div class="clrb"></div>';
        $content .= '<hr>';
    }
    
    /*$content .= '<p>Другие товары</p>';
    <div class="gtt">
        {REPEAT-4-4}
        {PUNIQCATRANDKEYWORD}
        <a href="[URL]">&gt;</a>
        {/PUNIQCATRANDKEYWORD}
        {/REPEAT}
    </div>
    <div class="clrb"></div>
    <hr color="white">*/
    
    if ($other_online_stores != '') {
        $other_online_stores = explode(';', rtrim($other_online_stores, ';'));
        $content .= '<h3>Другие интернет-магазины:</h3>';
        $content .= '<div class="mgs mtop10">';
    
        foreach ($other_online_stores as $idPartProduct) {
            
            $query = "SELECT uri, name FROM category WHERE id='$idPartProduct'";
            $result = mysqli_query($link, $query) or die( mysqli_error($link) );
            $pagePartProduct = mysqli_fetch_assoc($result);
    
            $pagePartProductURI = $pagePartProduct['uri'];
            $pagePartProductName = $pagePartProduct['name'];
    
            
                $content .= "<div class=\"mg\"><a href=\"/$pagePartProductURI/\">";
                    $content .= "<img src=\"/images/logo/$pagePartProductURI.jpg\" alt=\"$pagePartProductName\" style=\"width:143px\" onload=\"goodLoadImg(this);\" onerror=\"errLoadImg(this);\">";
                $content .= '</a></div>';
            
        }
    
        $content .= '</div>';
        $content .= '<div class="clrb"></div>';
        $content .= '<hr>';
    
    }

    $content .= '<h2>Доставка</h2>';
    $content .= '<p>Доставка товара осуществляется транспортными компаниями до пунктов выдачи в вашем городе, а также по указанному при заказе адресу курьером. Итоговая стоимость доставки отобразится при оформлении заказа после заполния формы с адресом.</p>';
    $content .= '<h2>Отзывы</h2>';
    $content .= "<p>Отзывы о \"$prodName\" помогут вам лучше изучить качество товара и принять правильное решение о покупке.</p>";
    $content .= '<p>На данный момент еще никто не оставил свой отзыв. Вы можете быть первым.</p>';
    $content .= '<p><a href="#" class="moredescription">+ Написать отзыв</a></p>';
    $content .= '<p>Актуальность: ';
        $content .= $dateProd;
    $content .= '</p>';
    $content .= '</div>';
    $content .= '<script>$(".description").readmore({maxHeight: 700, moreLink: "<a href=\"#\" class=\"moredescription\">+ Смотреть</a>", lessLink: "<a href=\"#\" class=\"moredescription\">- Скрыть</a>"});</script>';
    $content .= '<hr>';
$content .= '</div>';

setcookie("cat", $catName, 0, "/cart/$prodURI", '', true);
setcookie("productName", "$prodName $vendorCode", 0, "/cart/$prodURI", '', true);
$prodURL = $page['produrl'];
setcookie("link", $prodURL, 0, "/cart/$prodURI", '', true);
setcookie("catCPAID", $catCPAID, 0, "/cart/$prodURI", '', true);
setcookie("productImage", $picture, 0, "/cart/$prodURI", '', true);

/*echo "<pre>";
print_r($_SERVER);
echo "</pre>";*/