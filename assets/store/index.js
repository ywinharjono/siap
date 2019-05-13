import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import siap from './siap/';
import user from './modules/user/';
import autocomplete from './modules/autocomplete';

export default new Vuex.Store({
    modules: {
        siap,
        user,
        autocomplete
    }
});
