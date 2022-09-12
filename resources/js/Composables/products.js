import axios from "axios";
import { ref, computed } from "vue";

export default function useProducts(props) {
    const prod = ref(props.products);
    const active = ref([]);
    const searchQuery = ref("");
    const filteredProducts = computed(() => {
        if (searchQuery.value === "") {
            return prod.value;
        }
        return props.products.filter((product) => {
            return (
                product.name
                    .toLowerCase()
                    .indexOf(searchQuery.value.toLowerCase()) != -1
            );
        });
    });
    const filter = async (id) => {
        searchQuery.value = "";
        active.value = [];
        let response = await axios.get("/products/filter/" + id);
        prod.value = response.data;
        active.value[id] = true;
    };

    const resetCategory = () => {
        searchQuery.value = "";
        prod.value = props.products;
        active.value = [];
    };

    return {
        filter,
        active,
        prod,
        searchQuery,
        resetCategory,
        filteredProducts,
    };
}
