# ExportData
## Installation
```bash
$ composer require andreitripon/export-data
```

## Examples
### CSV
```php
$csvExport = new ExportData\Type\CSV();
$csvExport->setData(
    array(
        array(false, ''),
        array(true, ''),
        array(0, '0'),
        array(null, 'null'),
        array(20.21, '20.21'),
        array('20,21', '2021'),
        array('MUST SELL!
air, moon roof, loaded', 'Extended Edition, "Very Large"'),
        array('2°21′03″E', '34°03′N'),
        array('2000;Mercury;', 'ac, abs, moon'),
        array('"ac, abs, moon"', 4799.00),
        array('"Extended Edition"', '"Extended Edition, Very Large""'),
        array('"MUST SELL!
air, moon roof, loaded"', '4799.00')
    )
);
$csvExport->setFileName('file-name');
$csvExport->setHeaderRow(
    array(
        'Column 1',
        'Column 2'
    )
);

$csvExport->export();
```