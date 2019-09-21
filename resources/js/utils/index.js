export const years = (startYear) =>
{
    let currentYear = new Date().getFullYear(), years = [];
    startYear = startYear || 2018;
    while ( startYear <= currentYear ) {
        years.push(startYear++);
    }
    return years;
}

export const jenisBuktiTransaksi = () =>
{
    return ['nota', 'bon'];
}
