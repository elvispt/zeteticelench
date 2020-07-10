import axios from "axios";
import _get from "lodash.get";

const state = {
  users: [],
  currentUserId: null,
};

const getters = {
  usersList: state => state.users,
  currentUserId: state => state.currentUserId,
};

const actions = {
  async fetchUsers({commit}) {
    const response = await axios.get('/api/users');
    const users = _get(response, 'data.data.users', []);
    const currentUserId = _get(response, 'data.data.currentUserId');

    commit('setUsersList', users);
    commit('setCurrentUserId', currentUserId);
    return true;
  },
  async addUser({commit}, user) {
    const response = await axios.post('/api/users/create', user);
    const data = _get(response, 'data.data');

    const newUser = _get(data, 'user');
    if (newUser) {
      commit('newUser', newUser);
    }
    return _get(data, 'success', false);
  },
  async updateUser({commit}, user) {
    let success = false;
    try {
      const updateData = {
        id: user.id,
        name: user.name,
      };
      if (user.password) {
        updateData.password = user.password;
      }
      const response = await axios.put('/api/users/update', updateData);
      success = _get(response, 'data.data.success', false);
      if (success) {
        commit('updateUser', user);
      }
    } catch (err) {
      success = false;
      console.error(err);
    }
    return success;
  },
  async destroyUser({commit}, id) {
    let success = false;
    try {
      const response = await axios.delete('/api/users/destroy', {
        data: { id }
      });
      success = _get(response, 'data.data.success', false);
      if (success) {
        commit('deleteUser', id);
      }
    } catch (err) {
      success = false;
      console.error(err);
    }
    return success;
  },
};

const mutations = {
  setUsersList: (state, users) => state.users = users,
  newUser: (state, user) => state.user.push(user),
  updateUser: (state, user) => {
    const userToEdit = state.users.filter(usr => usr.id === user.id);
    userToEdit.name = user.name;
  },
  setCurrentUserId: (state, currentUserId) => state.currentUserId = currentUserId,
  deleteUser: (state, id) => {
    const index = state.users.findIndex(user => user.id === id);
    state.users.splice(index, 1);
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
