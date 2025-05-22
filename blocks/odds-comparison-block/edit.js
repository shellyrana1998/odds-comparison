const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;

registerBlockType('odds-comparison/api-data-block', {
    title: 'Odds Comparison',
    icon: 'chart-bar',
    category: 'widgets',
    edit: function () {
        return createElement('div', null,
            createElement('p', null, 'Odds comparison table will appear here.')
        );
    },
    save: function () {
        return null; // Dynamic block
    }
});

