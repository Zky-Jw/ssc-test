export const formatDueDate = (datetimeStr) => {
    const date = new Date(datetimeStr);

    const day = new Intl.DateTimeFormat("id-ID", { weekday: "long" }).format(
        date
    );
    const datePart = new Intl.DateTimeFormat("id-ID", {
        day: "2-digit",
        month: "long",
        year: "numeric",
    }).format(date);

    const hour = String(date.getHours()).padStart(2, "0");
    const minute = String(date.getMinutes()).padStart(2, "0");

    return `${day}, ${datePart}, ${hour}.${minute}`;
};

export const formatDuration = (start, end) => {
    const startDate = new Date(start);
    const endDate = new Date(end);
    const diffMs = endDate - startDate;

    // const diffSec = Math.floor(diffMs / 1000);
    const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
    const diffHours = Math.floor((diffMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));

    let result = '';
    // if (diffSec > 0) result += diffSec + ' detik ';
    if (diffDays > 0) result += diffDays + ' hari ';
    if (diffHours > 0) result += diffHours + ' jam ';
    if (diffMinutes > 0 && diffDays === 0) result += diffMinutes + ' menit';

    console.log("result duration : ", result)

    return result.trim() || '0 jam';
};
