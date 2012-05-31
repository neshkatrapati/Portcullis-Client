<?php
        /*
                $Id: report_all.php,v 1.1 2004/08/30 16:03:40 chris Exp $
                generate a spreadsheed from and addressbook in mysql database.
        */

       
        
        require_once 'Spreadsheet/Excel/Writer.php';
        require 'connectioncli.php';
       
        
        $docname = 'Results.xls';
        
        $workbook = new Spreadsheet_Excel_Writer();
        $format=& $workbook->addFormat();
        $format->setSize(10);
        $worksheet =& $workbook->addWorksheet();
        
               
      
      
        $format_center =&$workbook->addFormat();
        $format_center->setHAlign('center');
        $format_center->setBorder(2);
        
       
	
        $worksheet->write(0,0,"RollNumber",$format_center);
        $worksheet->write(0,1,"Name",$format_center);
	$worksheet->write(0,2,"Subject Code",$format_center);
        $worksheet->write(0,3,"Subject Name",$format_center);
        $worksheet->write(0,4,"Internal",$format_center);
	$worksheet->write(0,5,"External",$format_center);
	$worksheet->write(0,6,"Credits",$format_center);
        
        $tabname = $_GET['tabname'];
	
        $r = mysql_query("select * from $tabname");
        $i = 0;
	$num = mysql_num_rows($r);
	$worksheet->write(0,7,"select * from $tabname",$format_center);
	while($row=mysql_fetch_array($r))
        {
            
            
	    for($j=0;$j<count($row);$j++){
            	$worksheet->write($i+1,$j,$row[$j],$format_center);
	    } 
            $i++;
            
            
        }
        
        
        $workbook->send($docname);
        $workbook->close();
?>
