// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useProductStore = defineStore('product', {
    state: () => ({
        openModal: false,
        products: [],
    }),
    actions: {
        storeProduct(payload) {
            return new Promise((resolve, reject) => {
                axios.post("product/store", payload).then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        listProducts() {
            return new Promise((resolve, reject) => {
                axios.post("product/list")
                    .then((response) => {
                        this.products = response.data.products.map(product => ({
                            ...product,
                            quantity: 1
                        }));
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },

        consultProducts(payload) {

            return new Promise((resolve, reject) => {
                axios.post("product/search", payload)
                    .then((response) => {
                        if (response.data.products.length > 0) {
                            this.products = response.data.products.map(product => ({
                                ...product,
                                quantity: 1
                            }));
                            resolve(response);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },

        listCategory() {
            return new Promise((resolve, reject) => {
                axios.post("category/list").then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        storeCategory(payload) {
            return new Promise((resolve, reject) => {
                axios.post("category/store", payload).then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },
        openDialogCategory(payload) {
            this.openModal = payload;
        },
        closeopenDialog(payload) {
            this.openModal = payload;
        },

        listProductsByCategory(categoryId) {
            return new Promise((resolve, reject) => {
                axios.post("product/list-by-category", { category_id: categoryId })
                    .then((response) => {
                        this.products = response.data.products.map(product => ({
                            ...product,
                            quantity: 1
                        }));
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        }
    }
});
