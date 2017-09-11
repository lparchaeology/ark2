var Router = (function () {

    var base = '';
    var routes = [];

    var generatePath = function generatePath(name, parameters) {
        parameters = parameters === undefined ? [] : parameters;
        var route = this.routes[name];
        var url = this.base + route.path;

        for (var id in parameters) {
            if (parameters.hasOwnProperty(id)) {
                url = url.replace('{' + id + '}', parameters[id]);
            }
        }

        return url;
    };

    var setBasePath = function setBasePath(path) {
        this.base = path;
    };

    var setRoutes = function addRoutes(routes) {
        this.routes = routes;
    };

    return {
        generatePath: generatePath,
        setBasePath: setBasePath,
        setRoutes: setRoutes,
    };

})();
