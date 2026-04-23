// src/Composables/useBzero.js
import { ref } from 'vue';
import axios from 'axios';

export function useBzero(idBzero){
    const dados = ref(null);
    const carregando = ref(false);

    async function carregarDados() {
        carregando.value = true;
        const res = await axios.get(route('bzero.index', idBzero));
        dados.value = res.data;
        carregando.value = false;
    }
    async function associarPlataforma(plataformaId) {
        const res = await axios.post(route("associar.plataforma", { id: idBzero }), {
            plataforma_id: plataformaId
        });

        if (res.data.success) {
            await carregarDados();
            return { sucesso: true, msg: res.data.message };
        }
        return { sucesso: false, msg: res.data.message };
    }

    async function removerPlataforma(id) {}

    return {
        dados,
        carregando,
        carregarDados,
        associarPlataforma,
        removerPlataforma
    };
}