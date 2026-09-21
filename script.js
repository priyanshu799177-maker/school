/* ==========================================
   S.K.L Public School
   script.js - Part 3
========================================== */

// Welcome Message
window.onload = function () {
    alert("Welcome to S.K.L Public School Website");
};

// Back To Top Button
const topBtn = document.createElement("button");
topBtn.innerHTML = "⬆";
topBtn.id = "topBtn";
document.body.appendChild(topBtn);

topBtn.style.position = "fixed";
topBtn.style.bottom = "20px";
topBtn.style.right = "20px";
topBtn.style.padding = "12px 16px";
topBtn.style.fontSize = "20px";
topBtn.style.border = "none";
topBtn.style.borderRadius = "50%";
topBtn.style.background = "#004aad";
topBtn.style.color = "#fff";
topBtn.style.cursor = "pointer";
topBtn.style.display = "none";
topBtn.style.zIndex = "9999";

window.onscroll = function () {
    if (document.documentElement.scrollTop > 200) {
        topBtn.style.display = "block";
    } else {
        topBtn.style.display = "none";
    }
};

topBtn.onclick = function () {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
};

// Live Clock
function updateClock() {

    const now = new Date();

    const time = now.toLocaleTimeString();

    const clock = document.getElementById("clock");

    if (clock) {
        clock.innerHTML = time;
    }

}

setInterval(updateClock, 1000);

// Current Year in Footer
const year = document.getElementById("year");

if (year) {
    year.innerHTML = new Date().getFullYear();
}

// Dark Mode
const darkBtn = document.createElement("button");

darkBtn.innerHTML = "🌙";

darkBtn.style.position = "fixed";
darkBtn.style.bottom = "80px";
darkBtn.style.right = "20px";
darkBtn.style.padding = "10px";
darkBtn.style.border = "none";
darkBtn.style.borderRadius = "50%";
darkBtn.style.cursor = "pointer";
darkBtn.style.background = "#222";
darkBtn.style.color = "white";

document.body.appendChild(darkBtn);

darkBtn.onclick = function () {

    document.body.classList.toggle("dark-mode");

};

// Notice Marquee Pause
const marquee = document.querySelector("marquee");

if (marquee) {

    marquee.addEventListener("mouseover", function () {
        marquee.stop();
    });

    marquee.addEventListener("mouseout", function () {
        marquee.start();
    });

}

// Fade Animation
const observer = new IntersectionObserver((entries) => {

    entries.forEach(entry => {

        if (entry.isIntersecting) {

            entry.target.style.opacity = "1";
            entry.target.style.transform = "translateY(0)";

        }

    });

});

document.querySelectorAll("section").forEach(section => {

    section.style.opacity = "0";
    section.style.transform = "translateY(50px)";
    section.style.transition = "1s";

    observer.observe(section);

});

// Console Message
console.log("S.K.L Public School Website Loaded Successfully");