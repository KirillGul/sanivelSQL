<?php
function search ($link, $query) { 
    $query = trim($query); 
    $query = mysqli_real_escape_string($link, $query);
    $query = htmlspecialchars($query);

    if (!empty($query)) { 
        if (strlen($query) < 3) {
            $text = '<p>Слишком короткий поисковый запрос.</p>';
        } else if (strlen($query) > 128) {
            $text = '<p>Слишком длинный поисковый запрос.</p>';
        } else { 
            $q = "SELECT `uri`, `name`, `price`, `oldprice`, `picture`, `vendorcode` FROM `product` WHERE `name` LIKE '%$query%' OR `vendorcode` LIKE '%$query%'";

            $result = mysqli_query($link, $q) or die( mysqli_error($link) );
            for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

            if (mysqli_affected_rows($link) > 0) {
                $row = mysqli_fetch_assoc($result); 
                $num = mysqli_num_rows($result);

                $text = '<p>По запросу <b>'.$query.'</b> найдено совпадений: '.$num.'</p>';

                $catClear = 1;
                foreach ($data as $pagePartProduct) {
                    $pagePartProductURI = $pagePartProduct['uri'];
                    $pagePartProductName = $pagePartProduct['name'];
                    $pagePartProductPrice = $pagePartProduct['price'];
                    $pagePartProductOldprice = $pagePartProduct['oldprice'];
                    $pagePartProductPicture = $pagePartProduct['picture'];
                    $pagePartProductVendorcode = $pagePartProduct['vendorcode'];
    
                    $text .= '<div class="tovar smtovar mtop10">';
                        if (isset($pagePartProductOldprice) AND $pagePartProductOldprice == TRUE) {
                            $text .= '<div class="discount">';
                        }
                        if (isset($pagePartProductOldprice) AND $pagePartProductOldprice == TRUE) {
                            $text .= '-';
                            $text .= round((100*($pagePartProductOldprice -$pagePartProductPrice))/$pagePartProductOldprice, 0); 
                            $text .= '%</div>';
                        }
                        $text .= '<div class="image camera">';
                            $text .= "<a href=\"/$pagePartProductURI\">";
                                $Part10temp = explode('&-&-&', $pagePartProductPicture);
                                $pagePartProductPicture = $Part10temp[0];
                                $text .= "<img src=\"$pagePartProductPicture\" alt=\"Картинка - $pagePartProductName $pagePartProductVendorcode\" onload=\"goodLoadImg(this);\" onerror=\"errLoadImg(this);\">";
                            $text .= '</a>';
                        $text .= '</div>';
                        $text .= '<div class="name">';
                            $text .= "<a href=\"/$pagePartProductURI\">$pagePartProductName $pagePartProductVendorcode</a>";
                        $text .= '</div>';
                        $text .= '<div>';
                            $text .= '<span class="price">';
                                $text .= number_format($pagePartProductPrice, 0, "", " ");
                                $text .= ' р.</span>';
                                if (isset($pagePartProductOldprice) AND $pagePartProductOldprice == TRUE) {
                                    $text .= "<span class=\"oldprice\">$pagePartProductOldprice р.</span>";
                                }
                        $text .= '</div>';
                    $text .= '</div>';
                    
                    //разделить
                    if ($catClear % 7 == 0) { $text .= '<div class="clrb"></div>'; } 
                    $catClear++;
                }
            } else {
                $text = '<p>По вашему запросу ничего не найдено.</p>';
            }
        } 
    } else {
        $text = '<p>Задан пустой поисковый запрос.</p>';
    }

    return $text; 
}

$arrCity=array(1=>'Абакан','Альметьевск','Ангарск','Армавир','Архангельск','Астрахань','Балаково','Балашиха','Барнаул','Белгород','Березники','Бийск','Братск','Брянск','Великий Новгород','Владивосток','Владикавказ','Владимир','Волгоград','Волгодонск','Волжский','Вологда','Воронеж','Грозный','Дзержинск','Екатеринбург','Зеленоград','Златоуст','Иваново','Ижевск','Йошкар-Ола','Иркутск','Казань','Калининград','Калуга','Каменск-Уральский','Кемерово','Керчь','Киров','Ковров','Коломна','Колпино','Комсомольск-на-Амуре','Копейск','Королёв','Кострома','Краснодар','Красноярск','Курган','Курск','Липецк','Люберцы','Магнитогорск','Майкоп','Махачкала','Миасс','Москва','Мурманск','Мытищи','Набережные Челны','Нальчик','Находка','Нефтеюганск','Нижневартовск','Нижнекамск','Нижний Новгород','Нижний Тагил','Новокузнецк','Новороссийск','Новосибирск','Новочеркасск','Норильск','Одинцово','Омск','Орел','Оренбург','Орск','Пенза','Пермь','Петрозаводск','Петропавловск-Камчатский','Подольск','Прокопьевск','Псков','Пятигорск','Ростов-на-Дону','Рубцовск','Рыбинск','Рязань','Салават','Самара','Санкт-Петербург','Саранск','Саратов','Севастополь','Северодвинск','Симферополь','Смоленск','Сочи','Ставрополь','Старый Оскол','Стерлитамак','Сургут','Сызрань','Сыктывкар','Таганрог','Тамбов','Тверь','Тольятти','Томск','Тула','Тюмень','Улан-Удэ','Ульяновск','Уссурийск','Уфа','Хабаровск','Химки','Чебоксары','Челябинск','Череповец','Чита','Шахты','Электросталь','Энгельс','Южно-Сахалинск','Якутск','Ярославль');
if (empty($_COOKIE["city"])) {
    $city = 'РОССИЯ';
} else {
    $city = $arrCity[$_COOKIE["city"]];
}

$title = "<title>Поиск товаров: </title>";
$h1 = "<h1>Вы искали:";
if (!empty($_POST['searchText'])) {
    $h1 .= " ".$_POST['searchText'];
}
$h1 .= "</h1>";

$content = '';

$content .= '<p>';
    $content .= '<img src="/assets/reding2.gif" id="loadinggif">';
$content .= '</p>';

if (!empty($_POST['searchText'])) { 
    $search_result = search($link, $_POST['searchText']); 
    $content .= $search_result; 
}


$content .= '<!--/noindex--><script>$(document).ready(function(){ $("#loadinggif").delay(7000).fadeOut(); });</script>';


/*echo "<pre>";
print_r($page);
echo "</pre>";*/