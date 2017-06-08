import _ from "lodash";
import * as services from "../services";

const $services = {};

_.each(services, (service, name) => {
    $services[_.camelCase(_.replace(name, 'Service', ''))] = service;
});

export default {
    created() {
        this.$services = $services;
    }
};
