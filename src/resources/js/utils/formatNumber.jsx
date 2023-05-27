export default function formatNumber(e) {
    if (typeof e === 'string')
        return e.replace(/(.)(?=(\d{3})+$)/g, '$1,');
    else if (e != undefined)
        return e.toString().replace(/(.)(?=(\d{3})+$)/g, '$1,');
}