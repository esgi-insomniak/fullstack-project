import axios from "axios";
import { getAxiosInstance } from "../helpers/axios/config.js";

class AuthService {
  login(user) {
    return getAxiosInstance()
        .post("authentication_token", {email: user.email, password: user.password})
        .then((response_authentication_token) => {
          if (response_authentication_token.data.token) {
            const token = response_authentication_token.data.token;
            localStorage.setItem("user", JSON.stringify({token: token}));
          }
          return response_authentication_token.data;
        });
  }

  logout() {
    localStorage.removeItem("user");
  }

  register(user) {
    return getAxiosInstance().post("users", {
        email: user.email,
        plainPassword: user.plainPassword,
        name: user.name,
    });
  }
}

export default new AuthService();