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

  async post(garageSchudleEvent) {
    return getAxiosInstance()
      .post("garage_schudle_events", garageSchudleEvent)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, garageSchudleEvent) {
    return getAxiosInstance()
      .put(`garage_schudle_events/${id}`, garageSchudleEvent)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, garageSchudleEvent) {
    return getAxiosInstance()
      .patch(`garage_schudle_events/${id}`, garageSchudleEvent)
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
