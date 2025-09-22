import axios from "axios";
import { defineStore } from "pinia";

export const usePlannerStore = defineStore("planner", {
    state: () => ({
        projects: [],
        project: null,
        isLoading: false,
        projectId: null,
        isOpenModal: false,
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
        getProject(id) {
            this.isLoading = true;
            return new Promise((resolve, reject) => {
                axios.get('projects/get', { params: { id } })
                    .then((response) => {
                        this.project = response.data.project;
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
        setProjectId(id) {
            this.projectId = id;
        },
        updateCard(params) {
            return new Promise((resolve, reject) => {
                axios.post('projects/update-card', params)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        openModal(status) {
            this.isOpenModal = status;
        },

        addProject(params) {
            return new Promise((resolve, reject) => {
                axios.post('projects/store', params)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        }
    }
});
