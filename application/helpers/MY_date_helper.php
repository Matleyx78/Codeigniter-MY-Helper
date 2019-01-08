<?php
	function adhoc_to_unix($datestr = '')
	{
		if ($datestr === '')
		{
			return FALSE;
		}

                    $gg = substr($datestr,0,2);
                    $mm = substr($datestr,3,2);
                    $yyyy = substr($datestr,6,4);
                    
                    if (strlen($datestr) > 10)
                        {
                            $hh = substr($datestr,-8,2);
                            $ii = substr($datestr,-5,2);
                            $ss = substr($datestr,-2,2);                        
                        }
                        else
                            {
                                $hh = "00";
                                $ii = "00";
                                $ss = "00";                            
                            }

		return mktime($hh, $ii, $ss, $mm, $gg, $yyyy);
	}        

	function adhoc_to_mysql($datestr = '')
	{
		if ($datestr === '')
		{
			return FALSE;
		}

                    $gg = substr($datestr,0,2);
                    $mm = substr($datestr,3,2);
                    $yyyy = substr($datestr,6,4);
                    $hh = "00";
                                $ii = "00";
                                $ss = "00";
//                    if (strlen($datestr) > 10)
//                        {
//                            $hh = substr($datestr,-8,2);
//                            $ii = substr($datestr,-5,2);
//                            $ss = substr($datestr,-2,2);                        
//                        }
//                        else
//                            {
//                                $hh = "00";
//                                $ii = "00";
//                                $ss = "00";                            
//                            }
                            
                    $mysql = "$yyyy-$mm-$gg $hh:$ii:$ss";

		return $mysql;
	}        

	function mysql_to_human1($datestr = '')
	{
		if ($datestr === '')
		{
			return FALSE;
		}

                    $gg = substr($datestr,8,2); //   2016-08-31 00:00:00
                    $mm = substr($datestr,5,2);
                    $yyyy = substr($datestr,0,4);
                    $hh = substr($datestr,-8,2);
                    $ii = substr($datestr,-5,2);
                    $ss = substr($datestr,-2,2);       
                    $uman1 = "$gg/$mm/$yyyy";

		return $uman1;
	}

	function mysql_to_human2($datestr = '')
	{
		if ($datestr === '')
		{
			return FALSE;
		}

                    $gg = substr($datestr,8,2); //   2016-08-31 00:00:00
                    $mm = substr($datestr,5,2);
                    $yyyy = substr($datestr,0,4);
                    $hh = substr($datestr,-8,2);
                    $ii = substr($datestr,-5,2);
                    $ss = substr($datestr,-2,2);       
                    $uman2 = "$gg/$mm/$yyyy $hh:$ii";

		return $uman2;
	}
	function mysql_to_human3($datestr = '')
	{
		if ($datestr === '')
		{
			return FALSE;
		}

                    $gg = substr($datestr,8,2); //   2016-08-31 00:00:00
                    $mm = substr($datestr,5,2);
                    $yyyy = substr($datestr,0,4);
                    $hh = substr($datestr,-8,2);
                    $ii = substr($datestr,-5,2);
                    $ss = substr($datestr,-2,2);       
                    $uman3 = "$hh:$ii:$ss";

		return $uman3;
	}        

    function datediff($tipo, $partenza, $fine)
    {
        switch ($tipo)
        {
            case "A" : $tipo = 365;
            break;
            case "M" : $tipo = (365 / 12);
            break;
            case "S" : $tipo = (365 / 52);
            break;
            case "G" : $tipo = 1;
            break;
        }

        $date_diff = mysql_to_unix($fine) - mysql_to_unix($partenza);
        $date_diff  = floor(($date_diff / 60 / 60 / 24) / $tipo);
        return $date_diff;
    }       
	function now_to_datetime()
	{
            $now = date("Y-m-d H:i:s");

		return $now;
	}
