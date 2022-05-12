import { defineStore } from 'pinia'

export const useCart = defineStore('cart', {
  state: () => ({
    items: [],
    total: 0,
    subTotal: 0,
    totalItems: 0,
    products: [],
    delivery: 0
  }),

  getters: {
    getSubTotal: (state) => {
      let i  = 0;
      state.subTotal = 0;
      for (i = 0; i < state.items.length; i++) {
        state.subTotal+= Number(state.items[i].price) * Number(state.items[i].quantity)
      }
      return state.subTotal.toFixed(2)
    },

    getTotal: (state) => {
      return state.total = Number(state.delivery) ? Number(state.delivery) + Number(state.subTotal) : Number(state.subTotal)
    },

    getTotalItems: (state) => {
      let i  = 0;
      state.totalItems = 0;
      for (i = 0; i < state.items.length; i++) {
        state.totalItems+= Number(state.items[i].quantity)
      }
      return state.totalItems
    }
  },

  actions: {
    // addToCart(id) {
    //   if (this.props.products[id].quantity === null) {
    //     this.props.products[id].quantity = 1
    //     this.items.push(this.props.products[id])
    //     this.total++
    //     console.log(this.props.products)
    //   } else {
    //     this.props.products[id].quantity++
    //     this.total++
    //     console.log(this.props.products)
    //   }
    // },

    addCart(id, index) {
      let item = this.items.find(product => product.id == id);
      console.log('item is: ' + item)
      if (item) {
        item.quantity++
      } else {
        let p = this.products.find((product) => product.id == id)
        console.log(p)
        p.quantity = 1
        this.items.push(p);
      }
    },

    getProps(props) {          //Function to assign props state
      this.products = props.products
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
        storage: localStorage,
      },
    ],
  }
})
