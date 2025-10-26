import accounting from 'accounting';


function currency(value) {
    if (value >= 0) return accounting.formatMoney(value);
    else if (!!value) return accounting.formatMoney(Math.abs(value));
    else return accounting.formatMoney(0, "- $ ");
}

export default currency;