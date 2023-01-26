import { getAxiosInstance } from "../helpers/axios/config.js";

class CarCategoryService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("car_categories", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`car_categories/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async post(carCategory) {
    return getAxiosInstance()
      .post("car_categories", carCategory)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, carCategory) {
    return getAxiosInstance()
      .put(`car_categories/${id}`, carCategory)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, carCategory) {
    return getAxiosInstance()
      .patch(`car_categories/${id}`, carCategory)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`car_categories/${id}`)
      .then((response) => {
        return response.data;
      });
  }
}

export default new CarCategoryService();
