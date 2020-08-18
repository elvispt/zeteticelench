import axios from "axios";
import _get from "lodash.get";

const state = {
  expenses: [],
  expense: {},
};

const getters = {
  expensesList: state => state.expenses,
  expense: state => state.expense,
};

const actions = {
  async fetchExpenses({commit}) {
    const response = await axios.get(`/api/expenses`);
    const expenses = _get(response, 'data.data', []);

    commit('setExpenses', expenses);
    return true;
  },
  async fetchExpense({commit}, id) {
    const response = await axios.get(`/api/expenses/${id}`);
    const expense = _get(response, 'data.data');

    if (expense) {
      commit('setCurrentExpense', expense);
      return true;
    }
    return false;
  },
  async addExpense({commit}, expense) {
    const response = await axios.post('api/expenses/create', expense);
    const data = _get(response, 'data.data');

    return _get(data, 'success', false);
  },
  async updateExpense({commit}, expense) {
    const response = await axios.put(`api/expenses/update/${expense.id}`, expense);
    const data = _get(response, 'data.data');

    return _get(data, 'success', false);
  },
};

const mutations = {
  setExpenses: (state, expenses) => state.expenses = expenses,
  setCurrentExpense: (state, expense) => state.expense = expense,
};

export default {
  state,
  getters,
  actions,
  mutations,
};
