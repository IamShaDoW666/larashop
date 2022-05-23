import axios from "axios";
import { ref } from 'vue';

export default function useProducts(props) {
  const prod = ref(props.products);
  const active = ref([]);
  const filter = async (id) => {
    active.value = []
    let response = await axios.get('/products/filter/' + id)
    prod.value = response.data
    active.value[id] = true;


  }

  return {
    filter,
    active,
    prod
  }
}
