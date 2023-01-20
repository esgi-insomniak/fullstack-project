import { getAxiosInstance } from "../helpers/axios/config.js";

class CarService {
  async getCarCollection(params = null) {
    return getAxiosInstance()
      .get("cars", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async getCar(id) {
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

  async postCar(car) {
    return getAxiosInstance()
      .post("cars", car)
      .then((response) => {
        return response.data;
      });
  }

  async putCar(id, car) {
    return getAxiosInstance()
      .put(`cars/${id}`, car)
      .then((response) => {
        return response.data;
      });
  }

  async patchCar(id, car) {
    return getAxiosInstance()
      .patch(`cars/${id}`, car)
      .then((response) => {
        return response.data;
      });
  }

  async deleteCar(id) {
    return getAxiosInstance()
      .delete(`cars/${id}`)
      .then((response) => {
        return response.data;
      });
  }

    async getCarCategoryCollection(params = null) {
        return getAxiosInstance()
            .get("car_categories", { params: params })
            .then((response) => {
                return response.data;
            });
    }

    async getCarCategory(id) {
        return getAxiosInstance()
            .get(`car_categories/${id}`)
            .then((response) => {
                return response.data;
            });
    }

    async postCarCategory(carCategory) {
        return getAxiosInstance()
            .post("car_categories", carCategory)
            .then((response) => {
                return response.data;
            });
    }

    async putCarCategory(id, carCategory) {
        return getAxiosInstance()
            .put(`car_categories/${id}`, carCategory)
            .then((response) => {
                return response.data;
            });
    }

    async patchCarCategory(id, carCategory) {
        return getAxiosInstance()
            .patch(`car_categories/${id}`, carCategory)
            .then((response) => {
                return response.data;
            });
    }

    async deleteCarCategory(id) {
        return getAxiosInstance()
            .delete(`car_categories/${id}`)
            .then((response) => {
                return response.data;
            });
    }

    async getCarIdentityCollection(params = null) {
        return getAxiosInstance()
            .get("car_identities", { params: params })
            .then((response) => {
                return response.data;
            });
    }

    async getCarIdentity(id) {
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

    async postCarIdentity(carIdentity) {
        return getAxiosInstance()
            .post("car_identities", carIdentity)
            .then((response) => {
                return response.data;
            });
    }

    async putCarIdentity(id, carIdentity) {
        return getAxiosInstance()
            .put(`car_identities/${id}`, carIdentity)
            .then((response) => {
                return response.data;
            });
    }

    async patchCarIdentity(id, carIdentity) {
        return getAxiosInstance()
            .patch(`car_identities/${id}`, carIdentity)
            .then((response) => {
                return response.data;
            });
    }

    async deleteCarIdentity(id) {
        return getAxiosInstance()
            .delete(`car_identities/${id}`)
            .then((response) => {
                return response.data;
            });
    }
}

export default new CarService();
