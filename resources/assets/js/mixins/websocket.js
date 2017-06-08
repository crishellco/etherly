import { Websocket } from '../support';

export default {
    beforeDestroy() {
        this.disconnectSocket();
    },

    created() {
        this.createSocket = () => {
            this.disconnectSocket();
            this.$socket = new Websocket();

            return this.$socket;
        };

        this.disconnectSocket = () => {
            if(this.$socket) {
                this.$socket.disconnect();
            }
        };
    }
}
