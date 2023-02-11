import { defineConfig } from "cypress";
import dotenv from "dotenv";

export default defineConfig({
  video: false,
  env: dotenv.config().parsed,
  component: {
    devServer: {
      framework: "vue",
      bundler: "vite",
    },
  },

  e2e: {
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});
