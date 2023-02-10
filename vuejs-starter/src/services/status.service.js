import { getAxiosInstance } from "../helpers/axios/config.js";

class StatusService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("statuses", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`statuses/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async post(status) {
    return getAxiosInstance()
      .post("statuses", status)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, status) {
    return getAxiosInstance()
      .put(`statuses/${id}`, status)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, status) {
    return getAxiosInstance()
      .patch(`statuses/${id}`, status)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`statuses/${id}`)
      .then((response) => {
        return response.data;
      });
  }
}

export default new StatusService();
