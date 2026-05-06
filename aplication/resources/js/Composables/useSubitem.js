import { ref } from 'vue';
import axios from 'axios';

export function useSubitem() {
    const dados = ref(null);
    const carregando = ref(false);

    async function index() {
        carregando.value = true;

        try {
            const res = await axios.get(route('subitem.index'));
            return res.data;
        } catch (error) {
            console.error("Axios erro:", err);
            return { sucesso: false, msg: err.response?.data?.message || "Erro desconhecido" };
        } finally { carregando.value = false }
    }

    return {
        dados,
        carregando,
        index,
    };
}