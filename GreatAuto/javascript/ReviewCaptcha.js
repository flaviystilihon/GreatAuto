var verifyCallback = function (response) {
    alert(response);
};
var widgetId1;
var onloadCallback = function () {
    // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
    // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
    widgetId1 = grecaptcha.render('captcha1', {
        'sitekey': '6LeOLBkTAAAAANny937al1Zew6x__Fy-tYOdOQUg',
        'theme': 'light'
    });
};