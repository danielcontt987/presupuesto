// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useGlobals = defineStore('globals', {
    state: () => ({
        darkmode: false,
        drawer: false
    }),
    actions: {
        setDarkMode(payload) {
            this.darkmode = payload;
        },

        setDrawer(payload) {
            this.drawer = payload;
        }
    }
});
