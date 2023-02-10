import { getAxiosInstance } from "../helpers/axios/config.js";

class GarageService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("garages", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`garages/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async post(garage) {
    return getAxiosInstance()
      .post("garages", garage)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, garage) {
    return getAxiosInstance()
      .put(`garages/${id}`, garage)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, garage) {
    return getAxiosInstance()
      .patch(`garages/${id}`, garage)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`garages/${id}`)
      .then((response) => {
        return response.data;
      });
  }
}

export default new GarageService();
