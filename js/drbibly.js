(function ($, Drupal) {
    Drupal.behaviors.bibly = {
        attach: function (context, settings) {

            var popupVersion = settings.bibly.bibly.popupVersion;
            var enablePopups = settings.bibly.bibly.enablePopups;
            var startNodeId = settings.bibly.bibly.startNodeId;
            var linkVersion = settings.bibly.bibly.linkVersion;
            var className = settings.bibly.bibly.className;
            
            bibly.enablePopups = enablePopups;
            bibly.popupVersion = popupVersion;
            bibly.linkVersion = linkVersion;
            bibly.className = className;
            bibly.startNodeId = startNodeId;
        }
    };
})(jQuery, Drupal);


