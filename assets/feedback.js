document.addEventListener("DOMContentLoaded", function() {
    const slider = document.querySelector(".testimonial-slider");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");

    nextBtn.addEventListener("click", () => {
        slider.scrollBy({ left: 350, behavior: "smooth" });
    });

    prevBtn.addEventListener("click", () => {
        slider.scrollBy({ left: -350, behavior: "smooth" });
    });
});
