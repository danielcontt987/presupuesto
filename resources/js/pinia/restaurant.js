// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useRestauratStore = defineStore('restaurant', {
    state: () => ({
        tables: [],
        items: [],
        products: [],
        selectedTable: null,
    }),
    actions: {
        listTables(payload) {
            return new Promise((resolve, reject) => {
                axios.post("restaurant/list", payload).then((response) => {
                    this.tables = response.data.tables;
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },
        listProducts(payload) {
            return new Promise((resolve, reject) => {
                axios.post("restaurant/products", payload).then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        listItems(payload) {
            return new Promise((resolve, reject) => {
                axios.post("restaurant/items", payload).then((response) => {
                    this.items = response.data.items;
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        setTable(table) {
            this.selectedTable = table;
        },

        addItem(item) {
            this.items.push(item);
        },
        removeItem(item) {
            const index = this.items.findIndex(i => i.id === item.id);
            if (index !== -1) {
                this.items.splice(index, 1);
            }
        },
    }
});