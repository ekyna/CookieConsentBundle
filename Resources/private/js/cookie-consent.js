document.addEventListener("DOMContentLoaded", function() {
    var cookieConsent = document.getElementsByClassName('ekyna-cookie-consent')[0];
    var cookieConsentBackdrop = document.getElementsByClassName('ekyna-cookie-consent-backdrop')[0];
    var buttonAll = cookieConsent.getElementsByClassName('ekyna-cookie-consent-all')[0];
    var buttonSubmit = cookieConsent.getElementsByClassName('ekyna-cookie-consent-submit')[0];
    var buttonSettings = cookieConsent.getElementsByClassName('ekyna-cookie-consent-settings')[0];
    var cookieConsentForm = cookieConsent.getElementsByTagName('form')[0];
    var categories = cookieConsentForm.getElementsByClassName('categories')[0];

    if (!cookieConsentForm) {
        return;
    }

    var submit = function() {
        var xhr = new XMLHttpRequest();
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                cookieConsent.style.display = 'none';
                if (cookieConsentBackdrop) {
                    cookieConsentBackdrop.style.display = 'none';
                }
                var resp = JSON.parse(xhr.response);
                if (resp.hasOwnProperty('reload') && resp.reload) {
                    document.location.reload();
                }
            } else {
                enableForm(cookieConsentForm);
            }
        };
        xhr.open('POST', cookieConsentForm.action);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(serializeForm(cookieConsentForm));

        disableForm(cookieConsentForm);
    };

    if (buttonSettings) {
        buttonSettings.addEventListener('click', function (event) {
            event.preventDefault();

            if (categories.style.display === 'block') {
                categories.style.display = 'none';
            } else {
                categories.style.display = 'block';
            }

            return false;
        }, false);
    }

    if (buttonSubmit) {
        buttonSubmit.addEventListener('click', function (event) {
            event.preventDefault();

            submit();

            return false;
        }, false);
    }

    if (buttonAll) {
        buttonAll.addEventListener('click', function (event) {
            event.preventDefault();

            var inputs = cookieConsentForm.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                var input = inputs[i],
                    attr = input.attributes;
                if (attr.getNamedItem('type').value === 'radio') {
                    input.checked = attr.getNamedItem('value').value === '1';
                }
            }

            submit();

            return false;
        }, false);
    }
});

function disableForm(form) {
    var buttons = form.getElementsByTagName('button');
    for (var b = 0; b < buttons.length; b++) {
        var button = buttons[b];
        button.disabled = true;
    }

    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        input.disabled = true;
    }
}

function enableForm(form) {
    var buttons = form.getElementsByTagName('button');
    for (var b = 0; b < buttons.length; b++) {
        var button = buttons[b];
        button.disabled = false;
    }

    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        input.disabled = false;
    }
}

function serializeForm(form) {
    var serialized = [];

    for (var i = 0; i < form.elements.length; i++) {
        var field = form.elements[i];

        if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
            serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value));
        }
    }

    return serialized.join('&');
}
