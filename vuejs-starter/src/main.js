import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import { defaultConfig, plugin } from '@formkit/vue'
import { createAutoAnimatePlugin } from '@formkit/addons'
import { generateClasses } from '@formkit/themes'
import theme from './helpers/formkit/theme'
import store from './store'
import "leaflet/dist/leaflet.css";
import 'v-calendar/dist/style.css';
import VCalendar from 'v-calendar';

const app = createApp(App)
app.use(router)
app.use(plugin, defaultConfig({
    config: {
        classes: generateClasses(theme)
    },
    plugins: [
        createAutoAnimatePlugin(),
    ]
}))
app.use(VCalendar, {})
app.use(store)
app.mount('#app')
