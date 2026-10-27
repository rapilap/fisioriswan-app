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

    // Pasang kelas sebentar agar warna berubah halus, lalu lepas supaya hover/animasi lain tidak ikut melambat.
    const root = document.documentElement;
    root.classList.add("theme-switching");
    clearTimeout(window.__themeSwitchTimer);
    window.__themeSwitchTimer = setTimeout(() => root.classList.remove("theme-switching"), 500);

    applyTheme(nextTheme);
    localStorage.setItem(themeKey, nextTheme);
});
