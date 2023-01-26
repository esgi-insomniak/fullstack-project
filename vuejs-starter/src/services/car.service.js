import { getAxiosInstance } from "../helpers/axios/config.js";

class CarService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("cars", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`cars/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async getCarIdentityCars(id, params = null) {
    return getAxiosInstance()
      .get(`car_identities/${id}/cars`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async getGarageCars(id, params = null) {
    return getAxiosInstance()
      .get(`garages/${id}/cars`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async post(car) {
    return getAxiosInstance()
      .post("cars", car)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, car) {
    return getAxiosInstance()
      .put(`cars/${id}`, car)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, car) {
    return getAxiosInstance()
      .patch(`cars/${id}`, car)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`cars/${id}`)
      .then((response) => {
        return response.data;
      });
  }
}

export default new CarService();