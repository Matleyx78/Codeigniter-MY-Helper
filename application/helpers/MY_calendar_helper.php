<?php
    function primo_del_mese()
	{
                    $now = time();
                    $mm = date("m",$now);
                    $yyyy = date("Y",$now);
                    
                    $primo = $yyyy."-".$mm."-01";

		return $primo;
	}
        
    function buildMonths ($monthNum,$yearNum,$easterDay)
        {
            $firstDay = mktime(0,0,0,$monthNum,1,$yearNum);
            $daysPerMonth = intval(date("t",$firstDay));

            for ($i = 1; $i<=$daysPerMonth; $i++)
                {
                    $m[$i] = $this->dayType($monthNum, $i, $yearNum,$easterDay) ;
                }
                
            return $m;   
        }
        
    function dayType($monthNum,$i,$yearNum,$easterDay)
        {
        $giorniSettimana = array("Domenica","Lunedi","Martedi","Mercoledi","Giovedi","Venerdi","Sabato");
        $actualDay = mktime(0,0,0,$monthNum,$i,$yearNum);
        $numDay = intval(date("w",$actualDay));

        if (($monthNum == $easterDay['month']) && (intval(date("j",$actualDay)) == $easterDay['day']))
            {				
                $f = "PASQUA";
            }
        elseif ($numDay == 0 OR $numDay == 6 )
            {
                $f = "CHIUSO";
            }
        elseif ($this->isHoliday($monthNum,date("j",$actualDay)))
            {
                $f = "FESTA";
            }
        elseif ($this->isFerie($yearNum,$monthNum,date("j",$actualDay)))
            {
                $f = "FERIE AZ.";
            }
        elseif (($monthNum == $easterDay['month']) && (intval(date("j",$actualDay)) == $easterDay['day']+1))
            {				
                $f = "PASQUETTA";
            }
        elseif ((($easterDay['day'] == 31 && $easterDay['month'] == 3 && intval(date("j",$actualDay)) == 1 && $monthNum == 4) || ($easterDay['day'] == 30 && $easterDay['month'] == 4) && intval(date("j",$actualDay)) == 1 && $monthNum == 5))
            {				
                $f = "PASQUETTA";
            }
        else
            {
                $f = "APERTO";
            }

        $i = array(
            "day"=>date("d",$actualDay), 
            "weekday"=>iconv('UTF-8','CP1252',$giorniSettimana[$numDay]),
            "F"=>$f,
            );
        
        return $i;
        
        }
        
   function isHoliday ($monthNumber,$dayNumber)
        {
            $monthNumber = intval($monthNumber);
            $dayNumber = intval($dayNumber);
            $holiday = array(
                1=>array(1,6), 
                4=>array(25),
                5=>array(1),
                6=>array(2),
                8=>array(10,15),
                11=>array(1),
                12=>array(8,25,26)                                      
                );
            $holidayKeys = array_keys($holiday);
            
            if (in_array($monthNumber,$holidayKeys))
                {
                    if (in_array($dayNumber,$holiday[$monthNumber]))
                        {
                            return true;
                        }
                }
                
            return false;
        }
        
    function isMomentoLavorativo ($array,$istante)
        {
            $compreso = FALSE;
            
            foreach ($array as $a)
                {
                    if ($istante >= $a['I'] && $istante < $a['F'])
                        {
                            $compreso = TRUE;    
                        }
                }

            return $compreso;
        }
    function isFerie ($yearNumber,$monthNumber,$dayNumber)
        {
            $yearNumber = intval($yearNumber);
            $monthNumber = intval($monthNumber);
            $dayNumber = intval($dayNumber);
            
            $ferie = array(
                2017 =>  array(
                    1=>array(2,3,4,5), 
                    4=>array(14,24),
                    6=>array(1),
                    7=>array(31),
                    8=>array(1,2,3,4,7,8,9,11,14,16,17,18,21,22,23,24,25),
                    12=>array(27,28,29)                                      
                    ),
                2018 =>  array(
                    1=>array(2,3,4,5), 
                    4=>array(26,27,30),
                    8=>array(6,7,8,9,13,14,16,17,20,21,22,23,24,27,28,29,30,31),
                    11=>array(2),
                    12=>array(24,27,28,31),                                     
                    ),
                2019 =>  array(
                    1=>array(2,3,4), 
                    4=>array(23,24,26),
                    8=>array(5,6,7,8,9,12,13,14,16,19,20,21,22,23,26,27,28,29,30),
                    12=>array(23,24,27,30,31),                                     
                    ),
                );
            
        $annoKeys = array_keys($ferie);
        
        if (in_array($yearNumber,$annoKeys))
            {
                $meseKeys[$yearNumber] = array_keys($ferie[$yearNumber]);
                
                if (in_array($monthNumber,$meseKeys[$yearNumber]))
                    {
                        if (in_array($dayNumber,$ferie[$yearNumber][$monthNumber]))
                            {
                                return true;
                            }
                    }
                    
                return false;
            }
        }

    function easterDay($year)
        {
            $e = strtotime("$year-03-21 +".easter_days($year)." days");
            $easterDay = array(
                "month"=>intval(date("n",$e)), 
                "day"=>intval(date("j",$e)),
                );

            return $easterDay;
        }
        
    function buildList($tipo,$composto = '') // Restituisce in output un array di giorni: anno, mese, giorno, nome mese, nome giorno, tipo
        {
            if ($composto === '')
		{
                    $composto = 0;  //  Se composto è VERO, allora crea array composto
		}  

            $mesiAnno = array("GENNAIO","FEBBRAIO","MARZO","APRILE","MAGGIO","GIUGNO","LUGLIO","AGOSTO","SETTEMBRE","OTTOBRE","NOVEMBRE","DICEMBRE");
                
            switch ($tipo)
                {
                    case 1:     //$tipo =   1   Ultimi 15 giorni ORDINE INVERTITO
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',date('Y-m-d')); //OGGI
                        list($fineanno,$finemese,$finegiorno) = explode('-',date('Y-m-d',mktime(0,0,0,$iniziomese,$iniziogiorno-15,$inizioanno))); //15 giorni prima di oggi
                        $reverseinavanti = 0;
                        break;
                    case 2:     //$tipo =   2   mese corrente ORDINE INVERTITO
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',date('Y-m-d')); //OGGI
                        list($fineanno,$finemese,$finegiorno) = explode('-',date('Y-m-d',mktime(0,0,0,$iniziomese,0,$inizioanno))); //Primo del mese rispetto a oggi
                        $reverseinavanti = 0;
                        break;
                    case 3:     //$tipo =   2   ultimi 3 mesi ORDINE INVERTITO
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',date('Y-m-d')); //OGGI
                        list($fineanno,$finemese,$finegiorno) = explode('-',date('Y-m-d',mktime(0,0,0,$iniziomese-2,0,$inizioanno))); //Primo del mese di 3 mesi prima rispetto a oggi
                        $reverseinavanti = 0;
                        break;
                    case 4:     //$tipo =   4   prossimi 60 giorni 
                        list($oa,$om,$og) = explode('-',date('Y-m-d')); //OGGI
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',date('Y-m-d',mktime(0,0,0,$om,$og+60,$oa)));//60 giorni dopo rispetto a oggi
                        list($fineanno,$finemese,$finegiorno) = explode('-',date('Y-m-d',mktime(0,0,0,$om,$og-1,$oa))); // 2 giorni prima di oggi
                        $reverseinavanti = 1; 
                        break;
                    case 5:     //$tipo =   5   ultimi 3 mesi 
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',date('Y-m-d')); //OGGI
                        list($fineanno,$finemese,$finegiorno) = explode('-',date('Y-m-d',mktime(0,0,0,$iniziomese-2,0,$inizioanno))); //Primo del mese di 3 mesi prima rispetto a oggi
                        $reverseinavanti = 1;
                        break;
                    case 6:     //$tipo =   6   ultimi 2 mesi 
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',date('Y-m-d')); //OGGI
                        list($fineanno,$finemese,$finegiorno) = explode('-',date('Y-m-d',mktime(0,0,0,$iniziomese-1,0,$inizioanno))); //Primo del mese di 1 mesi prima rispetto a oggi
                        $reverseinavanti = 1;
                        break;
                    case 7:     //$tipo =   7   dall'iniziodell'anno a oggi 
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',date('Y-m-d')); //OGGI
                        list($fineanno,$finemese,$finegiorno) = explode('-',date('Y-m-d',mktime(0,0,0,1,0,$inizioanno))); //Primo dell'anno rispetto a oggi
                        $reverseinavanti = 1;
                        break;
                    case 8:     //$tipo =   8   ultimi 4 mesi 
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',date('Y-m-d')); //OGGI
                        list($fineanno,$finemese,$finegiorno) = explode('-',date('Y-m-d',mktime(0,0,0,$iniziomese-3,0,$inizioanno))); //Primo del mese di 3 mesi prima rispetto a oggi
                        $reverseinavanti = 1;
                        break;
                    case 9:     //$tipo =   9   dall'inizio dell'anno precedente a oggi 
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',date('Y-m-d')); //OGGI
                        list($fineanno,$finemese,$finegiorno) = explode('-',date('Y-m-d',mktime(0,0,0,1,0,$inizioanno-1))); //Primo dell'anno precedente rispetto a oggi
                        $reverseinavanti = 1;
                        break;

                    case 2017:     //$tipo =   2017   anno 2017 
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',"2017-12-31"); 
                        list($fineanno,$finemese,$finegiorno) = explode('-',"2016-12-31"); 
                        $reverseinavanti = 1;
                        break;
                    case 2018:     //$tipo =   2018   anno 2018 
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',"2018-12-31"); 
                        list($fineanno,$finemese,$finegiorno) = explode('-',"2017-12-31"); 
                        $reverseinavanti = 1;
                        break;

                    default:    //ieri e oggi
                        list($inizioanno,$iniziomese,$iniziogiorno) = explode('-',date('Y-m-d')); //OGGI
                        list($fineanno,$finemese,$finegiorno) = explode('-',date('Y-m-d',mktime(0,0,0,$iniziomese,$iniziogiorno-1,$inizioanno))); //ieri
                }

            $easterDay = $this->easterDay($inizioanno);
            //Costruisco la tabella
            $y = $inizioanno;
            $m = $iniziomese;
            $d = $iniziogiorno;
            $datai = date('Y-m-d',mktime(0,0,0,$iniziomese,$iniziogiorno,$inizioanno));
            $dataf = date('Y-m-d',mktime(0,0,0,$finemese,$finegiorno,$fineanno));
            
            while($datai != $dataf)
                {
                    $nomemeseatt = $mesiAnno[$m-1];
                    $daydata = $this->dayType($m,$d,$y,$easterDay);

                    $listagiorni[] = [
                        'anno' => $y,
                        'mese' => $m,
                        'giorno' => $d,
                        'nomemese' => $nomemeseatt,
                        'nomegiorno' => $daydata['weekday'],
                        'tipogiorno' => $daydata['F'],
                        ];
                    list($y,$m,$d) = explode('-',date('Y-m-d',mktime(0,0,0,$m,$d-1,$y)));
                    $datai = date('Y-m-d',mktime(0,0,0,$m,$d,$y));
                }
        
            if ($reverseinavanti == 1)
                {
                    $listagiorni = array_reverse($listagiorni);
                }
                
            if ($composto == '1')
                {
                    $ricomponi = array();
                    
                    foreach ($listagiorni as $l)
                        {
                            $ricomponi[$l['anno']][$l['nomemese']][$l['giorno']] = $l;
                        }
                        
                    $listagiorni = $ricomponi;
                }

            return $listagiorni;        
    }   

    function isgiornolavorativo($daytime)
        {
            $timestamp = mysql_to_unix($daytime);
            $anno = date("Y",$timestamp);
            $mese = date("m",$timestamp);
            $giorno = date("d",$timestamp);
            $pasq = $this->easterDay($anno);
            $tipo = $this->dayType($mese, $giorno, $anno, $pasq);
            $lavorativo = FALSE;

            if ($tipo['F'] == "APERTO")
                {
                    $lavorativo = TRUE;
                }

            return $lavorativo;
        }
        
    function diff_giorni_lavorativi($datavecchia,$datagiovane)
        {
            $giorni = 0;
            $timestampvecchia = mysql_to_unix($datavecchia);
            $timestampgiovane = mysql_to_unix($datagiovane);
            $elencogiorni = array();
            $elencogiorni[] = $datavecchia;
            
            do
                {
                    $timestampvecchia += 86400;
                    $elencogiorni[] = unix_to_human($timestampvecchia, TRUE, 'eu');
                    
                    if( $this->isgiornolavorativo(unix_to_human($timestampvecchia, TRUE, 'eu')) )
                        {
                            $giorni +=1;    
                        }
                }
                while ($timestampvecchia < $timestampgiovane);

            return $giorni;
        }
