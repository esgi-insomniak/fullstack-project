import { getAxiosInstance } from "../helpers/axios/config.js";

class GarageSchudleEventService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("garage_schudle_events", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`garage_schudle_events/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async getGarageEvents(id, params = null) {
    return getAxiosInstance()
      .get(`garages/${id}/garage_schudle_events`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async post(garage) {
    return getAxiosInstance()
      .post("garage_schudle_events", garage)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, garage) {
    return getAxiosInstance()
      .put(`garage_schudle_events/${id}`, garage)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, garage) {
    return getAxiosInstance()
      .patch(`garage_schudle_events/${id}`, garage)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`garage_schudle_events/${id}`)
      .then((response) => {
        return response.data;
      });
  }
}

export default new GarageSchudleEventService();
