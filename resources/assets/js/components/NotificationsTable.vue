<template>
    <table class="table">
        <thead>
        <tr>
            <th class="text-right">Price @ Analysis</th>
            <th class="text-right">Historical Price</th>
            <th class="text-right">Percent Change</th>
            <th class="text-right">Threshold Percent</th>
            <th class="text-right">Price Change</th>
            <th class="text-right">Threshold Price</th>
            <th>Sent</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="notification in notifications">
            <td class="text-right">{{ formatMoney(notification.current_price.price) }}</td>
            <td class="text-right">{{ formatMoney(notification.historical_price.price) }}</td>
            <td class="text-right">{{ formatPercent(notification.percent_change) }}</td>
            <td class="text-right">{{ formatPercent(notification.threshold_percent) }}</td>
            <td class="text-right">{{ formatMoney(notification.price_change) }}</td>
            <td class="text-right">{{ formatMoney(notification.threshold_price) }}</td>
            <td>{{ notification.created_at }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        beforeMount() {
            this
                .createSocket()
                .listen('NotificationsUpdated', this.fetch, `user.${Laravel.userId}`);
        },

        data() {
            return {
                notifications: []
            }
        },

        methods: {
            fetch() {
                axios
                    .get('/api/notifications')
                    .then(({data}) => {
                        this.notifications = data;
                    });
            },

            formatMoney(amount) {
                return numeral(amount).format('$0.00');
            },

            formatPercent(amount) {
                return numeral(amount).format('0.00%');
            },
        },
    }
</script>
