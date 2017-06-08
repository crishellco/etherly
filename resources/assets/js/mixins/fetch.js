import _ from "lodash";

export default {
    mounted() {
        if (_.isFunction(this.fetch)) {
            this.fetch();
        }
    },
};
