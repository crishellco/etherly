import Echo from 'laravel-echo';
import {PusherConstants} from '../constants';

export default class Websocket {

    constructor() {
        this.init();
    }

    disconnect() {
        if(this.echo) {
            this.echo.connector.pusher.disconnect();
            this.echo = null;
        }

        return this;
    }

    ignore(event, channel = 'global') {
        if(!this.echo) {
            this.init();
        }

        this.echo.channel(channel).stopListening(event);

        return this;
    }

    init() {
        this.disconnect();

        this.echo = new Echo(PusherConstants.config);

        return this;
    }

    listen(event, callback, channel = 'global') {
        if(!this.echo) {
            this.init();
        }

        this.echo.channel(channel).listen(event, callback);

        return this;
    }

}
