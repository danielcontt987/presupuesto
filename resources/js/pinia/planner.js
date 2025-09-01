import axios from "axios";
import { defineStore } from "pinia";

export const usePlannerStore = defineStore("planner", {
    state: () => ({
        projects: [],
        isLoading: false,
    }),
    actions: {
        listProject() {
            this.isLoading = true;
            return new Promise((resolve, reject) => {
                axios.get('projects/list')
                    .then((response) => {
                        this.projects = response.data.projects;
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            });
        },
    },
});
