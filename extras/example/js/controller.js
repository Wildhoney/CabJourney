/**
 * @module App
 * @class IndexController
 * @extends Ember.ArrayController
 * @type Ember.ArrayController
 */
App.IndexController = Ember.ArrayController.extend(App.CSVMixin, {

    /**
     * @property _mapInstance
     * @type {Object}
     * Instance of the Leaflet.js map.
     * @protected
     */
    _mapInstance: null,

    /**
     * @property _url
     * @type {String}
     * Path to the CSV document to be parsed and applied to the controller.
     * @protected
     */
    _url: './../../assets/output/points-cleaned.csv',

    /**
     * @property _model
     * @type {String}
     * Defines the type of model that we wish to use for the data.
     * @protected
     */
    _model: App.CSVModel,

    /**
     * @property _separator
     * @type {String}
     * Like the PHP script, we have a variable for changing the separator
     * for the CSV document -- we could be using TSV, after all.
     * @protected
     */
    _separator: ','

});