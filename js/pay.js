(function () {
  function getCookie(name) {
    var nameEQ = name + '=';
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  }

  const clientToken = getCookie('valorClientToken');
  if (!clientToken) {
    window.location.href = window.location.href.replace('pay.php', '');
  }

  // set start time in sessionStorage
  if (!sessionStorage.getItem('startTime')) {
    const startTime = new Date().getTime();
    sessionStorage.setItem('startTime', startTime);
  }

  // calculate remaining time
  const timeLimit = 5 * 60 * 1000; // 5 minutes in milliseconds
  const currentTime = new Date().getTime();
  const startTime = parseInt(sessionStorage.getItem('startTime'));
  const elapsedTime = currentTime - startTime;
  const remainingTime = timeLimit - elapsedTime;

  // start the timer
  let timerIntervalId;
  if (remainingTime > 0) {
    const timerElement = document.getElementById('countdown');
    timerElement.innerHTML = formatTime(remainingTime);
    timerIntervalId = setInterval(() => {
      const elapsedTime = new Date().getTime() - startTime;
      const remainingTime = timeLimit - elapsedTime;
      if (remainingTime < 0) {
        clearInterval(timerIntervalId);
        sessionStorage.removeItem('startTime');
        timerElement.innerHTML = 'Time expired';
        window.location.href = window.location.href.replace('pay.php', '');
      } else {
        timerElement.innerHTML = formatTime(remainingTime);
      }
    }, 1000);
  }

  function formatTime(time) {
    const minutes = Math.floor(time / (60 * 1000))
      .toString()
      .padStart(2, '0');
    const seconds = Math.floor((time % (60 * 1000)) / 1000)
      .toString()
      .padStart(2, '0');
    return `${minutes}:${seconds}`;
  }
  // call every second
})();
