import { getAxiosInstance } from "../helpers/axios/config.js";

class ImageService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("images", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`images/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async getCarImages(id, params = null) {
    return getAxiosInstance()
      .get(`cars/${id}/images`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async post(image) {
    return getAxiosInstance()
      .post("images", image)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, image) {
    return getAxiosInstance()
      .put(`images/${id}`, image)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, image) {
    return getAxiosInstance()
      .patch(`images/${id}`, image)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`images/${id}`)
      .then((response) => {
        return response.data;
      });
  }
}

export default new ImageService();
