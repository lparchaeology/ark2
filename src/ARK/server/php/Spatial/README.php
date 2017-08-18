Import of the Brick Geo library from https://github.com/brick/geo.

Goals of this fork are:
* Convert to PHP 7.1
* Integrate more formats such as GeoJSON
* Integrate conversions and projections, e.g. via proj4php
* Integrate geocoding using Geocoder-php
* Integrate internal geometry engine from phpgeo

In other words, to create a PHP GeoSpatial processing library implementing all commonly used functions
but sharing a single set of geometry classes to save on conversions.
