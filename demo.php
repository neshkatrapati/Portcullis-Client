<?php
        /*
                $Id: report_all.php,v 1.1 2004/08/30 16:03:40 chris Exp $
                generate a spreadsheed from and addressbook in mysql database.
        */

       
        
        require_once 'Spreadsheet/Excel/Writer.php';
        require 'connectioncli.php';
 
	$tabname = $_GET["tabname"];
	$bcode = $_GET["bcode"];
	$tot = $_GET["tot"];
	$rname = getResName($tabname);
        $docname = "Consolidated Report of $rname - $bcode .xls";
        
        $workbook = new Spreadsheet_Excel_Writer();
        $format=& $workbook->addFormat();
        $format->setSize(10);
        $worksheet =& $workbook->addWorksheet();
        $worksheet->setHeader($docname);
        $worksheet->mergeCells(0,0,1,0);
         $worksheet->mergeCells(0,1,1,1);
               
      
      
        $format_center =& $workbook->addFormat();
        $format_center->setHAlign('center');
        $format_center->setBorder(2);
        
        $format_fail =& $workbook->addFormat();
        $format_fail->setHAlign('center');
        $format_fail->setFgColor('red');
        $format_fail->setBorder(2);
	
        $worksheet->write(0,0,"RollNumber",$format_center);
        $worksheet->write(0,1,"Name",$format_center);
        
        
		$subcount=0;
        $st = 2;
		$query=mysql_query("SELECT distinct subname FROM `$tabname` where  (select srno REGEXP '......$bcode..') = 1") or die(mysql_error());
        $subjects = array();
        $idcre = 0;
        while($result=mysql_fetch_array($query))
		{
				
			$worksheet->mergeCells(0,$st,0,$st+3);
			$st = $st+4;
			$subjects[$subcount] = $result["subname"];
            $subcount++;
		}
        $worksheet->mergeCells(0,($subcount*4)+2,0,($subcount*4)+3);
        $worksheet->mergeCells(0,($subcount*4)+4,1,($subcount*4)+4);
        $worksheet->mergeCells(0,($subcount*4)+5,1,($subcount*4)+5);
        $worksheet->setColumn(2,($subcount*4)+4,4);
	
        $i=0;
        
        $query=mysql_query("SELECT distinct subname FROM `$tabname` where  (select srno REGEXP '......$bcode..') = 1") or die(mysql_error());
		while($result=mysql_fetch_array($query)){
                $p=$result['subname'];
                $worksheet->write(0,2+$i,$p,$format_center);
                $worksheet->write(1,2+$i,'INT',$format_center);
                $worksheet->write(1,3+$i,'EXT',$format_center);
                $worksheet->write(1,4+$i,'TOT',$format_center);
                $worksheet->write(1,5+$i,'CRE',$format_center);
		$i = $i+4;    
        }
         if($mode != 'S'){
        $worksheet->write(0,($subcount*4)+2,"Totals",$format_center);
        $worksheet->write(1,($subcount*4)+2,"CRE",$format_center);
        $worksheet->write(1,($subcount*4)+3,"MRS",$format_center);
        $worksheet->write(0,($subcount*4)+4,"%",$format_center);
	
	 }
       //$worksheet->write(0,($subcount*4)+5,"Backlogs",$format_center);
        
        
        $totcrecol = ($subcount*4)+2;
        $totmrkcol = ($subcount*4)+3;
        $percentcol = ($subcount*4)+4;
        
        $query = mysql_query("SELECT * from `$tabname` where (select srno REGEXP '......$bcode..') = 1 ORDER BY(srno)");
        $past = "";
        $crow = 1;
        $current = "";
        $cnt = 0;
        $totcre = 0;
        $totmrk = 0;
        $bstr = "";
        $backlog = 0;
        $attend = array();
        $passed = array();
        $highest = array();
        $lowest = array();
        $means = array();
        $totatt = 0;
        $totpass = 0;
        $ai=0;
        $pi=0;
        $attcheck = 0;
        $mark = 0;
        $sind = 0;
        $tothigh = 0;
        $totlow = 0;
        $totmean = 0;
        while($row = mysql_fetch_array($query))
        {

             $current = $row['srno'];
             
             if($current!=$past)
             {
                $crow++;
                
                
                $sname = $row['sname'];
                $srno = $row['srno'];
                $worksheet->write($crow,0,$srno,$format_center);
                $worksheet->write($crow,1,$sname,$format_center);
                if($crow!=2)
                {
                        if($mode != 'S'){
				
				        $worksheet->write($crow-1,$totcrecol,$totcre,$format_center);
				
				        
				$worksheet->write($crow-1,$totmrkcol,$totmrk,$format_center);
				$percent=number_format(($totmrk/$tot)*100,2,'.','');
				$worksheet->write($crow-1,$percentcol,$percent,$format_center);
			}
                        if($tothigh<$totmrk)
                                $tothigh=$totmrk;
                        if($totlow>$totmrk || $totlow==0 )
                                $totlow=$totmrk;
                        
                        $bstr .= $backlog." ";
                        for($i=0;$i<count($arr);$i++)
                        {
							//$sub=mysql_query("select subshort from MSUBJECTT where subid='$arr[$i]'");
							
							$bstr .= "/".$arr[$i];
                	}
                        $worksheet->write($crow-1,$percentcol+1,$bstr);
                        unset($arr);
                        $backlog = 0;
                        $bstr = "";
                        
                        if($attcheck!=-20)
                        {
                                $totatt++;
                                $totmean += $totmrk;
                        }
                         if($mark!=-20)
                                $totpass++;
                }
                $past = $current;
                $cnt=0;
                $totcre = 0;
                $totmrk = 0;
                $attcheck = 0;
                $ai=0;
                $pi=0;
                $sind =0;
                $mark = 0;
             }
        
                
                //$subid = $row['subid'];
                $scode = $row['subname'];
                //$mcre = $qr['cre'];
                $index = -1;
               
                for($i=0;$i<count($subjects);$i++)
                {
                      if($subjects[$i]==$scode)  
                        {
                                
                                $index = $i;
                                break;
                        }
                }
                if($index!=-1)
                {
                         $int = $row['intm'];
                         $ext = $row['extm'];
                         $cre = $row['cre'];
                         $totcre += $cre;
                         $totmrk += $int+$ext;
                         if($highest[$sind]<($int+$ext) || $highest[$sind]==0)
                                $highest[$sind]=($int+$ext);
                        if(($lowest[$sind]>($int+$ext) || $lowest[$sind]==0) && $ext!=-1)
                                $lowest[$sind]=($int+$ext);
                         if($ext != -1 && $ext!="")
                         {
                                
                                $attend[$ai]++;
                                $means[$sind] += ($int+$ext);
                         }
                         else
                         {
                                
                                $attcheck = -20;
                         }
                         if($cre>0)
                         {
                                $worksheet->write($crow,2+($index*4),$int,$format_center);
                                $worksheet->write($crow,3+($index*4),$ext,$format_center);
                                $worksheet->write($crow,4+($index*4),$int+$ext,$format_center);
                                $worksheet->write($crow,5+($index*4),$cre,$format_center);
				$passed[$pi]++;
                                
                         }
                         else
                         {
                                $arr[]=$row["subname"];
				$backlog=$backlog+1;
                                $worksheet->write($crow,2+($index*4),$int,$format_fail);
				$worksheet->write($crow,3+($index*4),$ext,$format_fail);
                                $worksheet->write($crow,4+($index*4),$int+$ext,$format_fail);
                                $worksheet->write($crow,5+($index*4),$cre,$format_fail);
                                $mark = -20;
                         }
                            $ai++;
                $pi++;
                $sind++;
                }
                $cnt++;
             
             
        }
        
	$worksheet->write($crow,$totcrecol,$totcre);
	$worksheet->write($crow,$totmrkcol,$totmrk,$format_center);
	$percent=number_format(($totmrk/$mxtot)*100,2,'.','');
	$worksheet->write($crow,$percentcol,$percent,$format_center);
	if($attcheck!=-20)
	        $totatt++;
	if($mark!=-20)
	        $totpass++;
	 
        $bstr .= $backlog." ";
        for($i=0;$i<count($arr);$i++)
        {
		
							$bstr .= "/".$arr[$i];	
      	}
        $worksheet->write($crow,$percentcol+1,$bstr);
        unset($arr);
        
        $crow += 5;
         if($mode != 'S'){
        $worksheet->write($crow,1,"Total Passed");
        $worksheet->write($crow+1,1,"Total Attended");
        $worksheet->write($crow+2,1,"Pass %:");
        $worksheet->write($crow+3,1,"Highest Mark:");
        $worksheet->write($crow+4,1,"Lowest Mark:");
        $worksheet->write($crow+5,1,"Mean Mark:");
        
        for($i=0;$i<count($attend);$i++)
        {
                $worksheet->write($crow,5+($i*4),$passed[$i]);
                $worksheet->write($crow+1,5+($i*4),$attend[$i]-1);
                $worksheet->write($crow+2,5+($i*4),round(($passed[$i]/$attend[$i])*100,2));
                $worksheet->write($crow+3,5+($i*4),$highest[$i]);
                $worksheet->write($crow+4,5+($i*4),$lowest[$i]);
                $worksheet->write($crow+5,5+($i*4),round(($means[$i]/$totatt),2));
                
        }
        
        $worksheet->write($crow,4+($i*4),$totpass);
        $worksheet->write($crow+1,4+($i*4),$totatt);
        $worksheet->write($crow+2,4+($i*4),round(($totpass/$totatt)*100,2));
        $worksheet->write($crow+3,4+($i*4),$tothigh);
        $worksheet->write($crow+4,4+($i*4),$totlow);
        $worksheet->write($crow+5,4+($i*4),round($totmean/$totatt,2));
	 }
        $workbook->send($docname);
        $workbook->close();
        
        function getResName($tabname){
				$q = mysql_query("select rname from MRESULTT where rtabname like '$tabname'");
				$a = mysql_fetch_array($q);
				return $a["rname"];
		}
?>
