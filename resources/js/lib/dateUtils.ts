// src/utils/dateUtils.ts
import dayjs, { Dayjs } from 'dayjs';
import utc from 'dayjs/plugin/utc';
import timezone from 'dayjs/plugin/timezone';
import relativeTime from 'dayjs/plugin/relativeTime';
import "dayjs/locale/es";

dayjs.locale("es");
dayjs.extend(relativeTime);
dayjs.extend(utc);
dayjs.extend(timezone);

// Función corregida con tipado estricto
export function formatDate(date: string | Date | number | Dayjs, format: string = 'YYYY-MM-DD'): string {
    return dayjs(date).format(format);
}


export function formatDateTimeMontString(date: string | Date | number | Dayjs, format: string = 'DD [de] MMMM [de] YYYY h:mm A'): string {
    return dayjs(date).format(format);
}