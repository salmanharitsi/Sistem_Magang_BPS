
document.addEventListener("DOMContentLoaded", function () {
    highlightActiveMenuItem();
});

//fungsi memberikan highlight ke menu yg sedang dipilih
function highlightActiveMenuItem() {
    const links = document.querySelectorAll("a.menu-item");
    links.forEach((link) =>
        window.location.pathname.includes(link.getAttribute("href"))
            ? link
                  .classList.add("bg-gradient-to-r", "from-blue-200", "to-blue-400", "text-blue-600", "font-regular", "dark:text-gray-700", "dark:from-green-200", "dark:to-green-300")
            : link
                  .classList.remove("bg-blue-50", "text-blue-600")
    );
}