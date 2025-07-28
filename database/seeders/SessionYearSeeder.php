<?php

namespace Database\Seeders;

use App\Models\SessionYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sessionYears = [
            ['english_year' => 1950, 'hijri_year' => '1369 - 1370', 'hijri_start' => 1369, 'hijri_end' => 1370],
            ['english_year' => 1951, 'hijri_year' => '1370 - 1371', 'hijri_start' => 1370, 'hijri_end' => 1371],
            ['english_year' => 1952, 'hijri_year' => '1371 - 1372', 'hijri_start' => 1371, 'hijri_end' => 1372],
            ['english_year' => 1953, 'hijri_year' => '1372 - 1373', 'hijri_start' => 1372, 'hijri_end' => 1373],
            ['english_year' => 1954, 'hijri_year' => '1373 - 1374', 'hijri_start' => 1373, 'hijri_end' => 1374],
            ['english_year' => 1955, 'hijri_year' => '1374 - 1375', 'hijri_start' => 1374, 'hijri_end' => 1375],
            ['english_year' => 1956, 'hijri_year' => '1375 - 1376', 'hijri_start' => 1375, 'hijri_end' => 1376],
            ['english_year' => 1957, 'hijri_year' => '1376 - 1377', 'hijri_start' => 1376, 'hijri_end' => 1377],
            ['english_year' => 1958, 'hijri_year' => '1377 - 1378', 'hijri_start' => 1377, 'hijri_end' => 1378],
            ['english_year' => 1959, 'hijri_year' => '1378 - 1379', 'hijri_start' => 1378, 'hijri_end' => 1379],
            ['english_year' => 1960, 'hijri_year' => '1379 - 1380', 'hijri_start' => 1379, 'hijri_end' => 1380],
            ['english_year' => 1961, 'hijri_year' => '1380 - 1381', 'hijri_start' => 1380, 'hijri_end' => 1381],
            ['english_year' => 1962, 'hijri_year' => '1381 - 1382', 'hijri_start' => 1381, 'hijri_end' => 1382],
            ['english_year' => 1963, 'hijri_year' => '1382 - 1383', 'hijri_start' => 1382, 'hijri_end' => 1383],
            ['english_year' => 1964, 'hijri_year' => '1383 - 1384', 'hijri_start' => 1383, 'hijri_end' => 1384],
            ['english_year' => 1965, 'hijri_year' => '1384 - 1385', 'hijri_start' => 1384, 'hijri_end' => 1385],
            ['english_year' => 1966, 'hijri_year' => '1385 - 1386', 'hijri_start' => 1385, 'hijri_end' => 1386],
            ['english_year' => 1967, 'hijri_year' => '1386 - 1387', 'hijri_start' => 1386, 'hijri_end' => 1387],
            ['english_year' => 1968, 'hijri_year' => '1387 - 1388', 'hijri_start' => 1387, 'hijri_end' => 1388],
            ['english_year' => 1969, 'hijri_year' => '1388 - 1389', 'hijri_start' => 1388, 'hijri_end' => 1389],
            ['english_year' => 1970, 'hijri_year' => '1389 - 1390', 'hijri_start' => 1389, 'hijri_end' => 1390],
            ['english_year' => 1971, 'hijri_year' => '1390 - 1391', 'hijri_start' => 1390, 'hijri_end' => 1391],
            ['english_year' => 1972, 'hijri_year' => '1391 - 1392', 'hijri_start' => 1391, 'hijri_end' => 1392],
            ['english_year' => 1973, 'hijri_year' => '1392 - 1393', 'hijri_start' => 1392, 'hijri_end' => 1393],
            ['english_year' => 1974, 'hijri_year' => '1393 - 1394', 'hijri_start' => 1393, 'hijri_end' => 1394],
            ['english_year' => 1975, 'hijri_year' => '1394 - 1395', 'hijri_start' => 1394, 'hijri_end' => 1395],
            ['english_year' => 1976, 'hijri_year' => '1395 - 1396', 'hijri_start' => 1395, 'hijri_end' => 1396],
            ['english_year' => 1977, 'hijri_year' => '1396 - 1397', 'hijri_start' => 1396, 'hijri_end' => 1397],
            ['english_year' => 1978, 'hijri_year' => '1397 - 1398', 'hijri_start' => 1397, 'hijri_end' => 1398],
            ['english_year' => 1979, 'hijri_year' => '1398 - 1399', 'hijri_start' => 1398, 'hijri_end' => 1399],
            ['english_year' => 1980, 'hijri_year' => '1399 - 1400', 'hijri_start' => 1399, 'hijri_end' => 1400],
            ['english_year' => 1981, 'hijri_year' => '1400 - 1401', 'hijri_start' => 1400, 'hijri_end' => 1401],
            ['english_year' => 1982, 'hijri_year' => '1401 - 1402', 'hijri_start' => 1401, 'hijri_end' => 1402],
            ['english_year' => 1983, 'hijri_year' => '1402 - 1403', 'hijri_start' => 1402, 'hijri_end' => 1403],
            ['english_year' => 1984, 'hijri_year' => '1403 - 1404', 'hijri_start' => 1403, 'hijri_end' => 1404],
            ['english_year' => 1985, 'hijri_year' => '1404 - 1405', 'hijri_start' => 1404, 'hijri_end' => 1405],
            ['english_year' => 1986, 'hijri_year' => '1405 - 1406', 'hijri_start' => 1405, 'hijri_end' => 1406],
            ['english_year' => 1987, 'hijri_year' => '1406 - 1407', 'hijri_start' => 1406, 'hijri_end' => 1407],
            ['english_year' => 1988, 'hijri_year' => '1407 - 1408', 'hijri_start' => 1407, 'hijri_end' => 1408],
            ['english_year' => 1989, 'hijri_year' => '1408 - 1409', 'hijri_start' => 1408, 'hijri_end' => 1409],
            ['english_year' => 1990, 'hijri_year' => '1409 - 1410', 'hijri_start' => 1409, 'hijri_end' => 1410],
            ['english_year' => 1991, 'hijri_year' => '1410 - 1411', 'hijri_start' => 1410, 'hijri_end' => 1411],
            ['english_year' => 1992, 'hijri_year' => '1411 - 1412', 'hijri_start' => 1411, 'hijri_end' => 1412],
            ['english_year' => 1993, 'hijri_year' => '1412 - 1413', 'hijri_start' => 1412, 'hijri_end' => 1413],
            ['english_year' => 1994, 'hijri_year' => '1413 - 1414', 'hijri_start' => 1413, 'hijri_end' => 1414],
            ['english_year' => 1995, 'hijri_year' => '1414 - 1415', 'hijri_start' => 1414, 'hijri_end' => 1415],
            ['english_year' => 1996, 'hijri_year' => '1415 - 1416', 'hijri_start' => 1415, 'hijri_end' => 1416],
            ['english_year' => 1997, 'hijri_year' => '1416 - 1417', 'hijri_start' => 1416, 'hijri_end' => 1417],
            ['english_year' => 1998, 'hijri_year' => '1417 - 1418', 'hijri_start' => 1417, 'hijri_end' => 1418],
            ['english_year' => 1999, 'hijri_year' => '1418 - 1419', 'hijri_start' => 1418, 'hijri_end' => 1419],
            ['english_year' => 2000, 'hijri_year' => '1419 - 1420', 'hijri_start' => 1419, 'hijri_end' => 1420],
            ['english_year' => 2001, 'hijri_year' => '1420 - 1421', 'hijri_start' => 1420, 'hijri_end' => 1421],
            ['english_year' => 2002, 'hijri_year' => '1421 - 1422', 'hijri_start' => 1421, 'hijri_end' => 1422],
            ['english_year' => 2003, 'hijri_year' => '1422 - 1423', 'hijri_start' => 1422, 'hijri_end' => 1423],
            ['english_year' => 2004, 'hijri_year' => '1423 - 1424', 'hijri_start' => 1423, 'hijri_end' => 1424],
            ['english_year' => 2005, 'hijri_year' => '1424 - 1425', 'hijri_start' => 1424, 'hijri_end' => 1425],
            ['english_year' => 2006, 'hijri_year' => '1425 - 1426', 'hijri_start' => 1425, 'hijri_end' => 1426],
            ['english_year' => 2007, 'hijri_year' => '1426 - 1427', 'hijri_start' => 1426, 'hijri_end' => 1427],
            ['english_year' => 2008, 'hijri_year' => '1427 - 1428', 'hijri_start' => 1427, 'hijri_end' => 1428],
            ['english_year' => 2009, 'hijri_year' => '1428 - 1429', 'hijri_start' => 1428, 'hijri_end' => 1429],
            ['english_year' => 2010, 'hijri_year' => '1429 - 1430', 'hijri_start' => 1429, 'hijri_end' => 1430],
            ['english_year' => 2011, 'hijri_year' => '1430 - 1431', 'hijri_start' => 1430, 'hijri_end' => 1431],
            ['english_year' => 2012, 'hijri_year' => '1431 - 1432', 'hijri_start' => 1431, 'hijri_end' => 1432],
            ['english_year' => 2013, 'hijri_year' => '1432 - 1433', 'hijri_start' => 1432, 'hijri_end' => 1433],
            ['english_year' => 2014, 'hijri_year' => '1433 - 1434', 'hijri_start' => 1433, 'hijri_end' => 1434],
            ['english_year' => 2015, 'hijri_year' => '1434 - 1435', 'hijri_start' => 1434, 'hijri_end' => 1435],
            ['english_year' => 2016, 'hijri_year' => '1435 - 1436', 'hijri_start' => 1435, 'hijri_end' => 1436],
            ['english_year' => 2017, 'hijri_year' => '1436 - 1437', 'hijri_start' => 1436, 'hijri_end' => 1437],
            ['english_year' => 2018, 'hijri_year' => '1437 - 1438', 'hijri_start' => 1437, 'hijri_end' => 1438],
            ['english_year' => 2019, 'hijri_year' => '1438 - 1439', 'hijri_start' => 1438, 'hijri_end' => 1439],
            ['english_year' => 2020, 'hijri_year' => '1439 - 1440', 'hijri_start' => 1439, 'hijri_end' => 1440],
            ['english_year' => 2021, 'hijri_year' => '1440 - 1441', 'hijri_start' => 1440, 'hijri_end' => 1441],
            ['english_year' => 2022, 'hijri_year' => '1441 - 1442', 'hijri_start' => 1441, 'hijri_end' => 1442],
            ['english_year' => 2023, 'hijri_year' => '1442 - 1443', 'hijri_start' => 1442, 'hijri_end' => 1443],
            ['english_year' => 2024, 'hijri_year' => '1443 - 1444', 'hijri_start' => 1443, 'hijri_end' => 1444],
            ['english_year' => 2025, 'hijri_year' => '1444 - 1445', 'hijri_start' => 1444, 'hijri_end' => 1445],
        ];

        foreach ($sessionYears as $yearData) {
            SessionYear::updateOrCreate(
                ['english_year' => $yearData['english_year']],
                $yearData
            );
        }

        $this->command->info('Session Years data seeded successfully!');
    }
}
