<?php

/**
 * ARK Debug Service Provider.
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Framework\Provider;

use ARK\Api\JsonApi\JsonApiServiceProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ApiServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container) : void
    {
        $path = $container['ark']['api']['path'];
        $container['path.api'] = $path;
        $container->register(new JsonApiServiceProvider());
        // FIXME Unsecured API access, secure with OAUTH2
        $container->extendArray('security.firewalls', 'api_area', ['pattern' => "(^$path)", 'anonymous' => true]);

        /*
        // API Platform, see https://api-platform.com/docs/core/configuration
        api_platform:

            # The title of the API.
            title: ''

            # The description of the API.
            description: ''

            # The version of the API.
            version: '0.0.0'

            # Specify a name converter to use.
            name_converter: ~

            # Specify a path name generator to use.
            path_segment_name_generator: 'api_platform.path_segment_name_generator.underscore'

            # Specify a name for the folder within bundle that contain api resources.
            api_resources_directory: 'Entity'

            eager_loading:
                # To enable or disable eager loading.
                enabled: true

                # Fetch only partial data according to serialization groups.
                # If enabled, Doctrine ORM entities will not work as expected if any of the other fields are used.
                fetch_partial: false

                # Max number of joined relations before EagerLoading throws a RuntimeException.
                max_joins: 30

                # Force join on every relation.
                # If disabled, it will only join relations having the EAGER fetch mode.
                force_eager: true

            # Enable the FOSUserBundle integration.
            enable_fos_user: false

            # Enable the Nelmio Api doc integration.
            enable_nelmio_api_doc: false

            # Enable the Swagger documentation and export.
            enable_swagger: true

            # Enable Swagger ui.
            enable_swagger_ui: true

            oauth:
                # To enable or disable oauth.
                enabled: false

                # The oauth client id.
                clientId: ''

                # The oauth client secret.
                clientSecret: ''

                # The oauth type.
                type: 'oauth2'

                # The oauth flow grant type.
                flow: 'application'

                # The oauth token url.
                tokenUrl: '/oauth/v2/token'

                # The oauth authentication url.
                authorizationUrl: '/oauth/v2/auth'

                # The oauth scopes.
                scopes: []

            swagger:
                # The swagger api keys.
                api_keys: []

            collection:
                # The default order of results.
                order: 'ASC'

                # The name of the query parameter to order results.
                order_parameter_name: 'order'

                pagination:
                    # To enable or disable pagination for all resource collections by default.
                    enabled: true

                    # To allow the client to enable or disable the pagination.
                    client_enabled: false

                    # To allow the client to set the number of items per page.
                    client_items_per_page: false

                    # The default number of items per page.
                    items_per_page: 30

                    # The maximum number of items per page.
                    maximum_items_per_page: ~

                    # The default name of the parameter handling the page number.
                    page_parameter_name: 'page'

                    # The name of the query parameter to enable or disable pagination.
                    enabled_parameter_name: 'pagination'

                    # The name of the query parameter to set the number of items per page.
                    items_per_page_parameter_name: 'itemsPerPage'

            mapping:
                # The list of paths with files or directories where the bundle will look for additional resource files.
                paths: []

            http_cache:
                # Automatically generate etags for API responses.
                etag: true

                # Default value for the response max age.
                max_age: ~

                # Default value for the response shared (proxy) max age.
                shared_max_age: ~

                # Default values of the "Vary" HTTP header.
                vary: ['Accept']

                # To make all responses public by default.
                public: ~

                invalidation:
                  # To enable the tags-based cache invalidation system.
                  enabled: false

                  # URLs of the Varnish servers to purge using cache tags when a resource is updated.
                  varnish_urls: []

            # The list of exceptions mapped to their HTTP status code.
            exception_to_status:
                # With a status code.
                Symfony\Component\Serializer\Exception\ExceptionInterface: 400

                # Or with a constant defined in the 'Symfony\Component\HttpFoundation\Response' class.
                ApiPlatform\Core\Exception\InvalidArgumentException: !php/const:Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST

                # ...

            # The list of enabled formats. The first one will be the default.
            formats:
                jsonld:
                    mime_types: ['application/ld+json']

                json:
                    mime_types: ['application/json']

                html:
                    mime_types: ['text/html']

                # ...

            # The list of enabled error formats. The first one will be the default.
            error_formats:
                jsonproblem:
                    mime_types: ['application/problem+json']

                jsonld:
                    mime_types: ['application/ld+json']
        */
    }
}
