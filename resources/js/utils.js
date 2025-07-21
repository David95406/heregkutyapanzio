export function toMySqlDateTime(date) {
    return new Date(date).toISOString().slice(0, 19).replace('T', ' ');
}

export function getDayFromDate(date) {
    return new Date(date).getDate()
}

export function getBookingType(start, end) { // use class
    return getDayFromDate(start) == getDayFromDate(end) ? "Napközi" : "Panzió"
}
