// Giao diện trang chủ

// thời gian đếm ngược
const targetDate = new Date();
targetDate.setHours(targetDate.getHours() + 24);

function updateCountdown() {
  const now = new Date();
  const timeDifference = targetDate - now;

  if (timeDifference <= 0) {
    clearInterval(countdownInterval);
    document.querySelectorAll(".dealhot-content h4").forEach((h4) => {
      h4.textContent = "Hết thời gian!";
    });
    return;
  }

  const hours = Math.floor(
    (timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

  document.querySelectorAll(".countdown").forEach((countdown) => {
    countdown.querySelector(".hours").textContent = hours
      .toString()
      .padStart(2, "0");
    countdown.querySelector(".minutes").textContent = minutes
      .toString()
      .padStart(2, "0");
    countdown.querySelector(".seconds").textContent = seconds
      .toString()
      .padStart(2, "0");
  });
}
updateCountdown();
const countdownInterval = setInterval(updateCountdown, 1000);

// ===== GIỚI THIỆU =====

// CÂU HỎI THƯỜNG GẶP
document.querySelectorAll(".list-question").forEach((question) => {
  question.addEventListener("click", () => {
    const answer = question.nextElementSibling; // Lấy phần tử kế tiếp (list-answer)
    answer.classList.toggle("active"); // Thêm hoặc xóa class 'active'
    const icon = question.querySelector("i"); // Lấy icon bên trong câu hỏi
    icon.style.transform =
      icon.style.transform === "rotate(0deg)"
        ? "rotate(180deg)"
        : "rotate(0deg)";
  });
});
