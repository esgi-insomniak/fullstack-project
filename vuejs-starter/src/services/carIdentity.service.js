import { getAxiosInstance } from "../helpers/axios/config.js";

class CarIdentityService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("car_identities", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`car_identities/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async getCarCategoryCarIdentities(id, params = null) {
    return getAxiosInstance()
      .get(`car_categories/${id}/car_identities`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async post(carIdentity) {
    return getAxiosInstance()
      .post("car_identities", carIdentity)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, carIdentity) {
    return getAxiosInstance()
      .put(`car_identities/${id}`, carIdentity)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, carIdentity) {
    return getAxiosInstance()
      .patch(`car_identities/${id}`, carIdentity)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`car_identities/${id}`)
      .then((response) => {
        return response.data;
      });
  }
}

export default new CarIdentityService();
