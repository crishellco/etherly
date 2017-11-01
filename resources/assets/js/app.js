require('./bootstrap');

import Vue from 'vue';
import * as components from './components';
import * as mixins from './mixins';

// Turbolinks
import Turbolinks from 'turbolinks'
import TurbolinksAdapter from 'vue-turbolinks'
Turbolinks.start();
Vue.use(TurbolinksAdapter);

// Register global components.
_.each(components, (component, name) => {
    Vue.component(_.kebabCase(name), component);
});

// Register global mixins.
_.each(mixins, mixin => {
    Vue.mixin(mixin);
});

document.addEventListener('turbolinks:load', () => {
    const app = new Vue({
        el: '#app',
        store,
    });
});
