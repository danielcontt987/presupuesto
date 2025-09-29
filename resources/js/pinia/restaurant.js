// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useRestauratStore = defineStore('restaurant', {
    state: () => ({
        tables: [],
        items: [],
        products: [],
        categories: [],
        commands: [],
        commandsCook: [],
        statuses: [],
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
                    this.commands = response.data.items;
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

        listCategories() {
            return new Promise((resolve, reject) => {
                axios.post("restaurant/categories").then((response) => {
                    resolve(response);
                    this.categories = response.data.categories;
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        addToAccount(payload) {
            return new Promise((resolve, reject) => {
                axios.post("restaurant/add-to-account", payload).then((response) => {
                    this.items = [];
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        listItemCook() {
            return new Promise((resolve, reject) => {
                axios.get("restaurant/list-item-cook").then((response) => {
                    this.commandsCook = response.data.items.orders;
                    this.statuses = response.data.items.statuses;
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },
    }
});