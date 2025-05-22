# Odds Comparison WordPress Plugin

A custom WordPress plugin to compare sports betting odds across different platforms and display them in a structured table format.

## Features

- Fetch and display real-time betting odds.
- Admin configuration interface.
- Gutenberg block support (`edit.js`).
- Template rendering via `odds-table.php`.
- Modular structure with separate classes for fetching, converting, and managing odds.

## Installation

1. Download the plugin as a `.zip` file.
2. Go to your WordPress admin dashboard.
3. Navigate to **Plugins > Add New > Upload Plugin**.
4. Upload `odds-comparison.zip` and click **Install Now**.
5. Activate the plugin.

Alternatively, place the `odds-comparison` folder into `wp-content/plugins/` and activate it from the dashboard.

## Folder Structure

```
odds-comparison/
│
├── blocks/
│   └── odds-comparison-block/
│       └── edit.js
│
├── includes/
│   ├── class-odds-admin.php
│   ├── class-odds-converter.php
│   └── class-odds-fetcher.php
│
├── templates/
│   └── odds-table.php
│
├── odds-comparison.php           # Main plugin file
├── assets.zip                    # Likely contains CSS/JS/images
├── odds-comparison-bck.zip      # Backup of the plugin
└── odds-comparison.zip          # Redistributable ZIP
```

## Development

- JavaScript files for Gutenberg blocks can be modified in `blocks/`.
- Backend logic is handled by PHP classes in the `includes/` folder.
- Display templates are in `templates/`.

## License

Specify your license here (e.g., MIT, GPLv2, etc.)

## Author

Your Name  
[Your Website or GitHub](https://github.com/your-profile)
