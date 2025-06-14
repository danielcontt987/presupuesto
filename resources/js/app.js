import './bootstrap';
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';
import { createApp, ref } from 'vue';
import { createVuetify} from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import router from './router/index.js';
import { es } from "vuetify/locale";
import moment from 'moment';
import accounting from 'accounting';


//Pinia
import { createPinia } from 'pinia';


const customLightTheme = {
  colors: {
    // primary: "#001F4A",
    // primary: "#1b40a8",
    primary: "#192a67",
    secondary: "#3E47A3",
    blueSky: '#ecf2ff',
    background: "#EFF3F8",
    backgroundColor: '#eff3f8',
    white: '#FFFFFF',
    background_drawer: "#FFF",
    background_nav: "#ffffff",
    text_grey: "#7f7c87",
    background_color:"#EDECF4",
    grey_dark: "#5b5867",
    greyLight: '#92969e',
    fail: '#F50057',
    icon_color: '#F30D46',
    successLight: "#e2fbf6",
    greenLight: "#13deb9",
    lightprimary: "#ecf2ff",
    lightwarning: "#fef5e5",
    lightsecondary: "#e8f7ff",
    lighterror: "#fdede8",
    lightsuccess: "#e6fffa",
    titleCard: "#14006E",
    chipCard: "#ecf2ff",
    warning: "#FBC02D",

    
    /*
    primary_dark: '#051942',
    fail: '#F50057',
    secondary: '#00337C',
    secondary_dark: '#001f4a',
   
    grey: "#A2A2A2",
    black: '#000000',
    success: '#27AE60',
    accent: "#00CFB5",
    error: "#C22F2F",
    success_card: '#27AE60',
    blueLight: "#f1f3fd",
    purple_primary:"#9c5df9",
    purple_light2: "#e2dff8",
    purple_dark_accent: "#7366ef", 
    purple_acent: "#fcebf7",
    blue_light: "#fcebf7",
    sky_blue: "#fcebf7",
    purple_dark:"#8436f7",
    
    error_light: "#ea5455",
    blue_light_sky: "#d0f0f7",
    aqua_normal: "#00cfe8",
    orange_light2:"#f9e8dd",
    orange_l2:"#ff9e43",
    wather_melon: "#fcc3c3",
    red_dark_2: "#ff3838",
    */

  },
};
const customDarkTheme = {
  dark: false,
  colors: {
    white: "#fff",
    background_nav: "#2e3248",
    background_color: "#25293c",
    background_drawer: "#2e3248",
    purple_primary:"#9c5df9",
    grey_dark: "#acb0cc",
    purple_dark:"#8436f7",
    
    purple_light2: "#313258",
    purple_dark_accent: "#7367f0",
    
    blue_light_sky: "#1f4357",
    aqua_normal:"#00cfe8",

    orange_light2:"#483b3d",
    orange_l2: "#ff9e43",

    wather_melon: "#82424f",
    red_dark_2: "#ff3838",

    
  },
};
const vuetify = createVuetify({
    components,
    directives,
    theme: {
      defaultTheme: "customLightTheme",
      themes: {
        customLightTheme,
        customDarkTheme,
      },
    },
    locale: {
      locale: "es",
      fallback: "es", // Especifica la localidad de respaldo una vez
      messages: { es },
  },
})


import App from './App.vue';
import { registerSW } from 'virtual:pwa-register';
import Admin from './Admin.vue';
import Alert from './components/global/alert/AlertNormal.vue';
import AlertError from './components/global/alert/AlertError.vue';

const app = createApp({});

registerSW();
//Pinia
const pinia = createPinia();
app.use(pinia);

app.component('App', App);
app.component('Admin', Admin);
app.component('Alert', Alert);
app.component('AlertError', AlertError);
app.use(router);
app.use(vuetify,{
  lang: {
    locales: { es },
    current: 'es-mx',
  },
});

app.config.globalProperties.$formatDate = (value) => {
  return moment(value)
    .format("DD/MM/YYYY")
    .toUpperCase()
    .replace(".", "");
};

app.config.globalProperties.$formatDatetime = (value) => {
  return moment(value)
    .format("DD/MM/YYYY h:mm A")
    .toUpperCase()
    .replace(".", "");
};


app.mount('#app');