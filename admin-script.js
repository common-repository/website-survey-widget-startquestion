var WebsiteSurveyWidgetStartquestion = (function() {
    return {
        init: function() {
            var form = document.querySelector('#startuqestionWidgetSettings form');
            if (!form) return;

            var submitButton = form.querySelector('[type="submit"]');
            var widgetHtmlInput = form.querySelector('#startquestion_html_code');
            var widgetCodeInput = form.querySelector('#startquestion_widget_code');
            if (!submitButton || !widgetHtmlInput) return;

            widgetHtmlInput.addEventListener('keyup', function() {
                validate();
            });
            validate();

            function validate() {
                if (widgetHtmlInput.value.length === 0) {
                    submitButton.disabled = false;
                    widgetCodeInput.value = '';
                } else if (widgetHtmlInput.value.length !== 0 && widgetHtmlInput.value.indexOf('startquestion.com') === -1) {
                    submitButton.disabled = true;
                    widgetCodeInput.value = '';
                } else {
                    var uniqueId = getUniqueId();
                    if (uniqueId === false) {
                        submitButton.disabled = true;
                        widgetCodeInput.value = '';
                    } else {
                        submitButton.disabled = false;
                        widgetCodeInput.value = uniqueId.split("'")[1];
                    }
                }
            }

            function getUniqueId() {
                var regexp = /'[0-9a-z]{1,20}-[0-9a-z]{1,20}-[0-9a-z]{1,20}-[0-9a-z]{1,20}-[0-9a-z]{1,20}'/;
                var match = widgetHtmlInput.value.match(regexp);

                if (match && match[0]) {
                    return match[0];
                }

                return false;
            }
        }
    }
})();

document.addEventListener('DOMContentLoaded', WebsiteSurveyWidgetStartquestion.init);