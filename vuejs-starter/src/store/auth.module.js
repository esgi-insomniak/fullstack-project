import AuthService from "../services/auth.service.js";

const user = JSON.parse(localStorage.getItem("user"));
const initialState = { loggedIn: !!user, user: null };

export const auth = {
  namespaced: true,
  state: initialState,
  getters: {
    isLoggedIn: (state) => {
      return state.loggedIn;
    },
    user: (state) => {
      return state.user;
    },
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
    },

    forgotPassword({ commit }, values) {
      return AuthService.forgotPassword(values).then(
        response => {
          commit("forgotPasswordSuccess"); //on success, commit forgotPasswordSuccess mutation
          return Promise.resolve(response.data);
        },
        error => {
          commit("forgotPasswordFailure"); //on failure, commit forgotPasswordFailure mutation
          return Promise.reject(error);
        }
      );
    },

    accountRecovery({ commit }, values) {
      return AuthService.accountRecovery(values).then(
        response => {
          commit("accountRecoverySuccess"); //on success, commit accountRecoverySuccess mutation
          return Promise.resolve(response.data);
        },
        error => {
          commit("accountRecoveryFailure"); //on failure, commit accountRecoveryFailure mutation
          return Promise.reject(error);
        }
      );
    },
  },

  mutations: {
    //LOGIN
    loginSuccess(state, user) {
      state.loggedIn = true;
      state.user = user;
    },
    loginFailure(state) {
      state.loggedIn = false;
      state.user = null;
    },
    logout(state) {
      state.loggedIn = false;
      state.user = null;
    },
    registerSuccess(state) {
      state.loggedIn = false;
    },
    registerFailure(state) {
      state.loggedIn = false;
    },
    forgotPasswordSuccess(state) {
      state.loggedIn = false;
    },
    forgotPasswordFailure(state) {
      state.loggedIn = false;
    },
    accountRecoverySuccess(state) {
      state.loggedIn = false;
    },
    accountRecoveryFailure(state) {
      state.loggedIn = false;
    },
  }
}