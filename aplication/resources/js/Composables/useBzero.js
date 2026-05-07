import { ref } from 'vue';
import axios from 'axios';

export function useBzero() {
    const dados = ref(null);
    const carregando = ref(false);

    async function carregarDados() {
        carregando.value = true;

        try {
            const res = await axios.get(route('bzero.index'));
            return res.data;
        } catch (error) {
            console.error("Axios erro:", err);
            return { sucesso: false, msg: err.response?.data?.message || "Erro desconhecido" };
        } finally { carregando.value = false }
    }
    async function inserirBzero(bzero) {
        carregando.value = true;

        try {
            const res = await axios.post(route('bzero.store'), bzero);
            return res.data;
        } catch (err) {
            console.error("Axios erro:", err);
            return { sucesso: false, msg: err.response?.data?.message || "Erro desconhecido" };
        } finally { carregando.value = false }
    }
    async function associarPlataforma(plataformaId) {
        carregando.value = true;

        try {
            const res = await axios.post(route("associar.plataforma", { id: idBzero }), {
                plataforma_id: plataformaId
            });
    
            if (res.data.success) {
                await carregarDados();
                return { sucesso: true, msg: res.data.message };
            }
            return { sucesso: false, msg: res.data.message };
        } catch (err) {
            console.error("Axios erro:", err);
            return { sucesso: false, msg: err.response?.data?.message || "Erro desconhecido" };
        } finally { carregando.value = false }
    }
    async function filtrarBases(filtros) {
        carregando.value = true;
        
        try {
            const res = await axios.post(route("bzero.filtro"), filtros);
            dados.value = res.data.data;
            return { sucesso: true, data: res.data.data };
        } catch (err) {
            console.error("Axios erro:", err);
            return { sucesso: false, msg: err.response?.data?.message || "Erro desconhecido" };
        } finally { carregando.value = false }
    }
    async function deletarBzero(id) {
        carregando.value = true;
        
        try {
            const res = await axios.delete(route("bzero.destroy", { id: id }));
            return res.data;
        } catch (err) {
            console.error("Axios erro:", err);
            return { sucesso: false, msg: err.response?.data?.message || "Erro desconhecido" };
        } finally { carregando.value = false }
    }

    return {
        dados,
        carregando,
        carregarDados,
        filtrarBases,
        inserirBzero,
        associarPlataforma,
        deletarBzero
    };
}