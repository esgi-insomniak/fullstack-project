import axios from "axios";

const API_URL = "https://localhost/";

class AuthService {
  login(user) {
    return axios
      .post(API_URL + "authentication_token", {
        email: user.email,
        password: user.password
      }, {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json"
        }
      })
      .then(response => {
        if (response.data.token) {
          localStorage.setItem("user", JSON.stringify(response.data));
        }

        return response.data;
      });
  }

  logout() {
    localStorage.removeItem("user");
  }

  register(user) {
    return axios.post(API_URL + "users", {
      email: user.email,
      plainPassword: user.plainPassword,
      roles: user.roles
    });
  }
}

export default new AuthService();