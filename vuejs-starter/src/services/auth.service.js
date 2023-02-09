import { getAxiosInstance } from "../helpers/axios/config.js";

class AuthService {
  login(user) {
    return getAxiosInstance()
        .post("authentication_token", {email: user.email, password: user.password})
        .then((response_authentication_token) => {
          if (response_authentication_token.data.token) {
            const token = response_authentication_token.data.token;
            sessionStorage.setItem("user", JSON.stringify({token: token}));
          }
          return response_authentication_token.data;
        });
  }

  logout() {
    sessionStorage.removeItem("user");
  }

  register(user) {
    return getAxiosInstance().post("users", {
        email: user.email,
        plainPassword: user.plainPassword,
        firstName: user.firstName,
        lastName: user.lastName,
        coordinates: user.coordinates,
        address: user.address,
    });
  }

  forgotPassword(values) {
    return getAxiosInstance().post("users/recovery_account", {
        email: values.email,
    });
  }

  accountRecovery(values) {
    return getAxiosInstance().post("users/recovery_account_change_password", {
        recoveryToken: values.recoveryToken,
        password: values.password,
        confirmPassword: values.confirmPassword,
    });
  }
}

export default new AuthService();