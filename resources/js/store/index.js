import Vuex from 'vuex';
import Vue from 'vue';
import notes from './modules/notes';
import expenses from "./modules/expenses";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    notes,
    expenses,
  },
});
