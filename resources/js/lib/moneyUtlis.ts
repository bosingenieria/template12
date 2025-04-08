// src/utils/dateUtils.ts

export function formatoMoneda(valor: number): string {
    return new Intl.NumberFormat("es-CO", {
        style: "currency",
        currency: "COP",
    }).format(valor);
};