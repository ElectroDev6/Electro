class SaleCountdown {
  constructor() {
    this.timerElements = document.querySelectorAll(".sale__time");
    this.init();
  }

  init() {
    this.initializeCountdown();
  }

  initializeCountdown() {
    this.timerElements.forEach((element) => {
      const endDate = element.dataset.end;
      const startDate = element.dataset.start;

      if (endDate) {
        this.startCountdown(element, new Date(endDate).getTime(), "Đã kết thúc", (days, hours, minutes, seconds) => {
          element.innerHTML = this.renderBoxes(days, hours, minutes, seconds);
        });
      } else if (startDate) {
        this.startCountdown(element, new Date(startDate).getTime(), "Đã bắt đầu", (days, hours, minutes, seconds) => {
          element.innerHTML = this.renderBoxes(days, hours, minutes, seconds);
        });
      }
    });
  }

  startCountdown(element, targetTime, endMessage, updateCallback) {
    const interval = setInterval(() => {
      const now = new Date().getTime();
      const distance = targetTime - now;
      if (distance < 0) {
        element.innerHTML = `<span class="ended">${endMessage}</span>`;
        clearInterval(interval);
        return;
      }
      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);
      updateCallback(days, hours, minutes, seconds);
    }, 1000);
  }

  renderBoxes(days, hours, minutes, seconds) {
    return `
      <span class="time-box"><span class="number">${days}</span><span class="label">Ngày</span></span>
      <span class="time-box"><span class="number">${hours}</span><span class="label">Giờ</span></span>
      <span class="time-box"><span class="number">${minutes}</span><span class="label">Phút</span></span>
      <span class="time-box"><span class="number">${seconds}</span><span class="label">Giây</span></span>
    `;
  }
}

export default SaleCountdown;
