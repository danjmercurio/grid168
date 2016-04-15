/**
 * Created by dan on 4/14/16.
 */
var grid168;
grid168 = (function () {
    var app;
    app = {
        controller: null,
        action: null,
        initialize: function () {
            console.log(this);
            if (typeof($) === "undefined") {
                throw new Error('$ is not defined. Did jQuery load?');
            }
            $(document).ready(this.onDocumentReady());
        },
        onDocumentReady: function () {
            console.log("Document ready event fired.");

            // Get the current controller and action
            this.controller = $('body').data('controller');
            this.action = $('body').data('action');

            // Stuff we need to do for every page

            // Controller-specific functionality
            switch (this.controller) {
                case 'offers':

                    break;

                case 'outlets':

                    break;

            }
        }
    };

    app.initialize();
    return app;
})();