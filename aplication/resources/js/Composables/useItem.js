import { ref } from 'vue';
import axios from 'axios';

export function useItem() {
    const dados = ref(null);
    const carregando = ref(false);

    async function carregarDados() {
        carregando.value = true;

        try {
            const res = await axios.get(route('item.index'));
            return res.data;
        } catch (error) {
            console.error("Axios erro:", err);
            return { sucesso: false, msg: err.response?.data?.message || "Erro desconhecido" };
        } finally { carregando.value = false }
    }

    return {
        dados,
        carregando,
        carregarDados
    };
}