import axios from "axios";
import _get from "lodash.get";

const state = {
  notes: [],
  searchQuery: '',
};

const getters = {
  notesList: state => state.notes,
  searchQuery: state => state.searchQuery,
};

const actions = {
  async fetchNotesList({commit}, searchQuery = '') {
    commit('setSearchQuery', searchQuery);
    const response = await axios.get(`/api/notes?query=${searchQuery}`);
    const notes = _get(response, 'data.data', []);

    commit('setNotesList', notes);
    return true;
  },
  async addNote({commit}, note) {
    const response = await axios.post('/api/notecreate', {
      body: note.body,
      tags: note.selectedTags,
    });

    const id = _get(response, 'data.data.id');
    const success = _get(response, 'data.data.success');

    if (id && success) {
      return id;
    }
    return false;
  },
  updateSearchQuery({commit}, searchQuery) {
    commit('setSearchQuery', searchQuery);
  }
};

const mutations = {
  setNotesList: (state, notes) => state.notes = notes,
  setSearchQuery: (state, searchQuery) => state.searchQuery = searchQuery,
};

export default {
  state,
  getters,
  actions,
  mutations,
};
