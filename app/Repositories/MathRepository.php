<?php

namespace App\Repositories;

class MathRepository
{
    /**
     * Decimal to fraction
     *
     * @param  $float
     * @return string
     */

    public function decToFraction($float) {

      $whole = floor($float);
      $decimal = $float - $whole;

      // $leastCommonDenom = 48;
      // $denominators = array (2, 3, 4, 8, 16, 24, 48);

      $leastCommonDenom = 4;
      $denominators = array (2, 3, 4);

      $roundedDecimal = round($decimal * $leastCommonDenom) / $leastCommonDenom;

      if ($roundedDecimal == 0)
        return $whole;

      if ($roundedDecimal == 1)
        return $whole + 1;

      foreach ($denominators as $d) {
        if ($roundedDecimal * $d == floor($roundedDecimal * $d)) {
          $denom = $d;
          break;
        }
      }

      return ($whole == 0 ? '' : $whole) . " " . ($roundedDecimal * $denom) . "/" . $denom;
    }

}
