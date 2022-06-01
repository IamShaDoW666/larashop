import { unformat } from 'accounting-js';
import { defineStore } from 'pinia';


export const useCart = defineStore('cart', {
  state: () => ({
    items: [],
    total: 0,
    subTotal: 0,
    totalItems: 0,
    products: [],
    delivery: 0,
  }),

  getters: {
    getSubTotal: (state) => {
      let i  = 0;
      state.subTotal = 0;
      for (i = 0; i < state.items.length; i++) {
        state.subTotal+= unformat(state.items[i].price) * unformat(state.items[i].quantity)
      }
      return state.subTotal.toFixed(2)
    },

    getTotal: (state) => {
      return state.total = unformat(state.delivery) ? unformat(state.delivery) + unformat(state.subTotal) : unformat(state.subTotal)
    },

    getTotalItems: (state) => {
      let i  = 0;
      state.totalItems = 0;
      for (i = 0; i < state.items.length; i++) {
        state.totalItems+= unformat(state.items[i].quantity)
      }
      return state.totalItems
    }
  },

  actions: {

    addCart(id, index) {
      let item = this.items.find(product => product.id == id);
      if (item) {
        item.quantity++
      } else {
        let p = this.products.find((product) => product.id == id)
        p.quantity = 1
        this.items.push(p);
      }
    },

    getProps(props) {          //Function to assign props state
      this.products = props.products
    },

    getCart() {
      return {
        items: this.items,
        subTotal: this.subTotal,
        totalItems: this.totalItems,
        delivery: unformat(this.delivery),
        total: this.total
      }
    },

    resetDelivery() {
      this.delivery = 0
    },

    removeFromCart(id, index) {
      let item = this.items.find(product => product.id == id);
      if (item) {
        if (item.quantity == 1) {
          this.items.splice(index, 1)
        } else {
          item.quantity--
        }
      }
      // const i = this.items.lastIndexOf(id)
      // if (i > -1) this.items.splice(i, 1)
    }
  },
  persist: {
    enabled: true,
    strategies: [
      {
        storage: sessionStorage,
      },
    ],
  }
})
