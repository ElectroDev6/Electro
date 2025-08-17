export default class Countdown {
  constructor(container) {
    this.container = container;
    this.endDate = new Date(container.dataset.endDate);
    this.daysEl = container.querySelector(".days");
    this.hoursEl = container.querySelector(".hours");
    this.minutesEl = container.querySelector(".minutes");
    this.secondsEl = container.querySelector(".seconds");
    this.timer = null;

    this.start();
  }

  start() {
    this.update();
    this.timer = setInterval(() => this.update(), 1000);
  }

  update() {
    const now = new Date();
    const distance = this.endDate - now;

    if (distance <= 0) {
      clearInterval(this.timer);
      this.daysEl.textContent = "00";
      this.hoursEl.textContent = "00";
      this.minutesEl.textContent = "00";
      this.secondsEl.textContent = "00";
      return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((distance / (1000 * 60)) % 60);
    const seconds = Math.floor((distance / 1000) % 60);

    this.daysEl.textContent = this.format(days);
    this.hoursEl.textContent = this.format(hours);
    this.minutesEl.textContent = this.format(minutes);
    this.secondsEl.textContent = this.format(seconds);
  }

  format(num) {
    return num.toString().padStart(2, "0");
  }
}
