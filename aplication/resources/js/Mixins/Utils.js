export default {
  methods: {
    isDate(hora) {
      if (!hora) {
        return "__/__/___";
      }
      // Converte a data para o fuso de São Paulo
      let data = new Date(hora);
      // Corrige para UTC-3 (considerando horário de Brasília)
      let options = { timeZone: "America/Sao_Paulo" };
      let formatter = new Intl.DateTimeFormat("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        ...options,
      });

      return formatter.format(data);
    },
  },
};
