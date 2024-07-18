import '@/@iconify/icons-bundle';
import App from '@/App.vue';
import layoutsPlugin from '@/plugins/layouts';
import vuetify from '@/plugins/vuetify';
import { loadFonts } from '@/plugins/webfontloader';
import router from '@/router';
import '@core-scss/template/index.scss';
import '@styles/styles.scss';
import { createPinia } from 'pinia';
import { createApp } from 'vue';
import 'bootstrap/dist/css/bootstrap.css';
import bootstrap from 'bootstrap/dist/js/bootstrap';
import 'leaflet/dist/leaflet.css';

loadFonts();

const app = createApp(App);

app.use(vuetify);
app.use(createPinia());
app.use(router);
app.use(layoutsPlugin);
app.use(bootstrap);

app.mount('#app');
