<?php
// Create an object of the Odds_Fetcher class
$odds = new Odds_Fetcher();

// Get list of available sports and regions
$sports = $odds->get_available_sports();
$regions = $odds->get_available_regions();

// Get selected sport and region from the URL, or use default values
$selected_sport = isset($_GET['sport']) ? sanitize_text_field($_GET['sport']) : 'americanfootball_ncaaf';
$selected_region = isset($_GET['region']) ? sanitize_text_field($_GET['region']) : 'uk';

// Fetch odds data using selected sport and region
$odds_data = $odds->get_odds($selected_sport, $selected_region);
?>

<!-- Load DataTables and Bootstrap CSS for styling the table -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Make sure the table takes full width -->
<style>
    table.dataTable { width: 100% !important; }
</style>

<!-- Dropdown form to select sport and region -->
<form method="get">
    <label>Sport:</label>
    <select name="sport" onchange="this.form.submit()">
        <?php foreach ($sports as $sport): ?>
            <option value="<?php echo esc_attr($sport['key']); ?>" <?php selected($sport['key'], $selected_sport); ?>>
                <?php echo esc_html($sport['title']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Region:</label>
    <select name="region" onchange="this.form.submit()">
        <?php foreach ($regions as $code => $label): ?>
            <option value="<?php echo esc_attr($code); ?>" <?php selected($code, $selected_region); ?>>
                <?php echo esc_html($label); ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if (!empty($odds_data)): ?>
    <!-- Display selected sport and region -->
    <h3>Odds: <?php echo esc_html($selected_sport); ?> (<?php echo strtoupper($selected_region); ?>)</h3>

    <!-- Odds table -->
    <table id="oddsTable" class="table table-striped table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Match</th>
            <th>Bookmaker</th>
            <th>Home</th>
            <th>Draw</th>
            <th>Away</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($odds_data as $match): ?>
            <?php foreach ($match['bookmakers'] as $bookmaker): ?>
                <tr>
                    <!-- Show the match -->
                    <td><?php echo esc_html($match['home_team']) . ' vs ' . esc_html($match['away_team']); ?></td>
                    <!-- Show the bookmaker (like Bet365, etc.) -->
                    <td><?php echo esc_html($bookmaker['title']); ?></td>
                    <?php
                    // Set default values
                    $home = $draw = $away = '-';
                    // Get the odds (prices) from the bookmaker
                    $markets = $bookmaker['markets'][0]['outcomes'] ?? [];

                    // Check which team the outcome belongs to
                    foreach ($markets as $outcome) {
                        if ($outcome['name'] === $match['home_team']) {
                            $home = $outcome['price'];
                        } elseif ($outcome['name'] === $match['away_team']) {
                            $away = $outcome['price'];
                        } elseif (strtolower($outcome['name']) === 'draw') {
                            $draw = $outcome['price'];
                        }
                    }
                    ?>
                    <!-- Show odds for Home, Draw, and Away -->
                    <td><?php echo esc_html($home); ?></td>
                    <td><?php echo esc_html($draw); ?></td>
                    <td><?php echo esc_html($away); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Load jQuery and DataTables JS to make the table sortable and paginated -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        $('#oddsTable').DataTable({
            "pageLength": 10, // Show 10 rows per page
            "responsive": true // Make it look good on all screens
        });
    });
</script>
<?php else: ?>
    <!-- Show this message if no data is available -->
    <p>No odds available for selected sport and region.</p>
<?php endif; ?>
