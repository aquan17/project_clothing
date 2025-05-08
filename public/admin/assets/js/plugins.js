// Check if any of these elements exist in the document
if (
    document.querySelector("[toast-list]") || 
    document.querySelector("[data-choices]") || 
    document.querySelector("[data-provider]")
) {
    // Function to load scripts dynamically
    function loadScript(src) {
        const script = document.createElement("script");
        script.src = src;
        script.defer = true; // To make sure the script loads after the document is parsed
        document.head.appendChild(script);
    }

    // Load required scripts if elements are found
    if (document.querySelector("[toast-list]")) {
        loadScript("https://cdn.jsdelivr.net/npm/toastify-js");
    }
    
    if (document.querySelector("[data-choices]")) {
        loadScript("assets/libs/choices.js/scripts/choices.min.js");
    }
    
    if (document.querySelector("[data-provider]")) {
        loadScript("assets/libs/flatpickr/flatpickr.min.js");
    }
}
