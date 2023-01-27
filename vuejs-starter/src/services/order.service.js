import { getAxiosInstance } from "../helpers/axios/config.js";

class OrderService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("orders", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`orders/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async getCarOrders(id, params = null) {
    return getAxiosInstance()
      .get(`cars/${id}/orders`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async getGarageOrders(id, params = null) {
    return getAxiosInstance()
      .get(`garages/${id}/orders`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async getUserOrders(id, params = null) {
    return getAxiosInstance()
      .get(`users/${id}/orders`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async post(order) {
    return getAxiosInstance()
      .post("orders", order)
      .then((response) => {
        return response.data;
      });
  }

  async postPayment(id) {
    return getAxiosInstance()
      .post("payment", id)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, order) {
    return getAxiosInstance()
      .put(`orders/${id}`, order)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, order) {
    return getAxiosInstance()
      .patch(`orders/${id}`, order)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`orders/${id}`)
      .then((response) => {
        return response.data;
      });
  }
}

export default new OrderService();
