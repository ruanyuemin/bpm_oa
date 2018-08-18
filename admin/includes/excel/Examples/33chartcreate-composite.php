<?php
 error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE); date_default_timezone_set('Europe/London'); define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />'); date_default_timezone_set('Europe/London'); require_once dirname(__FILE__) . '/../Classes/PHPExcel.php'; $objPHPExcel = new PHPExcel(); $objWorksheet = $objPHPExcel->getActiveSheet(); $objWorksheet->fromArray( array( array('', 'Rainfall (mm)', 'Temperature (°F)', 'Humidity (%)'), array('Jan', 78, 52, 61), array('Feb', 64, 54, 62), array('Mar', 62, 57, 63), array('Apr', 21, 62, 59), array('May', 11, 75, 60), array('Jun', 1, 75, 57), array('Jul', 1, 79, 56), array('Aug', 1, 79, 59), array('Sep', 10, 75, 60), array('Oct', 40, 68, 63), array('Nov', 69, 62, 64), array('Dec', 89, 57, 66), ) ); $dataseriesLabels1 = array( new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1), ); $dataseriesLabels2 = array( new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1), ); $dataseriesLabels3 = array( new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$1', NULL, 1), ); $xAxisTickValues = array( new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$13', NULL, 12), ); $dataSeriesValues1 = array( new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$13', NULL, 12), ); $series1 = new PHPExcel_Chart_DataSeries( PHPExcel_Chart_DataSeries::TYPE_BARCHART, PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED, range(0, count($dataSeriesValues1)-1), $dataseriesLabels1, $xAxisTickValues, $dataSeriesValues1 ); $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL); $dataSeriesValues2 = array( new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$13', NULL, 12), ); $series2 = new PHPExcel_Chart_DataSeries( PHPExcel_Chart_DataSeries::TYPE_LINECHART, PHPExcel_Chart_DataSeries::GROUPING_STANDARD, range(0, count($dataSeriesValues2)-1), $dataseriesLabels2, NULL, $dataSeriesValues2 ); $dataSeriesValues3 = array( new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$2:$D$13', NULL, 12), ); $series3 = new PHPExcel_Chart_DataSeries( PHPExcel_Chart_DataSeries::TYPE_AREACHART, PHPExcel_Chart_DataSeries::GROUPING_STANDARD, range(0, count($dataSeriesValues2)-1), $dataseriesLabels3, NULL, $dataSeriesValues3 ); $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series1, $series2, $series3)); $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false); $title = new PHPExcel_Chart_Title('Average Weather Chart for Crete'); $chart = new PHPExcel_Chart( 'chart1', $title, $legend, $plotarea, true, 0, NULL, NULL ); $chart->setTopLeftPosition('F2'); $chart->setBottomRightPosition('O16'); $objWorksheet->addChart($chart); echo date('H:i:s') , " Write to Excel2007 format" , EOL; $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); $objWriter->setIncludeCharts(TRUE); $objWriter->save(str_replace('.php', '.xlsx', __FILE__)); echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL; echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL; echo date('H:i:s') , " Done writing file" , EOL; echo 'File has been created in ' , getcwd() , EOL; 