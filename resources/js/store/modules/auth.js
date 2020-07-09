import axios from "axios";
import _get from "lodash.get";
import { getLocalUser, setLocalUser } from "../../helpers/user";

export default {
  state: {
    user: getLocalUser(),
  },

  getters: {
    userInfo: state => state.user,
  },

  mutations: {
    setUserInfo: (state, user) => state.user = user,
  },

  actions: {
    async authenticate({commit, dispatch}, credentials) {
      const successStatusCode = 204;
      const response = await axios.post('/login', credentials);
      if (response.status === successStatusCode) {
        await dispatch('fetchCurrentUser');
      }
      return response;
    },
    async fetchCurrentUser({commit}) {
      const response = await axios.get('/api/users/currentUser');
      const user = _get(response, 'data.data');

      setLocalUser(user);
      commit('setUserInfo', user);
    },
  },
}
