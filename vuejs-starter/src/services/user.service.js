import { getAxiosInstance } from "../helpers/axios/config.js";

class UserService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("users", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`users/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, user) {
    return getAxiosInstance()
      .put(`users/${id}`, user)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, user) {
    return getAxiosInstance()
      .patch(`users/${id}`, user)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`users/${id}`)
      .then((response) => {
        return response.data;
      });
  }
}

export default new UserService();
