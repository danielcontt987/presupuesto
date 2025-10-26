import './bootstrap';
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';
import { createApp, ref } from 'vue';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import router from './router/index.js';
import { es } from "vuetify/locale";
import moment from 'moment';

//Pinia
import { createPinia } from 'pinia';

const customLightTheme = {
  colors: {
    cardColor: "#FFFFFF",
    primary: "#192a67",
    primaryBg: "#192a67",
    colorChip: "#192a67",
    colorText: "#192a67",
    secondary: "#3E47A3",
    blueSky: '#ecf2ff',
    background: "#EFF3F8",
    backgroundColor: '#EFF3F8',
    white: '#FFFFFF',
    background_drawer: "#FFF",
    background_nav: "#ffffff",
    text_grey: "#7f7c87",
    background_color: "#EDECF4",
    grey_dark: "#5b5867",
    greyLight: '#92969e',
    greyDate: "#4B5563",
    greyDense: "#F9FAFB",
    greyIcon: "#767D8A",
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
    greyDark: "#afafaf",
    greySpan: "#484848",
    rose: "#fcd6e6",
    greenLight3: "#c2f8d6",
    sky: "#DBEAFE"

  },
};
const customDarkTheme = {
  dark: true,
  colors: {
    primary: "#090717",
    // primary: "#1A2537",
    primaryBg: "#4361EE",
    chipCard: "#4361EE",
    cardColor: "#151126",
    fail: '#F50057',
    colorText: "#FFFFFF",



    white: "#fff",
    background: "#090717",
    // background: "#1F2A3D",
    background_color: "#25293c",
    background_drawer: "#2e3248",
    purple_primary: "#9c5df9",
    grey_dark: "#acb0cc",
    purple_dark: "#8436f7",

    purple_light2: "#313258",
    purple_dark_accent: "#7367f0",

    blue_light_sky: "#1f4357",
    aqua_normal: "#00cfe8",

    orange_light2: "#483b3d",
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
import Admin from './Admin.vue';
import Alert from './components/global/alert/AlertNormal.vue';
import AlertError from './components/global/alert/AlertError.vue';

const app = createApp({});

//Pinia
const pinia = createPinia();
app.use(pinia);

app.component('App', App);
app.component('Admin', Admin);
app.component('Alert', Alert);
app.component('AlertError', AlertError);
app.use(router);
app.use(vuetify, {
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