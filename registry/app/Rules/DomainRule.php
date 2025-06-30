<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Helpers\CustomHelper;
use App\Models\Domain;
class DomainRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $domainname=$value.'.gov.in';
        
        if (strtolower($domainname) !== $domainname) {
            $fail('The :attribute must be lowercase.');
        }
        $checkdomainnameconvention = CustomHelper::domainnameConvention( $value);

        if($checkdomainnameconvention == 2){
            $fail('The :attribute is in invalid format');
        }

        
        $getdomain= Domain::where('domainname',  $domainname)->get();
      
        if(count($getdomain) > 0){
            $fail('The :attribute already exists');    
        }
        // exec('whois ' . escapeshellarg(urlencode($domainname)) . ' -h whois.registry.in -p 43', $str);

        // if (!empty($str)){
        //     if ($str[0] != "No Data Found") {
        //         $fail('The :attribute is not available.');             
        //     } 
        // }

    }
}
