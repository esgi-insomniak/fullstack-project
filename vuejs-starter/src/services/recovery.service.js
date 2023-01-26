import { getAxiosInstance } from "../helpers/axios/config.js";

class RecoveryService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("recoveries", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`recoveries/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async getCarRecoveries(id, params = null) {
    return getAxiosInstance()
      .get(`cars/${id}/recoveries`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async getGarageRecoveries(id, params = null) {
    return getAxiosInstance()
      .get(`garages/${id}/recoveries`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async getUserRecoveries(id, params = null) {
    return getAxiosInstance()
      .get(`users/${id}/recoveries`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async post(recovery) {
    return getAxiosInstance()
      .post("recoveries", recovery)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, recovery) {
    return getAxiosInstance()
      .put(`recoveries/${id}`, recovery)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, recovery) {
    return getAxiosInstance()
      .patch(`recoveries/${id}`, recovery)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`recoveries/${id}`)
      .then((response) => {
        return response.data;
      });
  }
}

export default new RecoveryService();
