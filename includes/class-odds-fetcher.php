<?php
// This class is used to fetch live odds data from an external API
class Odds_Fetcher {
    // Your API key to access the odds API
    private $api_key = '038e8abf215331e625478949de2c077d';

    // Base URL of the odds API
    private $base_url = 'https://api.the-odds-api.com/v4';

    // This function gets odds by sport, region, and market
    // $sport: which sport (e.g. football), $region: location (e.g. UK), $market: type of odds (e.g. h2h)
    public function get_odds($sport = 'upcoming', $region = 'uk', $market = 'h2h') {
        // Build the full API URL
        $url = "{$this->base_url}/sports/{$sport}/odds/?regions={$region}&markets={$market}&apiKey={$this->api_key}";

        // Call the API using WordPress function
        $response = wp_remote_get($url);

        // If there is an error, return empty data
        if (is_wp_error($response)) {
            return [];
        }

        // Get the response body and convert it from JSON to array
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }

    // This function gets a list of all available sports from the API
    public function get_available_sports() {
        $url = "https://api.the-odds-api.com/v4/sports/?apiKey={$this->api_key}";

        // Get the sports list from API
        $response = wp_remote_get($url);

        // Return the decoded list if no error
        return !is_wp_error($response) ? json_decode(wp_remote_retrieve_body($response), true) : [];
    }

    // This function returns a static list of regions (hardcoded)
    public function get_available_regions() {
        return [
            'uk' => 'UK',
            'us' => 'USA',
            'au' => 'Australia',
            'eu' => 'Europe'
        ];
    }
}
?>
