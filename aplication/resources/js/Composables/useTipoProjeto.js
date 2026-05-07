import { ref } from 'vue';
import axios from 'axios';

export function useTipoProjeto() {
    const carregando = ref(false);

    async function index() {
        carregando.value = true;
        
        try {
            const res = await axios.get(route("tipoprojeto.index"));
            console.log(res);
            return res.data;
        } catch (err) {
            console.error("Axios erro:", err);
            return { sucesso: false, msg: err.response?.data?.message || "Erro desconhecido" };
        } finally { carregando.value = false }
    }

    async function ofSelect() {
        carregando.value = true;

        try {
            const res = await axios.get(route("tipoprojeto.ofselect"));
            console.log(res);
            return res.data || res;
        } catch (err) {
            console.error("Axios erro:", err);
            return { sucesso: false, msg: err.response?.data?.message || "Erro desconhecido" };
        } finally { carregando.value = false }
    }

    async function store(projeto) {
        carregando.value = true;

        try {
            const res = await axios.post(route("projeto.store"), projeto);
            console.log(res);
            return res.data;
        } catch (err) {
            console.error("Axios erro:", err);
            return { sucesso: false, msg: err.response?.data?.message || "Erro desconhecido" };
        } finally { carregando.value = false }
    }

    return {
        carregando,
        index,
        ofSelect,
        store,
    };
}