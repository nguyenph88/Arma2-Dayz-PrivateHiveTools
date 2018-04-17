(function($){
$.fn.validationEngineLanguage = function(){};
$.validationEngineLanguage = {
newLang: function(){
$.validationEngineLanguage.allRules = {
"required": {"regex": "none","alertText": "* Dieses Feld ist ein Pflichtfeld","alertTextCheckboxMultiple": "* Bitte wähle eine Option","alertTextCheckboxe": "* Dieses Feld ist ein Pflichtfeld"},
"requiredInFunction":{ "func": function(field, rules, i, options){return (field.val() == "test") ? true : false;},"alertText": "* Field must equal test"},
"minSize":{"regex":"none","alertText":"* Mindestens ","alertText2":" Zeichen benötigt"},
"maxSize":{"regex":"none","alertText":"* Maximal ","alertText2":" Zeichen erlaubt"},
"groupRequired":{"regex":"none","alertText":"* Du musst mindestens eines dieser Felder ausfüllen"},
"min":{"regex":"none","alertText":"* Mindestwert ist "},
"max":{"regex":"none","alertText":"* Maximalwert ist "},
"past":{"regex":"none","alertText":"* Datum vor "},
"future":{"regex":"none","alertText":"* Datum nach "},	
"maxCheckbox":{"regex":"none","alertText":"* Maximale Anzahl Markierungen überschritten"},
"minCheckbox":{"regex":"none","alertText":"* Bitte wähle ","alertText2": " Optionen"},
"equals":{"regex":"none","alertText":"* Felder stimmen nicht überein"},
"creditCard":{"regex":"none","alertText":"* Ungültige Kreditkartennummer"},
"phone":{"regex": /^([\+][0-9]{1,3}([ \.\-])?)?([\(][0-9]{1,6}[\)])?([0-9 \.\-]{1,32})(([A-Za-z \:]{1,11})?[0-9]{1,4}?)$/,"alertText":"* Ungültige Telefonnummer"},
"email":{"regex": /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"alertText": "* Ungültige E-Mail-Adresse"},
"integer":{"regex": /^[\-\+]?\d+$/,"alertText":"* Keine gültige Ganzzahl"},
"number":{"regex": /^[\-\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/,"alertText":"* Keine gültige Fließkommazahl"},
"date":{"regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/,"alertText":"* Ungültiges Datumsformat, erwartet wird das Format JJJJ-MM-TT"},
"ipv4":{"regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,"alertText":"* Ungültige IP-Adresse"},
"url":{"regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,"alertText":"* Ungültige URL"},
"onlyLetterSp":{"regex": /^[a-zA-ZäüöÄÜÖßs\ \\\']+$/,"alertText":"* Nur Buchstaben erlaubt"},
"onlyLetterNumber":{"regex": /^[0-9a-zA-ZäüöÄÜÖßs-|_]+$/,"alertText": "* Keine Sonderzeichen erlaubt"},
"validate2fields":{"alertText":"* Bitte HELLO eingeben"},


};}};	
$.validationEngineLanguage.newLang();
})(jQuery);