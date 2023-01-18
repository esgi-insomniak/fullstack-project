import AuthService from "../services/auth.service.js";

const user = JSON.parse(localStorage.getItem("user"));
const initialState = user
  ? { status: { loggedIn: true }, user }
  : { status: { loggedIn: false }, user: null };

export const auth = {
  namespaced: true,
  state: initialState,
  getters: {
    isLoggedIn: (state) => {
        return state.status.loggedIn;
    },
    user: (state) => {
        return state.user;
    }
  },

  actions: {
    //LOGIN
    login({ commit }, user) {
      return AuthService.login(user).then(
        user => {
          commit("loginSuccess", user); //on success, commit loginSuccess mutation
          return Promise.resolve(user);
        },
        error => {
          commit("loginFailure"); //on failure, commit loginFailure mutation
          return Promise.reject(error);
        }
      );
    },

    //LOGOUT
    logout({ commit }) {
      AuthService.logout();
      commit("logout"); //commit logout mutation
    },

    //REGISTER
    register({ commit }, user) {
      return AuthService.register(user).then(
        response => {
          commit("registerSuccess"); //on success, commit registerSuccess mutation
          return Promise.resolve(response.data);
        },
        error => {
          commit("registerFailure"); //on failure, commit registerFailure mutation
          return Promise.reject(error);
        }
      );
    }
  },

  mutations: {
    //LOGIN
    loginSuccess(state, user) {
      state.status.loggedIn = true;
      state.user = user;
    },
    loginFailure(state) {
      state.status.loggedIn = false;
      state.user = null;
    },
    logout(state) {
      state.status.loggedIn = false;
      state.user = null;
    },
    registerSuccess(state) {
      state.status.loggedIn = false;
    },
    registerFailure(state) {
      state.status.loggedIn = false;
    }
  }
}