import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    hamburgerButton();
    slider();
});

//fungsi untuk menangani tombol navbar responsif
function hamburgerButton() {
    document
        .getElementById("menu-toggle")
        .addEventListener("click", function () {
            var menu = document.getElementById("mobile-menu");
            var icon = document.getElementById("menu-icon");
            if (menu.classList.contains("hidden")) {
                menu.classList.remove("hidden");
                menu.classList.add("slide-down-enter");
                setTimeout(function () {
                    menu.classList.add("slide-down-enter-active");
                }, 10);
                setTimeout(function () {
                    menu.classList.remove(
                        "slide-down-enter",
                        "slide-down-enter-active"
                    );
                }, 510);
                icon.classList.remove("fa-bars");
                icon.classList.add("fa-times");
            } else {
                menu.classList.add("slide-down-exit");
                setTimeout(function () {
                    menu.classList.add("slide-down-exit-active");
                }, 10);
                setTimeout(function () {
                    menu.classList.remove(
                        "slide-down-exit",
                        "slide-down-exit-active"
                    );
                    menu.classList.add("hidden");
                }, 510);
                icon.classList.remove("fa-times");
                icon.classList.add("fa-bars");
            }
        });
}

function slider() {
    let sliderContainer = document.getElementById("sliderContainer");
    let slider = document.getElementById("slider");
    let cards = slider.getElementsByTagName("li");

    let elementToShow = 0;
    if (document.body.clientWidth>1000) {
        elementToShow = 3;
    }

    if (document.body.clientWidth<1000 && document.body.clientWidth>600) {
        elementToShow = 2;
    }

    if (document.body.clientWidth<600) {
        elementToShow = 1;
    }

    let sliderContainerWidth = sliderContainer.clientWidth;

    let cardWidth = sliderContainerWidth / elementToShow;

    slider.style.width = cards.length * cardWidth + "px";
    slider.style.transition = "margin";
    slider.style.transitionDuration = "0.5s";

    for (let index = 0; index < cards.length; index++) {
        const element = cards[index];
        element.style.width = cardWidth + "px";
    }

    let prevButton = document.querySelector(".prev-slider");
    let nextButton = document.querySelector(".next-slider");

    prevButton.addEventListener("click", prev);
    nextButton.addEventListener("click", next);

    function updateButtonStates(prevDisabled, nextDisabled) {
        prevButton.style.cursor = prevDisabled ? "not-allowed" : "pointer";
        prevButton.disabled = prevDisabled;
        prevButton.style.opacity = prevDisabled ? "0.5" : "1";
    
        nextButton.style.cursor = nextDisabled ? "not-allowed" : "pointer";
        nextButton.disabled = nextDisabled;
        nextButton.style.opacity = nextDisabled ? "0.5" : "1";
    }
    
    function updateSliderWidth(sliceValue) {
        return document.body.clientWidth > 1000 ? sliceValue.slice(0, -4) : sliceValue.slice(0, -2);
    }
    
    function prev() {
        let marginLeft = +updateSliderWidth(slider.style.marginLeft);
        let maxShift = -cardWidth * (cards.length - (document.body.clientWidth > 1000 ? elementToShow + 1 : elementToShow));
        
        if (marginLeft > maxShift) {
            slider.style.marginLeft = (marginLeft - cardWidth) + "px";
            updateButtonStates(false, false);
        } else {
            updateButtonStates(true, false);
        }
    }
    
    function next() {
        let marginLeft = +updateSliderWidth(slider.style.marginLeft);

        if (marginLeft < 0) {
            slider.style.marginLeft = (marginLeft + cardWidth) + "px";
            updateButtonStates(false, false);
        } else {
            updateButtonStates(false, true);
        }
    }
    
    // Initialize button states
    updateButtonStates(false, true);
    
}
