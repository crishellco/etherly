require('./bootstrap');

import Vue from 'vue';
import * as components from './components';
import * as mixins from './mixins';

// Register global components.
_.each(components, (component, name) => {
    Vue.component(_.kebabCase(name), component);
});

// Register global mixins.
_.each(mixins, mixin => {
    Vue.mixin(mixin);
});

const app = new Vue({
    el: '#app'
});
