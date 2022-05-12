import { defineStore } from 'pinia'

export const useModals = defineStore('modals', {
  state: () => ({
    showCategoryModal: false,
    showProductModal: false,

  }),

  getters: {
    getCat(state) {
      return state.showCategoryModal;
    },

    getProd(state) {
      return state.showProductModal;
    }
  },

  actions: {
    toggleCategory() {
      this.showCategoryModal = !this.showCategoryModal;
      getCat()
    },

    toggleProduct() {
      this.showProductModal = !this.showProductModal;
    }
  }
})
