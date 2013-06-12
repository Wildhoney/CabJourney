/**
 * @module App
 * @class CSVMixin
 * @extends Ember.Mixin
 * @type Ember.Mixin
 *
 * Responsible for loading the output CSV.
 */
App.CSVMixin = Ember.Mixin.create({

    init: function() {

        // Gather the essentials for parsing the CSV document, loading it into models, and
        // finally into the controller.
        var separator   = this._separator,
            model       = this._model,
            url         = this._url,
            lineBreak   = "\n",
            controller  = this;

        // Initialise the AJAX call.
        $.ajax(url, { success: function(response) {

            // Create all the necessary RegExp objects to parse the document.
            var lineRegExp      = new RegExp(lineBreak, 'i'),
                columnRegExp    = new RegExp(separator, 'i'),
                rows            = response.split(lineRegExp);

            // Initialise the array that will hold the models to load into the controller.
            var loadModels = [];

            // The first row is a header -- we don't want that, but we do need a record of them.
            var headers = rows.shift().split(columnRegExp);

            // Iterate over each row.
            rows.forEach(function(row) {

                // Split the columns.
                var columns     = row.split(columnRegExp),
                    loadModel   = {};

                // ...And then iterate over each column.
                columns.forEach(function(column, index) {

                    // Find the property's name by its index, and push it into the `loadModel` object.
                    var property = headers[index];
                    loadModel[property] = column;

                });

                // We'll load this model later!
                loadModels.push(model.create(loadModel));

            });

            // Voila! We can now populate the `content` array with our models.
            controller.set('content', loadModels);

        }, error: function() {

            console.error('Unable to load the CSV from: "%@"'.fmt(url));

        }});

        // We'll probably need this!
        this._super();

    }

});