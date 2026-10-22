const themeKey = "ermaya-theme";

function applyTheme(theme) {
    document.documentElement.classList.toggle("dark", theme === "dark");

    document.documentElement.style.colorScheme = theme;
}

const savedTheme = localStorage.getItem(themeKey);

applyTheme(savedTheme === "dark" ? "dark" : "light");

document.addEventListener("click", (event) => {
    const toggle = event.target.closest("[data-theme-toggle]");

    if (!toggle) return;

    const isDark = document.documentElement.classList.contains("dark");
    const nextTheme = isDark ? "light" : "dark";

    applyTheme(nextTheme);
    localStorage.setItem(themeKey, nextTheme);
});
