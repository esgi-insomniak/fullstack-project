import {getAxiosInstance} from "../helpers/axios/config.js";

class UserService {
    constructor () {
        this.user = null
    }

    getUser () {
        return this.user
    }

    setUser (user) {
        this.user = user
    }

    me() {
        return getAxiosInstance()
            .get("users/me")
            .then((response) => {
                return response.data;
            });
    }

    update(user) {
        return getAxiosInstance()
            .patch("users/me", user)
            .then((response) => {
                return response.data;
            });
    }
}

export default new UserService();