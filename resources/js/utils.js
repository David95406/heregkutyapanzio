function fixVDatePicker(date) {
    date.setDate(date.getDate() + 1);
    return date;
}

export function toMySqlDateTime(date) {
    return fixVDatePicker(new Date(date)).toISOString().slice(0, 19).replace('T', ' ');
}

export function getDayFromDate(date) {
    return new Date(date).getDate()
}

export function getBookingType(start, end) { // use class
    return getDayFromDate(start) == getDayFromDate(end) ? "Napközi" : "Panzió"
}

export function formatDate(date) {
    console.log(date)
    date = new Date(date)
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}`;
}
