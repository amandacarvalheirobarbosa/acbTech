function formatMoney(money) {
  var formattedMoney = money.toString().replace(/\D/g, "");
  formattedMoney = formattedMoney.replace(/(\d{2})$/, ",$1");
  formattedMoney = formattedMoney.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
  return formattedMoney;
}

function updateMoneyField(input) {
  var money = input.value;
  var formattedMoney = formatMoney(money);
  input.value = formattedMoney;
}
