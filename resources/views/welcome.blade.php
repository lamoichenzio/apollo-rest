<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Apollo Endpoints</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/atom-one-dark.min.css">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content-center {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .section {
            margin: 30px;
        }
    </style>
</head>
<body>
<div class="content-center">
    <h1>Apollo Endpoints (/rest...)</h1>
</div>
<div class="section">
    <b>NB:</b> All endpoints except /auth/login requires Bearer Token AUTHENTICATION
</div>
<div class="section">
    <h2>Auth (/auth...)</h2>
    <ul>
        <li>
            <h3><b>POST:</b>
                <pre>/login</pre>
            </h3>
            <p>Logs in a new user</p>
            <div>
                <b>Request Body:</b>
                <pre>
                    <code class="json">
                    {
                        "email": &lt;email&gt;,
                        "password": &lt;password&gt;
                    }
                    </code>
                </pre>
                <b>Response Body:</b>
                <pre>
                    <code>
                    {
                        "access_token": &lt;token&gt;,
                        "token_type": "bearer",
                        "expires_in": &lt;expiration time&gt;,
                        "user": &lt;logged user information&gt;
                    }
                    </code>
                </pre>
            </div>
        </li>
        <li>
            <h3><b>POST:</b>
                <pre>/logout</pre>
            </h3>
            <p>Logout a user based on the token sent</p>
            <div>
                <b>Request Header:</b>
                <pre>
                    <code class="json">
                    {
                        "Authorization": "Bearer" &lt;token&gt;
                    }
                    </code>
                </pre>
                <b>Response Body:</b>
                <pre>
                    <code>
                    {
                        "message": "Successfully logged out"
                    }
                    </code>
                </pre>
            </div>
        </li>
        <li>
            <h3><b>POST:</b>
                <pre>/refresh</pre>
            </h3>
            <p>Creates a new token for the current user</p>
            <div>
                <b>Request Header:</b>
                <pre>
                    <code class="json">
                    {
                        "Authorization": "Bearer" &lt;token&gt;
                    }
                    </code>
                </pre>
                <b>Response Body:</b>
                <pre>
                    <code>
                      {
                        "access_token": &lt;token&gt;,
                        "token_type": "bearer",
                        "expires_in": &lt;expiration time&gt;,
                        "user": &lt;logged user&gt;
                    }
                    </code>
                </pre>
            </div>
        </li>
        <li>
            <h3><b>GET:</b>
                <pre>/profile</pre>
            </h3>
            <p>Gets information about the current user</p>
            <div>
                <b>Request Header:</b>
                <pre>
                    <code class="json">
                    {
                        "Authorization": "Bearer" &lt;token&gt;
                    }
                    </code>
                </pre>
                <b>Response Body:</b>
                <pre>
                    <code>
                      {
                        "data": {
                            "id": &lt;id&gt;,
                            "username": &lt;username&gt;,
                            "email": &lt;email&gt;,
                            "firstname": &lt;firstname&gt;,
                            "lastname": &lt;lastname&gt;,
                            "pic": &lt;pic&gt;,
                            "role": {
                                "name": &lt;role_name&gt;,
                                "description": &lt;role_description&gt;
                            }
                        }
                    }
                    </code>
                </pre>
            </div>
        </li>
    </ul>
</div>

<div class="section">
    <h2>User (.../user)</h2>
    <ul>
        <li>
            <h3><b>GET:</b>
                <pre>/?&lt;pagSize=num&username=name&gt;</pre>
            </h3>
            <p>Returns a list of all the users optionally paginated and filtered</p>
            <div>
                <h4>Request Params:</h4>
                <ul>
                    <li>
                        <pre>pagSize</pre>
                        <div>
                            Paginates the result with the defined number of users per page
                        </div>
                    </li>
                    <li>
                        <pre>username</pre>
                        <div>
                            Returns only the users with the given username
                        </div>
                    </li>
                </ul>
                <h4>Response Body:</h4>
                If the request has no params:
                <pre>
                    <code>
                      {
                        "data": [
                            ...
                            &lt;path link to the user&gt;
                            ...
                        ]
                    }
                    </code>
                </pre>
                If the request has the pagSize param:
                <pre>
                    <code>
                      {
                        "data": [
                            ...
                            {
                                "id": &lt;id&gt;,
                                "username": &lt;username&gt;,
                                "email": &lt;email&gt;,
                                "firstname": &lt;firstname&gt;,
                                "lastname": &lt;lastname&gt;,
                                "pic": &lt;pic&gt;,
                                  "role": {
                                    "name": &lt;name&gt;
                                    "description": &lt;description&gt;
                                }
                            }
                            ...
                        ],
                        "links": {
                            &lt;links to move through the pages&gt;
                        },
                        "meta": {
                            &lt;meta information about the pages&gt;
                        }
                    }
                    </code>
                </pre>
                If the request has only the username param:
                <pre>
                    <code>
                      {
                        "data": [
                            ...
                            {
                                "id": &lt;id&gt;,
                                "username": &lt;username&gt;,
                                "email": &lt;email&gt;,
                                "firstname": &lt;firstname&gt;,
                                "lastname": &lt;lastname&gt;,
                                "pic": &lt;pic&gt;,
                                "role": {
                                    "name": &lt;name&gt;
                                    "description": &lt;description&gt;
                                }
                            }
                            ...
                        ]
                    }
                    </code>
                </pre>
            </div>
        </li>
        <li>
            <h3><b>GET:</b>
                <pre>/{user_id}</pre>
            </h3>
            <p>Gets information about a specific user</p>
            <div>
                <b>Response Body:</b>
                <pre>
                    <code>
                      {
                        "data": {
                            "id": &lt;id&gt;,
                            "username": &lt;username&gt;,
                            "email": &lt;email&gt;,
                            "firstname": &lt;firstname&gt;,
                            "lastname": &lt;lastname&gt;,
                            "pic": &lt;pic&gt;,
                            "role": {
                                "name": &lt;name&gt;
                                "description": &lt;description&gt;
                            }
                        }
                    }
                    </code>
                </pre>
            </div>
        </li>
        <li>
            <h3><b>POST:</b>
                <pre>/</pre>
            </h3>
            <p>Creates a new user</p>
            <div>
                <h4>Request body:</h4>
                <pre>
                    <code>
                      {
                        "username" (required|min:4): &lt;username&gt;,
                        "password" (required|min:5): &lt;password&gt;,
                        "email"(required): &lt;email&gt;,
                        "firstname": &lt;firstname&gt;,
                        "lastname": &lt;lastname&gt;,
                        "pic": &lt;pic&gt;
                      }
                    </code>
                </pre>
                <h4>Response Body:</h4>
                <pre>
                    <code>

                        HTTP STATUS: 201

                        {
                            "self": &lt;path link to the user&gt;
                        }

                    </code>
                </pre>
            </div>
        </li>
        <li>
            <h3><b>PUT:</b>
                <pre>/{user_id}</pre>
            </h3>
            <p>Updates an existing user</p>
            <p><b>NB:</b> A user can only be updated by himself or an admin user</p>
            <div>
                <h4>Request body:</h4>
                All the attributes are not required. Only the attributes send with the request will be updated for the
                user,
                the others not sent will still be the same.
                <pre>
                    <code>
                      {
                        "username" (not blank if present|min:4): &lt;username&gt;,
                        "password" (not blank if present|min:5): &lt;password&gt;,
                        "old_password" (required if password attribute is present): &lt;old user password&gt;
                        "email"(not_blank_if_present): &lt;email&gt;,
                        "firstname": &lt;firstname&gt;,
                        "lastname": &lt;lastname&gt;,
                        "pic": &lt;pic&gt;
                      }
                    </code>
                </pre>
                <h4>Response:</h4>
                <pre>
                    <code>
                        HTTP STATUS: 204
                    </code>
                </pre>
            </div>
        </li>
        <li>
            <h3><b>DELETE:</b>
                <pre>/{user_id}</pre>
            </h3>
            <p>Deletes an existing user</p>
            <p><b>NB:</b> A user can only be deleted by himself or an admin user</p>
            <div>
                <h4>Response:</h4>
                <pre>
                    <code>
                        HTTP STATUS: 204
                    </code>
                </pre>
            </div>
        </li>
    </ul>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>
