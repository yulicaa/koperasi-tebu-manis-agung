<?php

namespace App\Http\Helpers;

class Helpers
{
    public function convertInstallment($installment)
    {
        $installment = $this->extractNumber($installment);
        $installment = str_replace(',', '.', $installment);
        $result = $installment * 1000000;
        $result = (int) $result;
        
        return $result;
    }

    function extractNumber($string) {
        preg_match('/\d+,\d+|\d+/', $string, $matches);
        if (!empty($matches)) {
            return $matches[0];
        }
    
        return null;
    }

    public function processPrice($price)
    {
        $dividedPrice = $price / 60;
        $priceInMillions = $dividedPrice / 1000000;
        $roundedPrice = round($priceInMillions, 1);
       
        $formattedPrice = number_format($roundedPrice, 1, '.', '');
        return $formattedPrice;
    }
}