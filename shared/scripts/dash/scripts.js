/**
 * CONTROLADOR DO SIDEBAR
 */
$(function () {
    let minWidth = 992 - 18;
    let windowSize = getWindowSize();
    let toggler = $(".jsSidebarToggler");
    let sidebar = $(".jsDashboardSidebar");

    updateSidebarStyle();

    toggler.on("click", function (e) {
        e.preventDefault();
        if (sidebar.hasClass("d-none")) {
            sidebar.removeClass("d-none");
            toggler.css({
                "margin-left": sidebar.width() + "px"
            });
            togglerCloseIcon();
            addBackdrop("sidebarbkdrop", "fixed", null, null);
        } else {
            sidebar.addClass("d-none");
            toggler.css({
                "margin-left": 0
            });
            togglerOpenIcon();
            removeBackdrop("sidebarbkdrop");
        }
    });

    $(window).on("resize", function () {
        windowSize = getWindowSize();
        updateSidebarStyle();
    });

    function updateSidebarStyle() {
        if (windowSize <= minWidth) {
            sidebar.removeClass("desktop").addClass("mobile");
        } else {
            sidebar.removeClass("mobile").addClass("desktop");
        }
    }

    function getWindowSize() {
        return $(window).width();
    }

    function togglerOpenIcon() {
        toggler.removeClass(toggler.attr("data-alt-icon")).addClass(toggler.attr("data-active-icon"));
    }

    function togglerCloseIcon() {
        toggler.removeClass(toggler.attr("data-active-icon")).addClass(toggler.attr("data-alt-icon"));
    }
});

/**
 * SUBMISSÃO DE FORMULÁRIOS
 */
$(function () {

    $("form").on("submit", function (e) {
        e.preventDefault();
        let form = $(this);
        let submitButton = $(e.originalEvent.submitter);
        let action = form.attr("action");
        let data = (new FormData(form[0]));

        $.ajax({
            url: action,
            data: data,
            method: 'POST',
            processData: false,
            dataType: 'json',

            beforeSend: function () {
                addLoadingMode(submitButton);
            },

            success: function (response) {

            },

            complete: function () {
                removeLoadingMode(submitButton);
            }
        });
    });

});

/**
 * 
 * FUNÇÕES: BACKDROP
 * 
 */

/**
 * @param {String} id id para o backdrop
 * @param {String} position tipo de posicionamento. Padrão é 'absolute'
 * @param {String} container onde inserir o backdrop. Padrão é o 'body'
 * @param {String} effect efeito do jquery-ui. Padrão é 'fade'
 */
function addBackdrop(id, position, container, effect) {
    let cntnr = $(container ?? "body");
    let efct = effect ?? "fade";
    let bkdrop = $(`<div id="${id}"></div>`).css({
        "background-color": "rgb(0, 0, 0, 0.5)",
        width: "100%",
        height: "100%",
        position: position ?? "absolute",
        top: 0,
        left: 0,
        "z-index": 998,
    }).hide();

    cntnr.append(bkdrop.show(efct));
}

/**
 * @param {String} id id do backdrop a ser removido
 * @param {String} container local onde procurar o backdrop. Por padrão busca por todo o 'body'
 * @param {String} effect efeito do jquery-ui. Padrão é 'fade'
 */
function removeBackdrop(id, container, effect) {
    let cntnr = $(container ?? "body");
    let efct = effect ?? "fade";

    cntnr.find("#" + id).hide(efct, function () {
        $(this).remove();
    });
}

/**
 * 
 * FUNÇÕES: BOTÕES
 * 
 */

/**
 * @param {jQuery} buttonObject objeto jQuery do botão
 */
function addLoadingMode(buttonObject) {
    buttonObject
        .removeClass(buttonObject.attr("data-active-icon"))
        .addClass(buttonObject.attr("data-alt-icon"))
        .prop("disabled", true);
}

/**
 * @param {jQuery} buttonObject objeto jQuery do botão
 */
function removeLoadingMode(buttonObject) {
    buttonObject
        .addClass(buttonObject.attr("data-active-icon"))
        .removeClass(buttonObject.attr("data-alt-icon"))
        .prop("disabled", false);
}