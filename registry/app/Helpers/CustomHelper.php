<?php

namespace App\Helpers;

class CustomHelper
{
    public static function xss_safe($value)
    {
        return strip_tags(htmlspecialchars(trim($value)));
    }

    public static function domainnameConvention($param)
    {
        $subdomainpattern = "/^([0-9A-Za-z\-\.]{2,100})$/";
        $badch = array('HTTP', '--');
        for ($j = 0; $j < count($badch); $j++) {
            if (strpos(strtoupper($param), $badch[$j]) !== false) {

                return 2;
            }
        }

        if ((strpos($param, '-') === 0) || (strpos($param, '-', (strlen($param) - 1)) == (strlen($param) - 1))) {

            return 2;
        }
        if ((strpos($param, '.') === 0) || (strpos($param, '.', (strlen($param) - 1)) == (strlen($param) - 1))) {

            return 2;
        }

        if ((!preg_match($subdomainpattern, $param))) {
            return 2;
        }
    }

    public static function checkTelphone($value)
    {
        $countrycode = substr($value, 0, 4);
        $stdcode = substr($value, 4);
        if ($countrycode != '+91.') {
            return false;
        }
        if (strpos($value, '-') === true) {
            $splitstr = explode('-', $stdcode);
            if (!strlen($splitstr[0]) <= 4) {
                return false;
            } elseif (!is_numeric($splitstr[0]) || !is_numeric($splitstr[1])) {
                return false;
            }
        }
    }

    public static function checkkIP($value)
    {
        $goodchar = "1234567890.";
        for ($i = 0; $i < strlen($value); $i++) {
            if (strpos($goodchar, $value[$i]) === false) {
                return 2;
            }
        }
        return 1;
    }


    public static function checkIPV4($value)
    {
        $regex = "/^((2[0-4]|1\d|[1-9])?\d|25[0-5])(\.(?1)){3}\z/";
        if (!preg_match($regex, $value))
            return 2;
       
    }
    public static function checkIPV6($value)
    {

        $regex =    '/^(((?=(?>.*?(::))(?!.+\3)))\3?|([\dA-F]{1,4}(\3|:(?!$)|$)|\2))(?4){5}((?4){2}|(25[0-5]|(2[0-4]|1\d|[1-9])?\d)(\.(?7)){3})\z/i';

        if (!preg_match($regex, $value))
            return 2;
    }

    function checkWhilstedcharacter($text){    
        $white_parameter = "\x{900}-\x{97F}\ a-zA-Z0-9 | | +@&$%,:.\-\_\(\)";
        $pattern = "/^([".$white_parameter."])+$/ui";    
    
        $str = trim($text);
        if (is_null($str) || $str == "") {
            return FALSE;
        }
        
        if(trim(!preg_match($pattern, $str))){
            return 2;
        } 
    }

    public static function chkbadchar ($value)
	{		
		$badch = array('DROP','--','INSERT','DELETE', 'SCRIPT', 'MAILTO', 'HREF');
		$badchh = array('--','<','>','#',"'" );

		if (!(is_null($value)) || trim($value)!="")
		{		
			if (in_array($value, $badch)) 
			{
                return 2;
			}

			for ($i=0;$i<count($badchh);$i++)
		    {
			    if (strpos(strtoupper($value),strtoupper($badchh[$i])) !== false)
			    {
				    return 2;
			    }
		    }
		}
		return 1;
	}

    public static function generateCode()
    {
        $today = now()->format('Ymd');
        $code = $today . mt_rand(1000, 9999);

        return $code;
    }
}
