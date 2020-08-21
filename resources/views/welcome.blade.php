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
                            "id": 2,
                            "username": "aliza.schumm",
                            "email": "junior00@example.org",
                            "firstname": "Bennett",
                            "lastname": "Homenick",
                            "avatar": "http://apollo.test/rest/file/5f4020549c1a0000f10017f1",
                            "role": {
                                "name": "STANDARD",
                                "description": "Standard Role",
                                "created_at": "2020-08-21T11:09:17.000000Z",
                                "updated_at": "2020-08-21T11:09:17.000000Z"
                            },
                            "surveys": [
                                "http://apollo.test/rest/survey/3",
                                "http://apollo.test/rest/survey/11",
                                "http://apollo.test/rest/survey/12"
                            ]
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
                <pre>/?&lt;pag_size=num&username=name&gt;</pre>
            </h3>
            <p>Returns a list of all the users optionally paginated and filtered</p>
            <div>
                <h4>Request Params:</h4>
                <ul>
                    <li>
                        <pre>pag_size</pre>
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
                            "http://apollo.test/rest/user/1",
                            "http://apollo.test/rest/user/2",
                            "http://apollo.test/rest/user/3",
                            "http://apollo.test/rest/user/4"
                        ]
                    }
                    </code>
                </pre>
                If the request has the pag_size param:
                <pre>
                    <code>
                      {
                        "data": [
                            {
                                "id": 1,
                                "username": "admin",
                                "email": "admin@admin.it",
                                "firstname": null,
                                "lastname": null,
                                "avatar": null,
                                "role": {
                                    "name": "ADMIN",
                                    "description": "Admin Role",
                                    "created_at": "2020-08-21T11:09:17.000000Z",
                                    "updated_at": "2020-08-21T11:09:17.000000Z"
                                },
                                "surveys": [
                                    "http://apollo.test/rest/survey/1",
                                    "http://apollo.test/rest/survey/2",
                                    "http://apollo.test/rest/survey/4",
                                    "http://apollo.test/rest/survey/5",
                                    "http://apollo.test/rest/survey/6",
                                    "http://apollo.test/rest/survey/7",
                                    "http://apollo.test/rest/survey/8",
                                    "http://apollo.test/rest/survey/9",
                                    "http://apollo.test/rest/survey/10"
                                ]
                            },
                            {
                                "id": 2,
                                "username": "aliza.schumm",
                                "email": "junior00@example.org",
                                "firstname": "Bennett",
                                "lastname": "Homenick",
                                "avatar": "http://apollo.test/rest/file/5f4020549c1a0000f10017f1",
                                "role": {
                                    "name": "STANDARD",
                                    "description": "Standard Role",
                                    "created_at": "2020-08-21T11:09:17.000000Z",
                                    "updated_at": "2020-08-21T11:09:17.000000Z"
                                },
                                "surveys": [
                                    "http://apollo.test/rest/survey/3",
                                    "http://apollo.test/rest/survey/11",
                                    "http://apollo.test/rest/survey/12"
                                ]
                            }
                        ],
                        "links": {
                            "first": "http://apollo.test/rest/user?page=1",
                            "last": "http://apollo.test/rest/user?page=2",
                            "prev": null,
                            "next": "http://apollo.test/rest/user?page=2"
                        },
                        "meta": {
                            "current_page": 1,
                            "from": 1,
                            "last_page": 2,
                            "path": "http://apollo.test/rest/user",
                            "per_page": "2",
                            "to": 2,
                            "total": 4
                        }
                    }
                    </code>
                </pre>
                If the request has only the username param:
                <pre>
                    <code>
                      {
                        "data": [
                            {
                                "id": 2,
                                "username": "aliza.schumm",
                                "email": "junior00@example.org",
                                "firstname": "Bennett",
                                "lastname": "Homenick",
                                "avatar": "http://apollo.test/rest/file/5f4020549c1a0000f10017f1",
                                "role": {
                                    "name": "STANDARD",
                                    "description": "Standard Role",
                                    "created_at": "2020-08-21T11:09:17.000000Z",
                                    "updated_at": "2020-08-21T11:09:17.000000Z"
                                },
                                "surveys": [
                                    "http://apollo.test/rest/survey/3",
                                    "http://apollo.test/rest/survey/11",
                                    "http://apollo.test/rest/survey/12"
                                ]
                            }
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
                            "id": 2,
                            "username": "aliza.schumm",
                            "email": "junior00@example.org",
                            "firstname": "Bennett",
                            "lastname": "Homenick",
                            "avatar": "http://apollo.test/rest/file/5f4020549c1a0000f10017f1",
                            "role": {
                                "name": "STANDARD",
                                "description": "Standard Role",
                                "created_at": "2020-08-21T11:09:17.000000Z",
                                "updated_at": "2020-08-21T11:09:17.000000Z"
                            },
                            "surveys": [
                                "http://apollo.test/rest/survey/3",
                                "http://apollo.test/rest/survey/11",
                                "http://apollo.test/rest/survey/12"
                            ]
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
            <p>Creates a new user. Don't need authorization.</p>
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
                        "avatar": {
                            "name": &lt;filename&gt;,
                            "data": &lt;filedata&gt;
                        }
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
                        "avatar": &lt;new object representing the file or "delete" to only delete the current icon&gt;
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
<div class="section">
    <h2>Survey (../survey)</h2>
    <ul>
        <li>
            <h3>
                <b>GET:</b>
                <pre>/?user_id=&lt;user_id&gt;&pag_size=&lt;pag_size&gt;&name=&lt;name&gt;&start_date=&lt;start_date&gt;&end_date=&lt;end_date&gt;</pre>
            </h3>
            Returns the list of surveys eventually filtered and paginated.
            <h4>Request Params</h4>
            <ul>
                <li>
                    <pre>pag_size</pre>
                    <div>
                        Paginates the results with the defined number of surveys per page
                    </div>
                </li>
                <li>
                    <pre>user_id</pre>
                    <div>
                        Filters the surveys by the user creator
                    </div>
                </li>
                <li>
                    <pre>name</pre>
                    <div>
                        Filters the surveys by their name
                    </div>
                </li>
                <li>
                    <pre>start_date</pre>
                    <div>
                        Filters the survey by start_date field
                    </div>
                </li>
                <li>
                    <pre>end_date</pre>
                    <div>
                        Filters the survey by end_date field
                    </div>
                </li>
            </ul>
            <h4>Response body</h4>
            <p>If request has no params:</p>
            <pre>
                <code>
                    {
                        "data": [
                            "http://apollo.test/rest/survey/1",
                            "http://apollo.test/rest/survey/2",
                            "http://apollo.test/rest/survey/3",
                            "http://apollo.test/rest/survey/4",
                            "http://apollo.test/rest/survey/5",
                            "http://apollo.test/rest/survey/6",
                            "http://apollo.test/rest/survey/7",
                            "http://apollo.test/rest/survey/8",
                            "http://apollo.test/rest/survey/9",
                            "http://apollo.test/rest/survey/10",
                            "http://apollo.test/rest/survey/11",
                            "http://apollo.test/rest/survey/12"
                        ]
                    }
                </code>
            </pre>
            <p>If request has the pag_size attribute:</p>
            <pre>
                <code>
                    {
                        "data": [
                            {
                                "id": 1,
                                "name": "eligendi",
                                "description": "Voluptas atque vel fuga.",
                                "icon": null,
                                "secret": 0,
                                "active": 1,
                                "start_date": "2016-07-31T00:00:00.000000Z",
                                "end_date": "1981-01-24T00:00:00.000000Z",
                                "url_id": "http://schneider.com/sint-eum-numquam-doloremque-eaque-numquam-in-debitis.html",
                                "user": "http://apollo.test/rest/user/1",
                                "question_groups": [
                                    "http://apollo.test/rest/questionGroup/1",
                                    "http://apollo.test/rest/questionGroup/2"
                                ]
                            },
                            {
                                "id": 2,
                                "name": "eius",
                                "description": "Dolore aut aut magnam.",
                                "icon": null,
                                "secret": 0,
                                "active": 1,
                                "start_date": "2009-12-01T00:00:00.000000Z",
                                "end_date": "2006-09-26T00:00:00.000000Z",
                                "url_id": "http://www.koch.org/",
                                "user": "http://apollo.test/rest/user/1",
                                "question_groups": [
                                    "http://apollo.test/rest/questionGroup/3",
                                    "http://apollo.test/rest/questionGroup/4"
                                ]
                            }
                        ],
                        "links": {
                            "first": "http://apollo.test/rest/survey?page=1",
                            "last": "http://apollo.test/rest/survey?page=6",
                            "prev": null,
                            "next": "http://apollo.test/rest/survey?page=2"
                        },
                        "meta": {
                            "current_page": 1,
                            "from": 1,
                            "last_page": 6,
                            "path": "http://apollo.test/rest/survey",
                            "per_page": "2",
                            "to": 2,
                            "total": 12
                        }
                    }
                </code>
            </pre>
            <p>If request has one of the query attributes different from pag_size:</p>
            <pre>
                <code>
                    {
                        "data": [
                            {
                                "id": 3,
                                "name": "excepturi",
                                "description": "Qui vel et qui sapiente et et.",
                                "icon": null,
                                "secret": 0,
                                "active": 1,
                                "start_date": "2005-09-03T00:00:00.000000Z",
                                "end_date": "1970-05-29T00:00:00.000000Z",
                                "url_id": "http://www.batz.com/et-itaque-hic-sunt-autem-praesentium-magni",
                                "user": "http://apollo.test/rest/user/2",
                                "question_groups": []
                            },
                            {
                                "id": 11,
                                "name": "test",
                                "description": "adadasdasdasd",
                                "icon": "http://apollo.test/rest/file/5f401e009c1a0000f10017ef",
                                "secret": 0,
                                "active": 0,
                                "start_date": null,
                                "end_date": null,
                                "url_id": null,
                                "user": "http://apollo.test/rest/user/2",
                                "question_groups": []
                            },
                            {
                                "id": 12,
                                "name": "prova",
                                "description": null,
                                "icon": "http://apollo.test/rest/file/5f401e059c1a0000f10017f0",
                                "secret": 1,
                                "active": 0,
                                "start_date": "2020-06-20T00:00:00.000000Z",
                                "end_date": null,
                                "url_id": null,
                                "user": "http://apollo.test/rest/user/2",
                                "question_groups": []
                            }
                        ]
                    }
                </code>
            </pre>
        </li>
        <li>
            <h3>
                <b>GET</b>
                <pre>/{survey_id}</pre>
            </h3>
            <p>Returns information for a specific survey:</p>
            <h4>Response Body</h4>
            <pre>
                <code>
                    {
                        "data": {
                            "id": 1,
                            "name": "eligendi",
                            "description": "Voluptas atque vel fuga.",
                            "icon": null,
                            "secret": 0,
                            "active": 1,
                            "start_date": "2016-07-31T00:00:00.000000Z",
                            "end_date": "1981-01-24T00:00:00.000000Z",
                            "url_id": "http://schneider.com/sint-eum-numquam-doloremque-eaque-numquam-in-debitis.html",
                            "user": "http://apollo.test/rest/user/1",
                            "question_groups": [
                                "http://apollo.test/rest/questionGroup/1",
                                "http://apollo.test/rest/questionGroup/2"
                            ]
                        }
                    }
                </code>
            </pre>
        </li>
        <li>
            <h3>
                <b>POST</b>
                <pre>/</pre>
            </h3>
            <p>
                Creates a new survey
            </p>
            <h4>Request Body</h4>
            <pre>
                <code>

                </code>
            </pre>
        </li>
    </ul>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>
