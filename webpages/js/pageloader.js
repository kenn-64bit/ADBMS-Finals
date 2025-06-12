function loadPage(page) {
  fetch(page)
    .then(response => response.text())
    .then(html => {
      document.getElementById("main-content").innerHTML = html;
    })
    .catch(error => {
      document.getElementById("main-content").innerHTML = "<p>Error loading page.</p>";
      console.error("Page load failed:", error);
    });
}

// Optional: load default page on startup
window.onload = () => loadPage("account.html");
