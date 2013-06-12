/**
 * @module App
 * @class IndexView
 * @extends Ember.View
 * @type Ember.View
 */
App.IndexView = Ember.View.extend({

    /**
     * @method didInsertElement
     * Responsible for inserting the Leaflet.js map into the DOM.
     * @return {void}
     */
    didInsertElement: function() {

        // Instantiate the map, settings its centre.
        var map         = L.map(this.$()[0], { zoom: 14, center: [51.5148807, -0.156478266] }),
            controller  = this.get('controller');

        // Add the custom tile to the map (this is a bespoke one that I created in TileMill).
        var tilePath = 'http://a.tiles.mapbox.com/v3/wildhoney.map-r4er8ydn/{z}/{x}/{y}.png';
        L.tileLayer(tilePath).addTo(map);

        // Set the map instance on the controller for later.
        controller.set('_mapInstance', map);

        // Maybe we have the coordinates already...
        this._plotPoints();

        // Just in case we have any mixins attached!
        this._super();

    },

    /**
     * @method _plotPoints
     * Responsible for plotting the markers onto the map.
     * @private
     */
    _plotPoints: function() {

        var controller  = this.get('controller'),
            map         = controller.get('_mapInstance');

        // Iterate over all of the models in the controller.
        controller.forEach(function(model) {

            // Create a custom marker, so we can have a cab icon.
            var customIcon = L.divIcon({ iconSize: [15, 15], className: 'cab' });

            // Place a marker based on the latitude/longitude from the model.
            var marker = L.marker([model.get('latitude'), model.get('longitude')], { icon: customIcon, riseOnHover: true });

            // Place a popup on the map to display the latitude/longitude value.
            marker.bindPopup('%@, %@'.fmt(model.get('latitude'), model.get('longitude')));

            // Add the marker to the map!
            marker.addTo(map);

        });

    }.observes('controller.length', 'controller._mapInstance')

});