<template>
    <div id="eth-chart"></div>
</template>

<script>
    export default {
        beforeMount() {
            this.chart = null;

            this
                .createSocket()
                .listen('EtherPriceUpdated', this.fetch);
        },

        methods: {
            data() {
                return {
                    data: []
                }
            },

            fetch() {
                axios
                    .get('/api/charts/eth')
                    .then(({data}) => {
                        this.data = data;
                        this.renderChart();
                    });
            },

            renderChart() {
                if(this.chart) {
                    this.chart.redraw();
                    
                    return;
                }

                this.chart = Highcharts.stockChart('eth-chart', {
                    rangeSelector: {
                        buttons: [
                            {
                                count: 1,
                                text: '1h',
                                type: 'hour',
                            }, {
                                count: 6,
                                text: '6h',
                                type: 'hour',
                            }, {
                                count: 12,
                                text: '12h',
                                type: 'hour',
                            }, {
                                count: 1,
                                text: '1w',
                                type: 'week',
                            }, {
                                text: 'All',
                                type: 'all',
                            }
                        ],
                    },

                    title: {
                        text: 'ETH Price'
                    },

                    series: [{
                        type: 'candlestick',
                        name: 'ETH Price',
                        data: this.data,
                        dataGrouping: {
                            forced: true,
                            units: [
                                ['minute', 5]
                            ]
                        },
                    }]
                });
            }
        },
    }
</script>
