import JawgJSLoader from "@jawg/js-loader";

class Map {
    // singleton
    static instance = null;
    token = import.meta.env.VITE_JAWGS_API_KEY;

    getInstance() {
        if (!Map.instance) {
            Map.instance = new JawgJSLoader({ accessToken: this.token }).loadJawgPlaces();
        }
        return Map.instance;
    }
}

export default new Map();