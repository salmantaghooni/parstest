export default function addDash(number) {
    if ( number != undefined && number != null  && number != "null" ) {
        return number.substring(0, 4) +  `${'\xa0'.repeat(3)}` +
            number.substring(4, 8) +  `${'\xa0'.repeat(3)}` +
            number.substring(8, 12) +  `${'\xa0'.repeat(3)}` +
            number.substring(12, 16);
    }
}
