import axios from "axios";
import { onMounted, ref, reactive, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useRemember } from '@inertiajs/inertia-vue3'

export default function useStore(props) {
  const total = ref(0);
  const subTotal = ref(0);
  const items = reactive([]);
  // const items = useRemember([]);

  const addToCart = (id) => {
    if (!props.products[id-1].quantity) {
      props.products[id-1].quantity = 1
      items.push(props.products[id-1])
      total.value++
    } else {
      props.products[id-1].quantity++
      total.value++
    }
  }

  const removeFromCart = (id) => {
    if (props.products[id-1].quantity > 1) {
      props.products[id-1].quantity--
      total.value--
    } else {
      const i = items.lastIndexOf(props.products[id-1])
      props.products[id-1].quantity = null
      if (i > -1) items.splice(i, 1)
      total.value--
    }


  }

  const getTotal = () => {
    let i  = 0;
    subTotal.value = 0
    for (i = 0; i<items.length; i++) {
      subTotal.value+= Number(items[i].price) * Number(items[i].quantity)
    }

  }


  return {
    total,
    items,
    getTotal,
    removeFromCart,
    subTotal,
    addToCart
  }
}
