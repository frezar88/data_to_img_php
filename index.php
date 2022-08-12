<?php
$data = array(); // Генерация демонстрационных данных
for ($i = 0; $i < 10; $i++) {
    $data[] = [
        'nice_name' => 'Имя теста ' . $i,
        'zhuang' => 100,
        'xian' => 50,
        'he' => 50,
        'zhuang_dui' => 500,
        'xian_dui' => 15000,
    ];
}

$params = [
    'row' => 11, // Количество строк данных
    'file_name' => 'img.jpeg',
    'title' => 'Контрольный список данных',
    'table_time' => date("m.d.y"),
    'data' => $data
];
$base = [
    'border' => 0, // Внешняя граница картинки
//    'file_path' => '/var/www/my_site/GD_PHP/', // путь для сохранения изображения
    'file_path' => '/var/www/my_site/GD_PHP/img/', // путь для сохранения изображения
    'title_height' => 30, // Высота имени отчета
    'title_font_size' => 16, // Размер шрифта имени отчета
    'font_ulr' => './Roboto-Bold.ttf', // путь к файлу шрифта
    'text_size' => 12, // Размер шрифта текста
    'row_hight' => 30, // Высота каждой строки данных
    'filed_id_width' => 160, // Ширина столбца серийного номера
    'filed_name_width' => 120, // Ширина имени игрока
    'filed_data_width' => 100, // Ширина столбца данных
    'table_header' => ['серийный номер', 'никнейм', 'данные 1', 'данные 2', 'данные 3', 'данные 4', 'данные 5'], // текст заголовка таблицы
    'column_text_offset_arr' => [155, 90, 85, 85, 85, 85, 85], // Смещение текста заголовка влево
    'row_text_offset_arr' => [50, 110, 90, 90, 90, 90, 90], // Смещение текста столбца данных влево
];

$base ['img_width'] = $base['filed_id_width'] + $base['filed_name_width'] + $base['filed_data_width'] * 5 + $base['border'] * 2; // ширина изображения
$base ['img_height'] = $params['row'] * $base['row_hight'] + $base['border'] * 2 + $base['title_height']; // высота изображения
$border_top = $base['border'] + $base['title_height']; // высота столешницы
$border_bottom = $base['img_height'] - $base['border']; // высота низа формы
$base['column_x_arr'] = [
    $base['border'] + $base['filed_id_width'], // пиксели оси x первой линии границы столбца
    $base['border'] + $base['filed_id_width'] + $base['filed_name_width'], // пиксели оси x линии границы второго столбца
    $base['border'] + $base['filed_id_width'] + $base['filed_name_width'] + $base['filed_data_width'] * 1, // Пиксели оси x линии границы третьего столбца
    $base['border'] + $base['filed_id_width'] + $base['filed_name_width'] + $base['filed_data_width'] * 2, // Пиксели оси x линии границы четвертого столбца
    $base['border'] + $base['filed_id_width'] + $base['filed_name_width'] + $base['filed_data_width'] * 3, // Пиксели оси x линии границы пятого столбца
    $base['border'] + $base['filed_id_width'] + $base['filed_name_width'] + $base['filed_data_width'] * 4, // Пиксели оси x линии границы пятого столбца
    $base['border'] + $base['filed_id_width'] + $base['filed_name_width'] + $base['filed_data_width'] * 5, // Пиксели оси x линии границы пятого столбца
];

$img = imagecreatetruecolor($base['img_width'], $base['img_height']); // Создаем изображение указанного размера
$bg_color = imagecolorallocate($img, 255, 255, 190); // Устанавливаем цвет фона изображения
$text_coler = imagecolorallocate($img, 0, 0, 0); // Устанавливаем цвет текста
$border_coler = imagecolorallocate($img, 0, 0, 0); // Устанавливаем цвет границы
$white_coler = imagecolorallocate($img, 255, 255, 255); // Устанавливаем цвет границы
imagefill($img, 0, 0, $bg_color); // Заливаем цвет фона изображения
// Сначала заполняем большой черный фон
imagefilledrectangle($img, $base ['border'], $base ['border'] + $base ['title_height'], $base ['img_width'] - $base ['border'], $base ['img_height] '] - $base [' border '], imagecolorallocate($img, 255, 0, 0)); // Рисуем прямоугольник
// Заполняем небольшую двухпиксельную область цвета фона, чтобы сформировать двухпиксельную внешнюю границу
imagefilledrectangle($img, $base ['border'] + 2, $base['border'] + $base['title_height'] + 2, $base['img_width'] - $base['border'] - 2, $base['img_height'] - $base['border'] - 2, $bg_color); // Рисуем прямоугольник


// Рисуем вертикальную линию таблицы и пишем текст заголовка
foreach ($base['column_x_arr'] as $key => $x) {
    imageline($img, $x, $border_top, $x, $border_bottom,$border_coler); // Рисуем вертикальные линии
    imagettftext($img, $base['text_size'], 0, $x - $base['column_text_offset_arr'][$key] + 1, $border_top + $base['row_hight'] - 8, $text_coler, $base['font_ulr'], $base['table_header'][$key]); // Записываем текст заголовка таблицы
}
// Рисуем горизонтальные линии в таблице
foreach ($params['data'] as $key => $item) {
    $border_top += $base['row_hight'];
    imageline($img, $base['border'], $border_top, $base['img_width'] - $base['border'], $border_top, $border_coler);

    imagettftext($img, $base ['text_size'], 0, $base ['column_x_arr'] [0] - $base ['row_text_offset_arr'] [0], $border_top + $base ['row_hight'] - 10, $text_coler, $base ['font_ulr'], $key + 1); // Записываем серийный номер
    $sub = 0;
    foreach ($item as $value) {
        $sub++;
        imagettftext($img, $base ['text_size'], 0, $base ['column_x_arr'] [$sub] - $base['row_text_offset_arr'][$sub], $border_top + $base['row_hight'] - 10, $text_coler, $base['font_ulr'], $value); // записываем данные
    }
}

// Рассчитываем начальную позицию написания заголовка
$title_fout_box = imagettfbbox($base ['title_font_size'], 0, $base['font_ulr'], $params['title']); // imagettfbbox () возвращает массив из 8 ячеек, представляющих текстовый фрейм Четыре угла:
$title_fout_width = $title_fout_box[2] - $title_fout_box[0]; // Положение X нижнего правого угла - Положение X нижнего левого угла - это ширина текста
$title_fout_height = $title_fout_box[1] - $title_fout_box[7]; // Позиция Y нижнего левого угла - Y позиция верхнего левого угла - это высота текста
// Напишите заголовок по центру
imagettftext($img, $base['title_font_size'], 0, ($base['img_width'] - $title_fout_width) / 2, $base['title_height']-5, $text_coler, $base['font_ulr'], $params['title']);
// Записываем время табуляции
imagettftext($img, $base['text_size'], 0, $base['border'], $base['title_height']-5, $text_coler, $base['font_ulr'], 'Дата: ' . $params['table_time']);


$save_path = $base['file_path'] . $params['file_name'];
//сохранить файл

imagejpeg($img,$save_path);





