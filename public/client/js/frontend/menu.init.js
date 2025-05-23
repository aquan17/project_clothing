/*
Template Name: Toner eCommerce + Admin HTML Template
Author: Themesbrand
Version: 1.2.0
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: menu Js File
*/

var default_lang = "en"; // set Default Language
var language = localStorage.getItem("language");

function initLanguage() {
    // Set new language
    (language === null) ? setLanguage(default_lang) : setLanguage(language);
    var languages = document.getElementsByClassName("language");
    languages && Array.from(languages).forEach(function (dropdown) {
        dropdown.addEventListener("click", function (event) {
            setLanguage(dropdown.getAttribute("data-lang"));
        });
    });
}

function setLanguage(lang) {
    if (document.getElementById("header-lang-img")) {
        if (lang == "en") {
            document.getElementById("header-lang-img").src = "client/us.svg";
            document.getElementById("lang-name").innerHTML = "English"
        }  else if (lang == "vi") {
            document.getElementById("header-lang-img").src = "/client/vietnam.svg";
            document.getElementById("lang-name").innerHTML = "Tiếng Việt"
        }else if (lang == "sp") {
            document.getElementById("header-lang-img").src = "../client/images/flags/spain.svg";
            document.getElementById("lang-name").innerHTML = "Española"
        } else if (lang == "gr") {
            document.getElementById("header-lang-img").src = "../client/images/flags/germany.svg";
            document.getElementById("lang-name").innerHTML = "Deutsche"
        } else if (lang == "it") {
            document.getElementById("header-lang-img").src = "../client/images/flags/italy.svg";
            document.getElementById("lang-name").innerHTML = "Italiana"
        } else if (lang == "ru") {
            document.getElementById("header-lang-img").src = "../client/images/flags/russia.svg";
            document.getElementById("lang-name").innerHTML = "русский"
        } else if (lang == "ch") {
            document.getElementById("header-lang-img").src = "../client/images/flags/china.svg";
            document.getElementById("lang-name").innerHTML = "中国人"
        } else if (lang == "fr") {
            document.getElementById("header-lang-img").src = "../client/images/flags/french.svg";
            document.getElementById("lang-name").innerHTML = "français"
        } else if (lang == "sa") {
            document.getElementById("header-lang-img").src = "../client/images/flags/sa.svg";
            document.getElementById("lang-name").innerHTML = "عربى"
        }
        localStorage.setItem("language", lang);
        language = localStorage.getItem("language");
        getLanguage();
    }
}

// Multi language setting
function getLanguage() {
    language == null ? setLanguage(default_lang) : false;
    var request = new XMLHttpRequest();
    // Instantiating the request object
    request.open("GET", "../client/lang/" + language + ".json");
    // Defining event listener for readystatechange event
    request.onreadystatechange = function () {
        // Check if the request is compete and was successful
        if (this.readyState === 4 && this.status === 200) {
            var data = JSON.parse(this.responseText);
            Object.keys(data).forEach(function (key) {
                var elements = document.querySelectorAll("[data-key='" + key + "']");
                Array.from(elements).forEach(function (elem) {
                    elem.textContent = data[key];
                });
            });
        }
    };
    // Sending the request to the server
    request.send();
}

initLanguage();

//  Search menu dropdown on Topbar
function isCustomDropdown() {
    //Search bar
    var searchOptions = document.getElementById("search-close-options");
    var dropdown = document.getElementById("search-dropdown");
    var searchInput = document.getElementById("search-options");
    if (searchInput) {
        searchInput.addEventListener("focus", function () {
            var inputLength = searchInput.value.length;
            if (inputLength > 0) {
                dropdown.classList.add("show");
                searchOptions.classList.remove("d-none");
            } else {
                dropdown.classList.remove("show");
                searchOptions.classList.add("d-none");
            }
        });

        searchInput.addEventListener("keyup", function (event) {
            var inputLength = searchInput.value.length;
            if (inputLength > 0) {
                dropdown.classList.add("show");
                searchOptions.classList.remove("d-none");

                var inputVal = searchInput.value.toLowerCase();
                var notifyItem = document.getElementsByClassName("notify-item");

                Array.from(notifyItem).forEach(function (element) {
                    var notifiTxt = ''
                    if (element.querySelector("h6")) {
                        var spantext = element.getElementsByTagName("span")[0].innerText.toLowerCase()
                        var name = element.querySelector("h6").innerText.toLowerCase()
                        if (name.includes(inputVal)) {
                            notifiTxt = name
                        } else {
                            notifiTxt = spantext
                        }
                    } else if (element.getElementsByTagName("span")) {
                        notifiTxt = element.getElementsByTagName("span")[0].innerText.toLowerCase()
                    }

                    if (notifiTxt) {
                        if (notifiTxt.includes(inputVal)) {
                            element.classList.add("d-block");
                            element.classList.remove("d-none");
                        } else {
                            element.classList.remove("d-block");
                            element.classList.add("d-none");
                        }
                    }

                    Array.from(document.getElementsByClassName("notification-group-list")).forEach(function (element) {
                        if (element.querySelectorAll(".notify-item.d-block").length == 0) {
                            element.querySelector(".notification-title").style.display = 'none'
                        } else {
                            element.querySelector(".notification-title").style.display = 'block'
                        }
                    });
                });
            } else {
                dropdown.classList.remove("show");
                searchOptions.classList.add("d-none");
            }
        });

        searchOptions.addEventListener("click", function () {
            searchInput.value = "";
            dropdown.classList.remove("show");
            searchOptions.classList.add("d-none");
        });

        document.body.addEventListener("click", function (e) {
            if (e.target.getAttribute("id") !== "search-options") {
                dropdown.classList.remove("show");
                searchOptions.classList.add("d-none");
            }
        });
    }

    // cart dropdown

        // input spin
        
}

//  search menu dropdown on topbar
function isCustomDropdownResponsive() {
    //Search bar
    var searchOptions = document.getElementById("search-close-options");
    var dropdownReponsive = document.getElementById("search-dropdown-reponsive");
    var searchInputReponsive = document.getElementById("search-options-reponsive");

    if (searchOptions && dropdownReponsive && searchInputReponsive) {
        searchInputReponsive.addEventListener("focus", function () {
            var inputLength = searchInputReponsive.value.length;
            if (inputLength > 0) {
                dropdownReponsive.classList.add("show");
                searchOptions.classList.remove("d-none");
            } else {
                dropdownReponsive.classList.remove("show");
                searchOptions.classList.add("d-none");
            }
        });

        searchInputReponsive.addEventListener("keyup", function () {
            var inputLength = searchInputReponsive.value.length;
            if (inputLength > 0) {
                dropdownReponsive.classList.add("show");
                searchOptions.classList.remove("d-none");
            } else {
                dropdownReponsive.classList.remove("show");
                searchOptions.classList.add("d-none");
            }
        });

        searchOptions.addEventListener("click", function () {
            searchInputReponsive.value = "";
            dropdownReponsive.classList.remove("show");
            searchOptions.classList.add("d-none");
        });

        document.body.addEventListener("click", function (e) {
            if (e.target.getAttribute("id") !== "search-options") {
                dropdownReponsive.classList.remove("show");
                searchOptions.classList.add("d-none");
            }
        });
    }
}

function elementInViewport(el) {
    if (el) {
        var top = el.offsetTop;
        var left = el.offsetLeft;
        var width = el.offsetWidth;
        var height = el.offsetHeight;

        if (el.offsetParent) {
            while (el.offsetParent) {
                el = el.offsetParent;
                top += el.offsetTop;
                left += el.offsetLeft;
            }
        }
        return (
            top >= window.pageYOffset &&
            left >= window.pageXOffset &&
            top + height <= window.pageYOffset + window.innerHeight &&
            left + width <= window.pageXOffset + window.innerWidth
        );
    }
}

function windowResizeHover() {
    var isElement = document.querySelectorAll(".ecommerce-navbar .navbar-nav li");
    Array.from(isElement).forEach(function (item) {
        item.addEventListener("click", menuItem.bind(this), false);
        item.addEventListener("mouseover", menuItem.bind(this), false);
    });

    var windowSize = document.documentElement.clientWidth;
    if (windowSize < 992) {
        var currentPath = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
        currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);

        if (currentPath) {
            var a = document.getElementById("navigation-menu").querySelector('[href="' + currentPath + '"]');
            if (a) {
                var parentCollapseDiv = a.closest(".dropdown-menu");

                if (parentCollapseDiv) {
                    parentCollapseDiv.classList.add("show");
                    if (parentCollapseDiv.parentElement) {
                        parentCollapseDiv.classList.add("show");
                        parentCollapseDiv.parentElement.children[0].classList.add("show");
                        parentCollapseDiv.parentElement.children[0].setAttribute("aria-expanded", "true");
                        if (parentCollapseDiv.parentElement.parentElement.parentElement) {
                            parentCollapseDiv.parentElement.parentElement.classList.add("show");
                            parentCollapseDiv.parentElement.parentElement.parentElement.children[0].classList.add("show");
                            parentCollapseDiv.parentElement.parentElement.parentElement.children[0].setAttribute("aria-expanded", "true");
                            if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement) {
                                parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.classList.add("show");
                                parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.children[0].classList.add("show");
                                parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.children[0].setAttribute("aria-expanded", "true");
                                if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement) {
                                    parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.add("show");
                                    parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.children[0].classList.add("show");
                                    parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.children[0].setAttribute("aria-expanded", "true");
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        document.querySelectorAll("#navigation-menu .dropdown").forEach(function (elem) {
            if (elem.querySelector(".dropdown-menu").classList.contains("show")) {
                elem.querySelector(".dropdown-menu").classList.remove("show");
            }
            if (elem.querySelector(".dropdown-toggle")) {
                elem.querySelector(".dropdown-toggle").setAttribute("aria-expanded", "false")
            }
        });
    }

    var myCollapse = document.getElementById("navbarSupportedContent");
    var bsCollapse = new bootstrap.Collapse(myCollapse, {
        toggle: false
    })
    bsCollapse.hide();

}

window.addEventListener("resize", windowResizeHover);

windowResizeHover();

function menuItem(e) {
    if (e.target && e.target.matches(".submenu a.nav-link")) {
        if (elementInViewport(e.target.nextElementSibling) == false) {
            e.target.nextElementSibling.classList.add("dropdown-custom-right");
            // e.target.parentElement.parentElement.classList.add("dropdown-custom-right");

            var eleChild = e.target.nextElementSibling;
            Array.from(eleChild.querySelectorAll(".submenu")).forEach(function (item) {
                item.classList.add("dropdown-custom-right");
            });
        } else if (elementInViewport(e.target.nextElementSibling) == true) {
            if (window.innerWidth >= 1848) {
                var elements = document.getElementsByClassName("dropdown-custom-right");
                while (elements.length > 0) {
                    elements[0].classList.remove("dropdown-custom-right");
                }
            }
        }
    }
}

function initActiveMenu() {
    var currentPath = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
    currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);

    if (currentPath) {
        var a = document.getElementById("navigation-menu").querySelector('.nav-link[href="' + currentPath + '"]');
        if (a) {
            a.classList.add("active");
            var parentCollapseDiv = a.closest(".dropdown-menu");
            if (parentCollapseDiv) {
                if (parentCollapseDiv.parentElement) {
                    parentCollapseDiv.parentElement.children[0].classList.add("active");
                    if (parentCollapseDiv.parentElement.parentElement.parentElement) {
                        parentCollapseDiv.parentElement.parentElement.parentElement.children[0].classList.add("active");
                        if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement) {
                            parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.children[0].classList.add("active");
                            if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement) {
                                parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.children[0].classList.add("active");
                            }
                        }
                    }
                }
            }
        }
    }
}

function initMenuItemScroll() {
    setTimeout(function () {
        var sidebarMenu = document.getElementById("navbarSupportedContent");
        if (sidebarMenu) {
            if (sidebarMenu.querySelector(".nav-link.active")) {
                var activeMenu = sidebarMenu.querySelector(".nav-link.active").offsetTop;
                setTimeout(function () {
                    sidebarMenu.scrollTop = activeMenu
                }, 0);

            }
        }
    }, 250);
}
initMenuItemScroll();

const navbarCollapsible = document.getElementById('navbarSupportedContent')
navbarCollapsible.addEventListener('shown.bs.collapse', event => {
    initMenuItemScroll()
})

function initModeSetting() {
    if (sessionStorage.getItem("data-bs-theme") && sessionStorage.getItem("data-bs-theme") == "light") {
        document.documentElement.setAttribute('data-bs-theme', 'light');
    } else if (sessionStorage.getItem("data-bs-theme") == "dark") {
        document.documentElement.setAttribute('data-bs-theme', 'dark');
    }

    var html = document.getElementsByTagName("HTML")[0];
    document.querySelectorAll("#light-dark-mode .dropdown-item").forEach(function (item) {
        item.addEventListener("click", function (event) {
            if (html.hasAttribute("data-bs-theme") && item.getAttribute("data-mode") == "light") {
                sessionStorage.setItem("data-bs-theme", "light");
            } else if (html.hasAttribute("data-bs-theme") && item.getAttribute("data-mode") == "dark") {
                sessionStorage.setItem("data-bs-theme", "dark");
            } else if (html.hasAttribute("data-bs-theme") && item.getAttribute("data-mode") == "auto") {
                const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");
                if (prefersDarkScheme.matches) {
                    sessionStorage.setItem("data-bs-theme", "dark");
                } else {
                    sessionStorage.setItem("data-bs-theme", "light");
                }
            }

            if (sessionStorage.getItem("data-bs-theme") && sessionStorage.getItem("data-bs-theme") == "light") {
                document.documentElement.setAttribute('data-bs-theme', 'light');
            } else if (sessionStorage.getItem("data-bs-theme") == "dark") {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            }
        })
    })
}


function init() {
    isCustomDropdown();
    isCustomDropdownResponsive();
    initActiveMenu();
    initMenuItemScroll();
    initModeSetting();
}
init();


//  Window scroll sticky class add
function windowScroll() {
    var navbar = document.getElementById("navbar");
    if (navbar) {
        if (document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50) {
            navbar.classList.add("is-sticky");
        } else {
            navbar.classList.remove("is-sticky");
        }
    }
}

window.addEventListener('scroll', function (ev) {
    ev.preventDefault();
    windowScroll();
});

//modal js
function firstTimeLoad() {

    var myModal = new bootstrap.Modal(document.getElementById('subscribeModal'), {
        keyboard: false
    })
    var modalToggle = document.getElementById('subscribeModal') // relatedTarget

    setTimeout(function () {
        myModal ? myModal.show(modalToggle) : "";
    }, 1000);
}

firstTimeLoad();

// var tooltipTriggerList = [].slice.call(
//     document.querySelectorAll('[data-bs-toggle="tooltip"]')
// );
// var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
//     return new bootstrap.Tooltip(tooltipTriggerEl);
// });

function initComponents() {
    // tooltip
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // popover
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]')
    );
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

initComponents();

setTimeout(function () {
    // === following js will activate the menu in left side bar based on url ====
    var menuItems = document.querySelectorAll(".submenu-item li a");
    menuItems && menuItems.forEach(function (item) {
        var pageUrl = window.location.href.split(/[?#]/)[0];

        if (item.href == pageUrl) {
            item.classList.add("active");
        }
    });
}, 0)

//
/********************* scroll top js ************************/
//

var mybutton = document.getElementById("back-to-top");

if (mybutton) {
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
}

//chat bot
function chatBot() {
    var chatbot = document.getElementById("chatBot");
    if (chatbot) {
        chatbot.classList.remove("show");
    }
}

// Scroll to Bottom
function scrollToBottom(id) {
    setTimeout(function () {
        var simpleBar = (document.getElementById(id).querySelector("#chat-conversation .simplebar-content-wrapper")) ?
            document.getElementById(id).querySelector("#chat-conversation .simplebar-content-wrapper") : ''

        var offsetHeight = document.getElementsByClassName("chat-conversation-list")[0] ?
            document.getElementById(id).getElementsByClassName("chat-conversation-list")[0].scrollHeight - window.innerHeight + 800 : 0;

        if (offsetHeight)
            simpleBar.scrollTo({
                top: offsetHeight,
                behavior: "smooth"
            });
    }, 100);
}


const chatCollapsible = document.getElementById('chatBot')
chatCollapsible.addEventListener('shown.bs.collapse', event => {
    // chat
    var currentChatId = "users-chat-widget";
    scrollToBottom(currentChatId);
})