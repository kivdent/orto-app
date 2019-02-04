Решил задачку, даже 2 -мя способами:
 1 вариант: оставил fetchAll для обеих баз
 привел массив строк из MySQL к такому виду:
PHP:
$myRows = array(
    'unique_name1' => array(
        'name1_1' => 'value1_1',
        'name1_2' => 'value1_2',
    ),
    'unique_name2' => array(
        'name2_1' => 'value2_1',
        'name2_2' => 'value2_2',
    ),
);
т.е. вынес уникальное поле в ключ массива.
 а затем так:
PHP:
foreach ($msRows as $key => $msRow) {
    if(!array_key_exists($msRow['unique_name'], $myRows))
        $foundKeys[] = $key;
}
все отработало за доли секунды без ошибок.

 Но куда более интересен для моего случая 2-й вариант:
 сделал fetchAll только для MS SQL, а выборку из MySQL вообще не делал

 базу синхронизировал при помощи простого запроса INSERT:
PHP:
INSERT INTO `table` (`a`, `b`, `c`) VALUES
(1, 2, 3), (4, 5, 6), (7, 8, 9)
ON DUPLICATE KEY UPDATE `b`=VALUES(`b`), `c`=VALUES(`c`);
где `a` - это уникальный ключ, а ON DUPLICATE KEY UPDATE говорит MySQL, что если в базе уже есть такая запись с уникальным полем, то надо делать не INSERT, а UPDATE.
 Причем физическое обновление полей будет только тогда, когда они отличаются.

 Вот так все просто.
 Может кому пригодится...

