import axios from "axios";
import _get from "lodash.get";

const state = {
  expenses: [],
};

const getters = {
  expensesList: state => state.expenses,
};

const actions = {
  async fetchExpenses({commit}) {
    const response = await axios.get(`/api/expenses`);
    const notes = _get(response, 'data.data', []);

    commit('setExpenses', notes);
    return true;
  },
  async addExpense({commit}, expense) {
    const response = await axios.post('api/expenses/create', expense);
    const data = _get(response, 'data.data');

    const newExp = _get(data, 'expense');
    if (newExp) {
      commit('newExpense', newExp);
    }
    return _get(data, 'success', false);
  },
};

const mutations = {
  setExpenses: (state, expenses) => state.expenses = expenses,
  newExpense: (state, expense) => state.expenses.unshift(expense),
};

export default {
  state,
  getters,
  actions,
  mutations,
};
