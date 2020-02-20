<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Profiler extends CI_Profiler {

	public function __construct()
	{
		parent::__construct();
	}
 	public function _compile_all_var()      //aggiungere all'array protected $_available_sections in Profiler.php: 'all_var',
	{
		if ( ! isset($this->CI->session))
		{
			return;
		}
                $tit = 'All Var';
                $tit2 = 'Show';
                $tit3 = 'Hide';
		$output = '<fieldset id="ci_profiler_callvar" style="border:1px solid #000;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee;">'
			.'<legend style="color:#000;">&nbsp;&nbsp;'.$tit.'&nbsp;&nbsp;(<span style="cursor: pointer;" onclick="var s=document.getElementById(\'ci_profiler_all_var\').style;s.display=s.display==\'none\'?\'\':\'none\';this.innerHTML=this.innerHTML==\''.$tit2.'\'?\''.$tit3.'\':\''.$tit2.'\';">'.$tit2.'</span>)</legend>'
			.'<table style="width:100%;display:none;" id="ci_profiler_all_var">';
                $var = $this->CI->load->get_vars();
		foreach ($var as $key => $val)
		{
			$pre       = '';
			$pre_close = '';
                        
			if (is_array($val) OR is_object($val))
			{
				$val = print_r($val, TRUE);
                                
				$pre       = '<pre>' ;
 				$pre_close = '</pre>';
			}

			$output .= '<tr><td style="padding:5px;vertical-align:top;color:#900;background-color:#ddd;">'
				.$key.'&nbsp;&nbsp;</td><td style="padding:5px;color:#000;background-color:#ddd;">'.$pre.htmlspecialchars($val, ENT_QUOTES, config_item('charset')).$pre_close."</td></tr>\n";
		}

		return $output."</table>\n</fieldset>";
	}  
}
