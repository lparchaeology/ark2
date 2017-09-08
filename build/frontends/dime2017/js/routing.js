(function () {
    var router = {
        host: "",
        baseurl: "",
        _routes: [],

        generate: function (name, params) {
            var route = this._routes[name];
            var url = this.baseurl + route.path;

            // Get params if exists
            if (params !== undefined) {
                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
                        var param = params[key];
                        url = url.replace("{" + key + "}", param);
                    }
                }
            }

            var res = url.match(/{[a-zA-Z]+}/);
            if (res !== null) {
                throw new Error("Identifier " + res + " needs to be set!");
            }

            if (route.requirements.length > 0) {
                if (route.requirements._scheme !== undefined) {
                    if (route.requirements._scheme != window.location.protocol) {
                        url = route.requirements._scheme + "://" + url;
                    }
                }
            }

            return url;
        },

        addRoute: function (name, route) {
            this._routes[name] = route;
        },
    };

    window.router = router;
})();
