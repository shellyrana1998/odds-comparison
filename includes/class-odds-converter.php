<?php
// This class is used to convert decimal odds into other formats: fractional and American
class Odds_Converter {

    // Convert decimal odds to fractional format
    // Example: 2.5 becomes 1.5/1
    public function decimal_to_fractional( $decimal ) {
        // Subtract 1 to get profit part only
        $numerator = $decimal - 1;

        // Return the fractional format as a string
        return "{$numerator}/1";
    }

    // Convert decimal odds to American format
    public function decimal_to_american( $decimal ) {
        // If the odds are 2.0 or more, return positive American odds
        if ( $decimal >= 2 ) {
            return '+' . round( ( $decimal - 1 ) * 100 );
        } else {
            // If less than 2.0, return negative American odds
            return '-' . round( 100 / ( $decimal - 1 ) );
        }
    }
}
?>
