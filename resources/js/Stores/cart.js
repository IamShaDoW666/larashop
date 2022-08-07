import { unformat } from "accounting-js";
import { defineStore } from "pinia";

export const useCart = defineStore("cart", {
    state: () => ({
        items: [],
        total: 0,
        subTotal: 0,
        totalItems: 0,
        products: [],
        tax: 0,
        minimum_order: 0,
        delivery: 0,
    }),

    getters: {
        getSubTotal: (state) => {
            let i = 0;
            state.subTotal = 0;
            for (i = 0; i < state.items.length; i++) {
                state.subTotal +=
                    unformat(state.items[i].price) *
                    unformat(state.items[i].quantity);
            }
            return state.subTotal.toFixed(2);
        },

        getTotal: (state) => {
            let sum = unformat(state.subTotal);
            if (state.tax) {
                sum += (unformat(state.subTotal) * state.tax) / 100;
            }
            if (state.delivery) {
                return sum += unformat(state.delivery);
            }
            
            return sum;
        },

        getTotalItems: (state) => {
            let i = 0;
            state.totalItems = 0;
            for (i = 0; i < state.items.length; i++) {
                state.totalItems += unformat(state.items[i].quantity);
            }
            return state.totalItems;
        },

        getTaxValue: (state) => {
            return state.tax ? (unformat(state.subTotal) * state.tax) / 100 : null;
        },
        
        isAboveMinimum: (state) => {
            if (state.minimum_order) {
                return state.subTotal >= state.minimum_order;            
            }

            return null
        }
    },

    actions: {
        addCart(product, variant_id = null) {
            let item = null;

            if (!variant_id) {
                item = this.items.find((item) => item.id == product.id);

                if (!item) {
                    let productObject = {
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        image_path: product.image_path,
                        variantId: null,
                        quantity: 1,
                    };
                    this.items.push(productObject);
                } else {
                    item.quantity++;
                }
            } else {
                let variant = product.variants?.find((v) => v.id == variant_id);

                item = this.items.find(
                    (item) => item.name == `${product?.name} ${variant?.name}`
                );

                if (!item) {
                    item = this.items.find(
                        (item) => item.variantId == variant_id
                    );
                }

                if (!item) {
                    let productObject = {
                        id: product.id,
                        name: `${product.name} ${variant.name}`,
                        price: variant.price,
                        image_path: product.image_path,
                        quantity: 1,
                        variantId: variant_id,
                    };
                    this.items.push(productObject);
                } else {
                    item.quantity++;
                }
            }          
        },

        getItemQty(id) {
            return this.items.find((item) => item.id == id)?.quantity ?? 0;
        },

        getItem(id) {
            return this.items.find((item) => item.id == id) ?? null;
        },

        getProps(props) {
            //Function to assign props state
            this.products = props.products;
            this.minimum_order = Number(props.restaurant.config.minimum_order);
            this.tax = Number(props.restaurant.config.tax)
        },

        getCart() {
            return {
                items: this.items,
                subTotal: this.subTotal,
                totalItems: this.totalItems,
                minimum_order: this.minimum_order,
                delivery: unformat(this.delivery),
                total: this.total,
            };
        },

        resetDelivery() {
            this.delivery = 0;
        },

        removeFromCart(p, variant_id, idx) {
            console.log(p, variant_id, idx);
            if (!variant_id) {
                let item = this.items.find((item) => item.id == p.id);
                if (item) {
                    if (item.quantity == 1) {
                        this.items.splice(idx, 1);
                    } else {
                        item.quantity--;
                    }
                }
            } else {
                let item = this.items.find(
                    (item) => item.variantId == variant_id
                );
                if (item) {
                    if (item.quantity == 1) {
                        this.items.splice(idx, 1);
                    } else {
                        item.quantity--;
                    }
                }
            }
        },
    },
    persist: {
        enabled: true,
        strategies: [
            {
                storage: sessionStorage,
            },
        ],
    },
});
