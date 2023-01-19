import axios from 'axios'

const API_URL = `${import.meta.env.VITE_API_URL}`;

axios.defaults.baseURL = API_URL;
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.patch['Content-Type'] = 'application/merge-patch+json';

//axios.defaults.headers.common['Access-Control-Allow-Origin'] = import.meta.env.VITE_ALLOW_ORIGIN;

export const getAxiosInstance = () => {
    const instance = axios.create()
    instance.interceptors.request.use(
        (request) => {
            request.headers = {
                ...request.headers,
                ...authHeader(),
            };

            return request;
        },
        (error) => Promise.reject(error),
    );

    return instance;
};

function authHeader() {
    const user = JSON.parse(localStorage.getItem('user'));
    if (user && user.token) {
        return { Authorization: 'Bearer ' + user.token };
    }
    return {};
}