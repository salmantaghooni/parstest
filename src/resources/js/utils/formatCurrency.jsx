export default function  autocomma(number_input) {
    number_input += '';
    number_input = number_input.replace(',', ''); number_input = number_input.replace(',', ''); number_input = number_input.replace(',', '');
    number_input = number_input.replace(',', ''); number_input = number_input.replace(',', ''); number_input = number_input.replace(',', '');
    var x = number_input.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    return x1 + x2;
}
