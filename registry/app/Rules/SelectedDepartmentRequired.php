<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SelectedDepartmentRequired implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
     protected $orgcategory;
     public function __construct($orgcategory)
    {
        $this->orgcategory = $orgcategory;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the organization category is 4 or 10
        // and if the value is empty, then fail the validation
        // This is used to ensure that a department is selected for certain organization categories ( 4,10).


        if (in_array($this->orgcategory, [4, 10])) {
              if (empty($value)) {
                  $fail('Yo must select a department.');
              }

            
        }
    }
}
