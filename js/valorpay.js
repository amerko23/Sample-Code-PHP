const form = document.getElementById('valorpay-app');

function formatValue() {
  const inputValue = document.getElementById('amount').value;
  const formattedValue = amtVal(inputValue);
  document.getElementById('amount').value = formattedValue;
}

function amtVal(val) {
  const data = (val || '').toString().replace(/\D+/g, '').slice(0, 7);
  return data ? (parseFloat(data) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') : '0.00';
}

function formSubmitAction(event) {
  event.preventDefault();
  let formData = new FormData(form);
  const appId = formData.get('appid');
  const appKey = formData.get('appkey');
  const epiId = formData.get('epi');
  const amount = formData.get('amount');
  if (Number(amount) <= 0) {
    alert('Enter Amount is Minimum $0.01');
    return;
  }

  if (!appId || !appKey || !epiId || !amount) {
    alert('Invalid form data');
    return;
  }

  const url = 'https://securelink-staging.valorpaytech.com:4430//';
  const data = { appid: appId, appkey: appKey, epi: epiId, txn_type: 'clientToken' };
  const queryString = new URLSearchParams(data).toString();

  fetch(`https://securelink-staging.valorpaytech.com:4430//?${queryString}`, {
    method: 'POST',
    body: JSON.stringify(data),
    headers: {
      Accept: '*/*',
    },
  })
    .then(response => response.json())
    .then(data => {
      console.log(data);
      if (!data.error_no || data.error_no !== 'S00') {
        alert('Unable to generate payment client ID');
        return;
      }
      setCookie('valorClientToken', data.clientToken, 5);
      setCookie('valorAmount', amount, 5);
      setCookie('valorEpi', epiId, 5);
      setCookie('valorAppId', appId, 5);
      setCookie('valorAppKey', appKey, 5);
      let baseUrl = window.location.href;
      if (baseUrl.includes('index')) {
        baseUrl = window.location.href.replace('index', 'pay');
      } else {
        baseUrl = window.location.href + 'pay.php';
      }
      window.location.href = baseUrl;
    })
    .catch(error => console.error(error));
}

form.addEventListener('submit', formSubmitAction);

function setCookie(name, value, min) {
  var expires = '';
  if (min) {
    var date = new Date();
    date.setTime(date.getTime() + min * 60 * 1000);
    expires = '; expires=' + date.toUTCString();
  }
  document.cookie = name + '=' + (value || '') + expires + '; path=/';
}
const startTime = parseInt(sessionStorage.getItem('startTime'));
if (startTime) {
  sessionStorage.removeItem('startTime');
}

const numberInput = document.getElementById('epi-id');

numberInput.addEventListener('input', event => {
  const input = event.target;
  const value = input.value.trim();

  // Replace any non-numeric characters with an empty string
  const newValue = value.replace(/[^0-9]/g, '');

  // Update the input value to only contain numeric characters
  input.value = newValue;
});
