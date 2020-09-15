window.onload = function () {
    
    "use strict";

    var radio_custom = document.querySelectorAll(".radio-custom:not(.style-5)"),

        i = 0,

        j = 0,

        style_gold_label = document.querySelectorAll(".radio-custom.style-gold label"),

        style2_label = document.querySelectorAll(".radio-custom.style-2 label"),

        style5_li = document.querySelectorAll(".radio-custom.style-5 li");

    radio_custom.forEach(function (radio) {

        if (radio.children[0].tagName !== "INPUT" ||
                radio.children[1].tagName !== "LABEL") {

            radio.remove();
        }
    });

    radio_custom = document.querySelectorAll(".radio-custom:not(.style-5)");

    for (i = 1; i < radio_custom.length + 1; i += 1) {

        radio_custom[i - 1].children[0].id = "radio-" + i;

        radio_custom[i - 1].children[1].setAttribute("for", "radio-" + i);
    }

    for (i = 1; i < style5_li.length + 1; i += 1) {

        style5_li[i - 1].children[0].id = "radio-" + i;

        style5_li[i - 1].children[1].setAttribute("for", "radio-" + i);
    }

    style_gold_label.forEach(function (label_in_style_gold) {

        label_in_style_gold.innerHTML += "<span class='add-to-style-gold'></span>";
    });

    for (i = 0; i < style2_label.length; i += 1) {

        style2_label[i].onclick = function () {

            for (j = 0; j < style2_label.length; j += 1) {

                if (style2_label[j].previousElementSibling.getAttribute("name") === this.previousElementSibling.getAttribute("name")) {

                    style2_label[j].parentElement.style.borderStyle = "dotted";
                }
            }
            
            this.parentElement.style.borderStyle = "solid";
        };
    }
};