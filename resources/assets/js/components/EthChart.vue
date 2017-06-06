<template>
    <div id="eth-chart"></div>
</template>

<script>
    export default {
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
                Highcharts.stockChart('eth-chart', {
                    rangeSelector: {
                        buttons: [
                            {
                                count: 5,
                                text: '5m',
                                type: 'minute',
                            }, {
                                count: 15,
                                text: '15m',
                                type: 'minute',
                            }, {
                                count: 30,
                                text: '30m',
                                type: 'minute',
                            }, {
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
                                text: 'All',
                                type: 'all',
                            }
                        ],
                        selected: 6
                    },

                    title: {
                        text: 'ETH Price'
                    },

                    series: [{
                        type: 'candlestick',
                        name: 'ETH Price',
                        data: this.data,
                        dataGrouping: {
                            units: [
                                [
                                    'minute',
                                    [5],
                                ]
                            ]
                        }
                    }]
                });
            }
        },

        mounted() {
            this.fetch();
        },
    }
</script>
